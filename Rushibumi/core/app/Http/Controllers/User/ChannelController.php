<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\GatewayCurrency;
use App\Models\Playlist;
use App\Rules\FileTypeValidate;
use App\Traits\ChannelManager;
use Illuminate\Http\Request;

class ChannelController extends Controller {
    use ChannelManager;

    public function create() {

        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }
        $pageTitle  = "Create Channel";
        return view('Template::user.channel.form', compact('pageTitle'));
    }

    public function channelDataSubmit(Request $request) {

        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $request->validate([
            'username'     => 'required|unique:users|min:6',
            'channel_name' => 'required|string|max:255',
            'image'        => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        if (preg_match("/[^a-z0-9_]/", trim($request->username))) {
            $notify[] = ['info', 'Username can contain only small letters, numbers and underscore.'];
            $notify[] = ['error', 'No special character, space or capital letters in username.'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        // Only update channel-specific fields
        // Phone, name, and other personal info are already collected during registration
        $user->channel_name = $request->channel_name;
        $user->slug         = slug($request->channel_name) . "-" . $user->id;
        $user->username     = $request->username;

        // Handle profile picture upload
        if ($request->hasFile('image')) {
            $old = $user->image;
            try {
                $user->image = fileUploader($request->image, getFilePath('userProfile'), getFileSize('userProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the profile picture'];
                return back()->withNotify($notify);
            }
        }

        $user->profile_complete = Status::YES;
        $user->save();

        $notify[] = ['success', 'Channel created successfully.'];
        return to_route('user.home')->withNotify($notify);
    }

    public function playlistFetch($id) {

        $playlists = Playlist::where('user_id', $id)
            ->with([
                'user',
                'videos' => function ($q) {
                    $q->public()->published()->regular();
                },
            ])->whereHas('user', function ($query) {
            $query->active();
        })
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());

        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('name')->get();

        $html = view('Template::partials.playlist_list', compact('playlists', 'gatewayCurrency', ))->render();

        return response()->json([
            'remark' => 'playlists',
            'status' => 'success',
            'data'   => [
                'playlists'    => $html,
                'current_page' => $playlists->currentPage(),
                'last_page'    => $playlists->lastPage(),
            ],
        ]);

    }

}
