<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\UserReaction;
use App\Constants\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReactionController extends Controller
{
    /**
     * Like a video
     */
    public function like(Request $request, $videoId)
    {
        $video = Video::published()->public()
            ->whereHas('user', function ($query) {
                $query->active();
            })
            ->find($videoId);

        if (!$video) {
            return responseError('video_not_found', ['Video not found']);
        }

        $userId = $request->user()->id;

        $existingReaction = $video->userReactions()->where('user_id', $userId)->first();

        if ($existingReaction) {
            if ($existingReaction->is_like == Status::YES) {
                // Already liked, remove like
                $existingReaction->delete();
                return responseSuccess('like_removed', 'Like removed successfully', [
                    'is_liked' => false,
                    'is_disliked' => false,
                    'like_count' => $video->userReactions()->where('is_like', Status::YES)->count(),
                    'dislike_count' => $video->userReactions()->where('is_like', Status::NO)->count(),
                ]);
            } else {
                // Currently disliked, change to like
                $existingReaction->is_like = Status::YES;
                $existingReaction->save();
                return responseSuccess('liked', 'Video liked successfully', [
                    'is_liked' => true,
                    'is_disliked' => false,
                    'like_count' => $video->userReactions()->where('is_like', Status::YES)->count(),
                    'dislike_count' => $video->userReactions()->where('is_like', Status::NO)->count(),
                ]);
            }
        } else {
            // No reaction, create like
            $reaction = new UserReaction();
            $reaction->user_id = $userId;
            $reaction->video_id = $video->id;
            $reaction->video_owner_id = $video->user_id;
            $reaction->is_like = Status::YES;
            $reaction->save();

            return responseSuccess('liked', 'Video liked successfully', [
                'is_liked' => true,
                'is_disliked' => false,
                'like_count' => $video->userReactions()->where('is_like', Status::YES)->count(),
                'dislike_count' => $video->userReactions()->where('is_like', Status::NO)->count(),
            ]);
        }
    }

    /**
     * Dislike a video
     */
    public function dislike(Request $request, $videoId)
    {
        $video = Video::published()->public()
            ->whereHas('user', function ($query) {
                $query->active();
            })
            ->find($videoId);

        if (!$video) {
            return responseError('video_not_found', ['Video not found']);
        }

        $userId = $request->user()->id;

        $existingReaction = $video->userReactions()->where('user_id', $userId)->first();

        if ($existingReaction) {
            if ($existingReaction->is_like == Status::NO) {
                // Already disliked, remove dislike
                $existingReaction->delete();
                return responseSuccess('dislike_removed', 'Dislike removed successfully', [
                    'is_liked' => false,
                    'is_disliked' => false,
                    'like_count' => $video->userReactions()->where('is_like', Status::YES)->count(),
                    'dislike_count' => $video->userReactions()->where('is_like', Status::NO)->count(),
                ]);
            } else {
                // Currently liked, change to dislike
                $existingReaction->is_like = Status::NO;
                $existingReaction->save();
                return responseSuccess('disliked', 'Video disliked successfully', [
                    'is_liked' => false,
                    'is_disliked' => true,
                    'like_count' => $video->userReactions()->where('is_like', Status::YES)->count(),
                    'dislike_count' => $video->userReactions()->where('is_like', Status::NO)->count(),
                ]);
            }
        } else {
            // No reaction, create dislike
            $reaction = new UserReaction();
            $reaction->user_id = $userId;
            $reaction->video_id = $video->id;
            $reaction->video_owner_id = $video->user_id;
            $reaction->is_like = Status::NO;
            $reaction->save();

            return responseSuccess('disliked', 'Video disliked successfully', [
                'is_liked' => false,
                'is_disliked' => true,
                'like_count' => $video->userReactions()->where('is_like', Status::YES)->count(),
                'dislike_count' => $video->userReactions()->where('is_like', Status::NO)->count(),
            ]);
        }
    }

    /**
     * Toggle reaction (like/dislike)
     * This is a unified endpoint that accepts is_like parameter
     */
    public function toggle(Request $request, $videoId)
    {
        $validator = Validator::make($request->all(), [
            'is_like' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors()->all());
        }

        $video = Video::published()->public()
            ->whereHas('user', function ($query) {
                $query->active();
            })
            ->find($videoId);

        if (!$video) {
            return responseError('video_not_found', ['Video not found']);
        }

        $isLike = $request->is_like;
        $userId = $request->user()->id;

        $existingReaction = $video->userReactions()->where('user_id', $userId)->first();

        if ($existingReaction) {
            if ($existingReaction->is_like == $isLike) {
                // Same reaction, remove it
                $existingReaction->delete();
                return responseSuccess($isLike == Status::YES ? 'like_removed' : 'dislike_removed', 
                    $isLike == Status::YES ? 'Like removed successfully' : 'Dislike removed successfully', [
                    'is_liked' => false,
                    'is_disliked' => false,
                    'like_count' => $video->userReactions()->where('is_like', Status::YES)->count(),
                    'dislike_count' => $video->userReactions()->where('is_like', Status::NO)->count(),
                ]);
            } else {
                // Different reaction, change it
                $existingReaction->is_like = $isLike;
                $existingReaction->save();
                return responseSuccess($isLike == Status::YES ? 'liked' : 'disliked', 
                    $isLike == Status::YES ? 'Video liked successfully' : 'Video disliked successfully', [
                    'is_liked' => $isLike == Status::YES,
                    'is_disliked' => $isLike == Status::NO,
                    'like_count' => $video->userReactions()->where('is_like', Status::YES)->count(),
                    'dislike_count' => $video->userReactions()->where('is_like', Status::NO)->count(),
                ]);
            }
        } else {
            // No reaction, create new one
            $reaction = new UserReaction();
            $reaction->user_id = $userId;
            $reaction->video_id = $video->id;
            $reaction->video_owner_id = $video->user_id;
            $reaction->is_like = $isLike;
            $reaction->save();

            return responseSuccess($isLike == Status::YES ? 'liked' : 'disliked', 
                $isLike == Status::YES ? 'Video liked successfully' : 'Video disliked successfully', [
                'is_liked' => $isLike == Status::YES,
                'is_disliked' => $isLike == Status::NO,
                'like_count' => $video->userReactions()->where('is_like', Status::YES)->count(),
                'dislike_count' => $video->userReactions()->where('is_like', Status::NO)->count(),
            ]);
        }
    }

    /**
     * Get video reaction status for current user
     */
    public function status(Request $request, $videoId)
    {
        $video = Video::published()->public()
            ->whereHas('user', function ($query) {
                $query->active();
            })
            ->find($videoId);

        if (!$video) {
            return responseError('video_not_found', ['Video not found']);
        }

        $userId = $request->user()->id;
        $reaction = $video->userReactions()->where('user_id', $userId)->first();

        return responseSuccess('reaction_status', 'Reaction status fetched successfully', [
            'is_liked' => $reaction && $reaction->is_like == Status::YES,
            'is_disliked' => $reaction && $reaction->is_like == Status::NO,
            'like_count' => $video->userReactions()->where('is_like', Status::YES)->count(),
            'dislike_count' => $video->userReactions()->where('is_like', Status::NO)->count(),
        ]);
    }
}

