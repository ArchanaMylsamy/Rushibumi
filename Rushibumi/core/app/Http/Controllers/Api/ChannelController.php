<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Constants\Status;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChannelController extends Controller
{
    /**
     * Create Channel API
     */
    public function create(Request $request)
    {
        $user = $request->user();

        // Check if channel already exists
        if ($user->profile_complete == Status::YES) {
            return responseError('channel_exists', ['Channel already exists for this user']);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users|min:6',
            'channel_name' => 'required|string|max:255',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors()->all());
        }

        // Validate username format
        if (preg_match("/[^a-z0-9_]/", trim($request->username))) {
            return responseError('invalid_username', [
                'Username can contain only small letters, numbers and underscore.',
                'No special character, space or capital letters in username.'
            ]);
        }

        // Update channel-specific fields
        $user->channel_name = $request->channel_name;
        $user->slug = slug($request->channel_name) . "-" . $user->id;
        $user->username = $request->username;

        // Handle profile picture upload
        if ($request->hasFile('image')) {
            try {
                $old = $user->image;
                $user->image = fileUploader($request->image, getFilePath('userProfile'), getFileSize('userProfile'), $old);
            } catch (\Exception $exp) {
                return responseError('upload_failed', ['Couldn\'t upload the profile picture']);
            }
        }

        $user->profile_complete = Status::YES;
        $user->save();

        return responseSuccess('channel_created', 'Channel created successfully', [
            'channel' => [
                'id' => $user->id,
                'username' => $user->username,
                'channel_name' => $user->channel_name,
                'slug' => $user->slug,
                'image' => getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')),
            ]
        ]);
    }

    /**
     * Get Channel Info
     */
    public function show(Request $request, $userId)
    {
        // Find the requested user's channel
        $user = User::where('id', $userId)
            ->where('profile_complete', Status::YES)
            ->active()
            ->first();

        if (!$user) {
            return responseError('channel_not_found', ['Channel not found']);
        }

        // Get authenticated user to check subscription status
        $authUser = $request->user();
        $isSubscribed = false;
        if ($authUser) {
            $isSubscribed = $user->subscribers()->where('following_id', $authUser->id)->exists();
        }

        return responseSuccess('channel_fetched', 'Channel fetched successfully', [
            'channel' => [
                'id' => $user->id,
                'username' => $user->username,
                'channel_name' => $user->channel_name,
                'slug' => $user->slug,
                'image' => getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')),
                'description' => $user->description ?? null,
                'subscriber_count' => $user->subscribers()->count(),
                'video_count' => $user->videos()->published()->count(),
                'is_subscribed' => $isSubscribed,
            ]
        ]);
    }
}

