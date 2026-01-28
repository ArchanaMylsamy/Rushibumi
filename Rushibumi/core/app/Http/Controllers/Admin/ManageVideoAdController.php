<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\VideoAd;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class ManageVideoAdController extends Controller
{
    public function index()
    {
        $pageTitle = "Manage Video Ads";
        $videoAds = VideoAd::orderBy('id', 'desc')
            ->paginate(getPaginate());
        
        return view('admin.video_ads.index', compact('videoAds', 'pageTitle'));
    }

    public function create()
    {
        $pageTitle = "Create Video Ad";
        return view('admin.video_ads.create', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video' => ['required', new FileTypeValidate(['mp4', 'mov', 'wmv', 'flv', 'avi', 'mkv', 'webm'])],
            'thumbnail' => ['nullable', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'url' => 'nullable|url',
            'ad_type' => 'required|in:1,2,3',
            'skip_after' => 'nullable|integer|min:0|max:30',
            'status' => 'required|in:0,1',
        ], [
            'title.required' => 'Title is required',
            'video.required' => 'Please upload a video file',
            'url.url' => 'Invalid URL format',
        ]);

        $videoAd = new VideoAd();
        $videoAd->title = $request->title;
        $videoAd->url = $request->url;
        $videoAd->ad_type = $request->ad_type;
        $videoAd->skip_after = $request->skip_after ?? 5;
        $videoAd->status = $request->status;

        if ($request->hasFile('video')) {
            try {
                $fileName = now()->format('Y/F') . '/' . uniqid() . time() . '.' . $request->video->getClientOriginalExtension();
                $videoAd->video = fileUploader($request->video, getFilePath('video'), null, null, null, $fileName);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the video'];
                return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('thumbnail')) {
            try {
                $videoAd->thumbnail = fileUploader($request->thumbnail, getFilePath('thumbnail'), getFileSize('thumbnail'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the thumbnail'];
                return back()->withNotify($notify);
            }
        }

        $videoAd->save();

        $notify[] = ['success', 'Video ad created successfully'];
        return redirect()->route('admin.video_ads.index')->withNotify($notify);
    }

    public function edit($id)
    {
        $videoAd = VideoAd::findOrFail($id);
        $pageTitle = "Edit Video Ad";
        return view('admin.video_ads.edit', compact('videoAd', 'pageTitle'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video' => ['nullable', new FileTypeValidate(['mp4', 'mov', 'wmv', 'flv', 'avi', 'mkv', 'webm'])],
            'thumbnail' => ['nullable', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'url' => 'nullable|url',
            'ad_type' => 'required|in:1,2,3',
            'skip_after' => 'nullable|integer|min:0|max:30',
            'status' => 'required|in:0,1',
        ], [
            'title.required' => 'Title is required',
            'url.url' => 'Invalid URL format',
        ]);

        $videoAd = VideoAd::findOrFail($id);
        $videoAd->title = $request->title;
        $videoAd->url = $request->url;
        $videoAd->ad_type = $request->ad_type;
        $videoAd->skip_after = $request->skip_after ?? 5;
        $videoAd->status = $request->status;

        if ($request->hasFile('video')) {
            try {
                $old = $videoAd->video;
                $fileName = now()->format('Y/F') . '/' . uniqid() . time() . '.' . $request->video->getClientOriginalExtension();
                $videoAd->video = fileUploader($request->video, getFilePath('video'), null, $old, null, $fileName);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the video'];
                return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('thumbnail')) {
            try {
                $old = $videoAd->thumbnail;
                $videoAd->thumbnail = fileUploader($request->thumbnail, getFilePath('thumbnail'), getFileSize('thumbnail'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the thumbnail'];
                return back()->withNotify($notify);
            }
        }

        $videoAd->save();

        $notify[] = ['success', 'Video ad updated successfully'];
        return back()->withNotify($notify);
    }

    public function delete($id)
    {
        $videoAd = VideoAd::findOrFail($id);
        $oldVideo = $videoAd->video;
        $oldThumbnail = $videoAd->thumbnail;
        
        if ($oldVideo) {
            fileManager()->removeFile(getFilePath('video') . '/' . $oldVideo);
        }
        if ($oldThumbnail) {
            fileManager()->removeFile(getFilePath('thumbnail') . '/' . $oldThumbnail);
        }
        
        $videoAd->delete();

        $notify[] = ['success', 'Video ad deleted successfully'];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        $videoAd = VideoAd::findOrFail($id);
        $videoAd->status = $videoAd->status == Status::ENABLE ? Status::DISABLE : Status::ENABLE;
        $videoAd->save();

        $notify[] = ['success', 'Status changed successfully'];
        return back()->withNotify($notify);
    }
}
