<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountSettingController extends Controller
{
    /**
     * Get Account Settings
     */
    public function show(Request $request)
    {
        $user = $request->user();

        return responseSuccess('account_fetched', 'Account settings fetched successfully', [
            'account' => [
                'id' => $user->id,
                'channel_name' => $user->channel_name,
                'channel_description' => $user->channel_description,
                'slug' => $user->slug,
                'username' => $user->username,
                'image' => getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')),
                'cover_image' => $user->cover_image ? getImage(getFilePath('cover') . '/' . $user->cover_image, getFileSize('cover')) : null,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'bio' => $user->bio,
                'social_links' => $user->social_links,
            ]
        ]);
    }

    /**
     * Update Account Settings
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'channel_name' => 'required|string|max:255',
            'channel_description' => 'nullable|string',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'cover_image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors()->all());
        }

        $user = $request->user();
        $slug = slug($request->channel_name);

        $user->channel_name = $request->channel_name;
        $user->slug = $slug . "-" . $user->id;
        $user->channel_description = $request->channel_description ?? null;

        if ($request->hasFile('image')) {
            $old = $user->image;
            try {
                $user->image = fileUploader($request->image, getFilePath('userProfile'), getFileSize('userProfile'), $old);
            } catch (\Exception $exp) {
                return responseError('upload_failed', ['Couldn\'t upload the profile image']);
            }
        }

        if ($request->hasFile('cover_image')) {
            $old = $user->cover_image;
            try {
                $user->cover_image = fileUploader($request->cover_image, getFilePath('cover'), getFileSize('cover'), $old);
            } catch (\Exception $exp) {
                return responseError('upload_failed', ['Couldn\'t upload the cover image']);
            }
        }

        $user->save();

        return responseSuccess('account_updated', 'Account updated successfully', [
            'account' => [
                'id' => $user->id,
                'channel_name' => $user->channel_name,
                'channel_description' => $user->channel_description,
                'slug' => $user->slug,
                'image' => getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')),
                'cover_image' => $user->cover_image ? getImage(getFilePath('cover') . '/' . $user->cover_image, getFileSize('cover')) : null,
            ]
        ]);
    }

    /**
     * Update Profile Settings (firstname, lastname, bio, social_links)
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'bio' => 'required|string',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|url',
        ], [
            'firstname.required' => 'The first name field is required',
            'lastname.required' => 'The last name field is required',
            'bio.required' => 'The bio field is required',
            'social_links.*.url' => 'Each social link must be a valid URL.',
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors()->all());
        }

        $user = $request->user();

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->bio = $request->bio;
        $user->social_links = $request->social_links ?? null;

        $user->save();

        return responseSuccess('profile_updated', 'Profile updated successfully', [
            'profile' => [
                'id' => $user->id,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'bio' => $user->bio,
                'social_links' => $user->social_links,
            ]
        ]);
    }

    /**
     * Change Password
     */
    public function changePassword(Request $request)
    {
        $passwordValidation = \Illuminate\Validation\Rules\Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols();
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => ['required', 'confirmed', $passwordValidation],
        ], [
            'password.mixed' => 'The password must contain both uppercase and lowercase letters.',
            'password.numbers' => 'The password must contain at least one number.',
            'password.symbols' => 'The password must contain at least one symbol.',
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors()->all());
        }

        $user = $request->user();

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return responseError('invalid_password', ['The current password is incorrect']);
        }

        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();

        return responseSuccess('password_changed', 'Password changed successfully');
    }
}

