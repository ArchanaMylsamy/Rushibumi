<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\FeedAd;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class ManageFeedAdController extends Controller
{
    public function index()
    {
        $pageTitle = "Manage Feed Ads";
        $feedAds = FeedAd::orderBy('priority', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());
        
        return view('admin.feed_ads.index', compact('feedAds', 'pageTitle'));
    }

    public function create()
    {
        $pageTitle = "Create Feed Ad";
        return view('admin.feed_ads.create', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => ['required', new FileTypeValidate(['jpg', 'jpeg', 'png', 'gif'])],
            'url' => 'nullable|url',
            'ad_type' => 'required|in:1,2', // Only image (1) and GIF (2), no video (3)
            'position' => 'required|in:1,2',
            'status' => 'required|in:0,1',
            'priority' => 'nullable|integer|min:0|max:100',
        ], [
            'title.required' => 'Title is required',
            'image.required' => 'Please upload an ad image or GIF',
            'url.url' => 'Invalid URL format',
        ]);

        $feedAd = new FeedAd();
        $feedAd->title = $request->title;
        $feedAd->url = $request->url;
        $feedAd->ad_type = $request->ad_type;
        $feedAd->position = $request->position;
        $feedAd->status = $request->status;
        $feedAd->priority = $request->priority ?? 0;

        if ($request->hasFile('image')) {
            try {
                // For GIFs, don't generate thumbnail (preserve animation)
                // For images, generate thumbnail
                $isGif = strtolower($request->image->getClientOriginalExtension()) === 'gif';
                $thumb = $isGif ? null : getFileThumb('thumbnail');
                $feedAd->image = fileUploader($request->image, getFilePath('thumbnail'), getFileSize('thumbnail'), null, $thumb);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the image'];
                return back()->withNotify($notify);
            }
        }

        $feedAd->save();

        $notify[] = ['success', 'Feed ad created successfully'];
        return redirect()->route('admin.feed_ads.index')->withNotify($notify);
    }

    public function edit($id)
    {
        $feedAd = FeedAd::findOrFail($id);
        $pageTitle = "Edit Feed Ad";
        return view('admin.feed_ads.edit', compact('feedAd', 'pageTitle'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => ['nullable', new FileTypeValidate(['jpg', 'jpeg', 'png', 'gif'])],
            'video' => ['nullable', new FileTypeValidate(['mp4', 'mov', 'wmv', 'flv', 'avi', 'mkv', 'webm'])],
            'url' => 'nullable|url',
            'ad_type' => 'required|in:1,2,3',
            'position' => 'required|in:1,2',
            'status' => 'required|in:0,1',
            'priority' => 'nullable|integer|min:0|max:100',
        ], [
            'title.required' => 'Title is required',
            'url.url' => 'Invalid URL format',
        ]);

        $feedAd = FeedAd::findOrFail($id);
        $feedAd->title = $request->title;
        $feedAd->url = $request->url;
        $feedAd->ad_type = $request->ad_type;
        $feedAd->position = $request->position;
        $feedAd->status = $request->status;
        $feedAd->priority = $request->priority ?? 0;

        if ($request->hasFile('image')) {
            try {
                $old = $feedAd->image;
                // For GIFs, don't generate thumbnail (preserve animation)
                // For images, generate thumbnail
                $isGif = strtolower($request->image->getClientOriginalExtension()) === 'gif';
                $thumb = $isGif ? null : getFileThumb('thumbnail');
                $feedAd->image = fileUploader($request->image, getFilePath('thumbnail'), getFileSize('thumbnail'), $old, $thumb);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the image'];
                return back()->withNotify($notify);
            }
        }

        $feedAd->save();

        $notify[] = ['success', 'Feed ad updated successfully'];
        return back()->withNotify($notify);
    }

    public function delete($id)
    {
        $feedAd = FeedAd::findOrFail($id);
        $oldImage = $feedAd->image;
        $oldVideo = $feedAd->video;
        
        if ($oldImage) {
            fileManager()->removeFile(getFilePath('thumbnail') . '/' . $oldImage);
        }
        if ($oldVideo) {
            fileManager()->removeFile(getFilePath('video') . '/' . $oldVideo);
        }
        
        $feedAd->delete();

        $notify[] = ['success', 'Feed ad deleted successfully'];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        $feedAd = FeedAd::findOrFail($id);
        $feedAd->status = $feedAd->status == Status::ENABLE ? Status::DISABLE : Status::ENABLE;
        $feedAd->save();

        $notify[] = ['success', 'Status changed successfully'];
        return back()->withNotify($notify);
    }
}
