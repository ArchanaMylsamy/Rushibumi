<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\UserNotification;
use App\Models\UserReaction;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller {

    public function commentSubmit(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
            'comment_media' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm,gif|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json([
                'status'  => 'error',
                'message' => ['error' => is_array($errors) ? implode(' ', $errors) : $errors],
            ]);
        }

        $video = Video::published()->public()->whereHas('user', function ($query) {
            $query->active();
        })->find($id);

        if (!$video) {
            return response()->json([
                'status'  => 'error',
                'message' => ['error' => 'Video not found'],
            ]);
        }

        $comment           = new Comment();
        $comment->user_id  = auth()->id();
        $comment->video_id = $video->id;
        $comment->comment  = $request->comment;

        // Handle media upload
        if ($request->hasFile('comment_media')) {
            try {
                $file = $request->file('comment_media');
                
                if (!$file->isValid()) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => ['error' => 'Invalid file uploaded'],
                    ]);
                }
                
                $fileType = $file->getMimeType();
                $originalName = $file->getClientOriginalName();
                $fileSize = $file->getSize();
                
                \Log::info('Comment media upload', [
                    'filename' => $originalName,
                    'size' => $fileSize,
                    'mime' => $fileType,
                    'user_id' => auth()->id()
                ]);
                
                // Determine media type
                if (str_starts_with($fileType, 'video/')) {
                    $comment->media_type = 'video';
                } elseif ($fileType === 'image/gif') {
                    $comment->media_type = 'gif';
                } else {
                    return response()->json([
                        'status'  => 'error',
                        'message' => ['error' => 'Invalid file type. Only videos and GIFs are allowed.'],
                    ]);
                }

                // Upload file
                $directory = date("Y") . "/" . date("m") . "/" . date("d");
                // Go up one level from core directory to reach root, then into assets/comments
                $path = dirname(base_path()) . '/assets/comments/' . $directory;
                
                // Ensure directory exists
                if (!is_dir($path)) {
                    mkdir($path, 0755, true);
                }
                
                $filename = fileUploader($file, $path);
                $comment->media_path = $directory . '/' . $filename;
                
                $fullPath = $path . '/' . $filename;
                $publicUrl = asset('assets/comments/' . $comment->media_path);
                $fileExists = file_exists($fullPath);
                
                \Log::info('Comment media saved', [
                    'original_filename' => $originalName,
                    'saved_filename' => $filename,
                    'media_path' => $comment->media_path,
                    'media_type' => $comment->media_type,
                    'full_path' => $fullPath,
                    'public_url' => $publicUrl,
                    'file_exists' => $fileExists,
                    'file_size' => $fileExists ? filesize($fullPath) : 0,
                    'save_location' => 'root/assets/comments/'
                ]);
            } catch (\Exception $e) {
                \Log::error('Comment media upload failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json([
                    'status'  => 'error',
                    'message' => ['error' => 'Failed to upload media file: ' . $e->getMessage()],
                ]);
            }
        }

        $comment->save();
        
        // Reload comment to ensure all relationships and attributes are fresh
        $comment->refresh();
        $comment->load('user');

        $comment->user_image = $comment->user->image;
        $comment->user_name  = $comment->user->fullname;
        
        // Log comment details for debugging
        \Log::info('Comment saved', [
            'comment_id' => $comment->id,
            'has_media' => !empty($comment->media_path),
            'media_path' => $comment->media_path,
            'media_type' => $comment->media_type,
            'full_url' => $comment->media_path ? asset('assets/comments/' . $comment->media_path) : null
        ]);

        if ($video->user_id != auth()->id()) {

            $userNotification            = new UserNotification();
            $userNotification->user_id   = $video->user_id;
            $userNotification->title     = auth()->user()->fullname . " Comment your video";
            $userNotification->click_url = urlPath('video.play', [$video->id, $video->slug]);
            $userNotification->save();

        }

        $html = view('Template::partials.video.comment', compact('comment'))->render();
        
        // Log the rendered HTML to verify media is included
        \Log::info('Comment HTML rendered', [
            'has_media_tag' => strpos($html, 'comment-media') !== false,
            'has_video_tag' => strpos($html, '<video') !== false,
            'has_img_tag' => strpos($html, '<img') !== false
        ]);

        return response()->json([
            'status' => 'success',
            'data'   => [
                'comment'       => $html,
                'comment_count' => $video->allComments->count(),
            ],
        ]);

    }

    public function replySubmit(Request $request) {

        $validator = Validator::make($request->all(), [
            'comment'  => 'required',
            'reply_to' => 'required|exists:comments,id',
            'comment_media' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm,gif|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json([
                'status'  => 'error',
                'message' => ['error' => is_array($errors) ? implode(' ', $errors) : $errors],
            ]);
        }

        $parentComment = Comment::find($request->reply_to);

        if (!$parentComment) {
            return response()->json([
                'status'  => 'error',
                'message' => ['error' => 'Reply comment not found'],
            ]);
        }

        $comment                  = new Comment();
        $comment->user_id         = auth()->id();
        $comment->replier_user_id = $parentComment->user_id;
        $comment->video_id        = $parentComment->video_id;
        $comment->parent_id       = $parentComment->parent_id == 0 ? $parentComment->id : $parentComment->parent_id;
        $comment->comment         = $request->comment;

        // Handle media upload
        if ($request->hasFile('comment_media')) {
            try {
                $file = $request->file('comment_media');
                
                if (!$file->isValid()) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => ['error' => 'Invalid file uploaded'],
                    ]);
                }
                
                $fileType = $file->getMimeType();
                $originalName = $file->getClientOriginalName();
                $fileSize = $file->getSize();
                
                \Log::info('Reply comment media upload', [
                    'filename' => $originalName,
                    'size' => $fileSize,
                    'mime' => $fileType,
                    'user_id' => auth()->id()
                ]);
                
                // Determine media type
                if (str_starts_with($fileType, 'video/')) {
                    $comment->media_type = 'video';
                } elseif ($fileType === 'image/gif') {
                    $comment->media_type = 'gif';
                } else {
                    return response()->json([
                        'status'  => 'error',
                        'message' => ['error' => 'Invalid file type. Only videos and GIFs are allowed.'],
                    ]);
                }

                // Upload file
                $directory = date("Y") . "/" . date("m") . "/" . date("d");
                // Go up one level from core directory to reach root, then into assets/comments
                $path = dirname(base_path()) . '/assets/comments/' . $directory;
                
                // Ensure directory exists
                if (!is_dir($path)) {
                    mkdir($path, 0755, true);
                }
                
                $filename = fileUploader($file, $path);
                $comment->media_path = $directory . '/' . $filename;
                
                $fullPath = $path . '/' . $filename;
                $publicUrl = asset('assets/comments/' . $comment->media_path);
                $fileExists = file_exists($fullPath);
                
                \Log::info('Reply comment media saved', [
                    'original_filename' => $originalName,
                    'saved_filename' => $filename,
                    'media_path' => $comment->media_path,
                    'media_type' => $comment->media_type,
                    'full_path' => $fullPath,
                    'public_url' => $publicUrl,
                    'file_exists' => $fileExists,
                    'file_size' => $fileExists ? filesize($fullPath) : 0,
                    'save_location' => 'root/assets/comments/'
                ]);
            } catch (\Exception $e) {
                \Log::error('Reply comment media upload failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json([
                    'status'  => 'error',
                    'message' => ['error' => 'Failed to upload media file: ' . $e->getMessage()],
                ]);
            }
        }

        $comment->save();
        
        // Reload comment to ensure all relationships and attributes are fresh
        $comment->refresh();
        $comment->load('user', 'replierUser');

        $comment->user_image = $comment->user->image;
        $comment->user_name  = $comment->user->fullname;

        $comment->replier_user_name = $comment->replierUser->username;
        
        // Log reply comment details for debugging
        \Log::info('Reply comment saved', [
            'comment_id' => $comment->id,
            'has_media' => !empty($comment->media_path),
            'media_path' => $comment->media_path,
            'media_type' => $comment->media_type,
            'full_url' => $comment->media_path ? asset('assets/comments/' . $comment->media_path) : null
        ]);

        if ($parentComment->user_id != auth()->id()) {
            $userNotification            = new UserNotification();
            $userNotification->user_id   = $parentComment->user->id;
            $userNotification->title     = auth()->user()->fullname . " Reply your comment";
            $userNotification->click_url = urlPath('video.play', [$comment->video->id, $comment->video->slug]);
            $userNotification->save();
        }

        if ($comment->user_id != auth()->id()) {
            $userNotification            = new UserNotification();
            $userNotification->user_id   = $parentComment->video->user_id;
            $userNotification->title     = auth()->user()->fullname . ' Reply to ' . $parentComment->user->fullname . ' comment.';
            $userNotification->click_url = urlPath('video.play', [$parentComment->video->id, $parentComment->video->slug]);
            $userNotification->save();

        }

        $html = view('Template::partials.video.comment', compact('comment'))->render();

        return response()->json([
            'status'  => 'success',
            'message' => ['error' => 'Reply successfully submitted'],
            'data'    => [
                'reply'         => $html,
                'comment_count' => $parentComment->video->allComments->count(),
            ],
        ]);

    }

    public function getComment($id) {

        $video = Video::published()->whereHas('user', function ($query) {
            $query->active();
        })->find($id);

        if (!$video) {
            return response()->json([

                'status'  => 'error',
                'message' => ['error' => 'Video not found'],
            ]);
        }

        $sortBy = request()->input('sort_by', 'newest');

        $commentsQuery = $video->comments()
            ->with([
                'user',
                'replies.user',
                'replies.userReactions',
                'userReactions',
            ]);

        switch ($sortBy) {
            case 'oldest':
                $commentsQuery->orderBy('id', 'ASC');
                break;
            case 'top':
                $commentsQuery->withCount([
                    'userReactions as like_count' => function ($query) {
                        $query->where('is_like', Status::YES);
                    },
                    'replies as replies_count'
                ])
                    ->orderByRaw('(like_count * 3) + replies_count DESC')
                    ->orderBy('id', 'DESC');
                break;
            case 'newest':
            default:
                $commentsQuery->orderBy('id', 'DESC');
                break;
        }

        $comments = $commentsQuery->paginate(getPaginate());

        $html = view('Template::partials.video.comments', compact('comments'))->render();

        return response()->json([
            'status' => 'success',
            'data'   => [
                'commentHtml'   => $html,
                'current_page'  => $comments->currentPage(),
                'last_page'     => $comments->lastPage(),
                'total'         => $comments->total(),
                'comment_count' => $video->allComments->count(),
            ],
        ]);
    }

    public function likeDislike(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'is_like' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([

                'status'  => 'error',
                'message' => ['error' => $validator->errors()->all()],
            ]);
        }

        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json([

                'status'  => 'error',
                'message' => ['error', 'The requested comment could not be found'],
            ]);
        }

        $isLike = $request->is_like;
        $userId = auth()->id();

        $existingReaction = $comment->userReactions()->where('user_id', $userId)->first();

        if ($existingReaction) {
            if ($existingReaction->is_like == $isLike) {
                $existingReaction->delete();
                return response()->json([
                    'remark' => $isLike == Status::YES ? 'like_remove' : 'dislike_remove',
                    'status' => 'success',
                    'data'   => [
                        'like_count' => $comment->userReactions()->like()->count(),
                    ],
                ]);
            } else {
                $existingReaction->is_like = $isLike;
                $existingReaction->save();

                if ($comment->user_id != auth()->id()) {
                    $userNotification          = new UserNotification();
                    $userNotification->user_id = $comment->user->id;
                    if ($existingReaction->is_like == Status::YES) {
                        $userNotification->title = auth()->user()->fullname . ' like your comment.';
                    } else {
                        $userNotification->title = auth()->user()->fullname . ' dislike your comment.';
                    }
                    $userNotification->click_url = urlPath('video.play', [$comment->video->id, $comment->video->slug]);
                    $userNotification->save();
                }

                return response()->json([
                    'remark' => $isLike == Status::YES ? 'like' : 'dislike',
                    'status' => 'success',
                    'data'   => [
                        'like_count' => $comment->userReactions()->like()->count(),
                    ],
                ]);
            }
        } else {

            $reaction             = new UserReaction();
            $reaction->user_id    = $userId;
            $reaction->comment_id = $comment->id;
            $reaction->is_like    = $isLike;
            $reaction->save();

            if ($comment->user_id != auth()->id()) {
                $userNotification          = new UserNotification();
                $userNotification->user_id = $comment->user->id;
                if ($reaction->is_like == Status::YES) {

                    $userNotification->title = auth()->user()->fullname . ' like your comment.';
                } else {
                    $userNotification->title = auth()->user()->fullname . ' dislike your comment.';

                }

                $userNotification->click_url = urlPath('video.play', [$comment->video->id, $comment->video->slug]);
                $userNotification->save();
            }

            return response()->json([
                'remark' => $isLike == Status::YES ? 'like' : 'dislike',
                'status' => 'success',
                'data'   => [
                    'like_count' => $comment->userReactions()->like()->count(),
                ],
            ]);
        }

    }

}
