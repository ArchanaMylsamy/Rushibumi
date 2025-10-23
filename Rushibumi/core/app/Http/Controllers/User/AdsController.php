<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AdPlayDuration;
use App\Models\Video;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    public function adSetting($slug = null)
    {
        if(!$slug){
            $notify[] = ['error'=>'Invalid slug provided'];
            return back()->withNotify($notify);
        }

        $pageTitle = 'Ads Settings';
        $video = Video::authUser()->where('slug', $slug)->first();
        return view('Template::user.ads.setting', compact('pageTitle', 'slug', 'video'));
    }

    public function addPlayDuration(Request $request, $slug=null)
    {
        if(!$slug){
            $notify[] = ['error'=>'Invalid slug provided'];
            return back()->withNotify($notify);
        }

        $request->validate(
            [
                'play_durations.*' => 'required|numeric',
            ],
            [
                'play_durations.*.required' => 'The play duration field is required.',
                'play_durations.*.numeric' => 'The play duration must be a number.',
            ],
        );
        $video = Video::authUser()->where('slug', $slug)->with('adPlayDurations')->firstOrFail();

        if ($video->adPlayDurations) {
            $video->adPlayDurations()->delete();
        }


        if($request->play_durations){

            $play_durations = $request->play_durations;
    
            if (is_array($play_durations)) {
                sort($play_durations);
            }
            
                    foreach ($play_durations as $play_duration) {
            
                        
            
                        $addPlayDuration = new AdPlayDuration();
                        $addPlayDuration->video_id = $video->id;
                        $addPlayDuration->play_duration = $play_duration;
                        $addPlayDuration->save();
                    }
        }

        

        $notify[] = ['success' => 'Add ad play duration.'];
        return back()->withNotify($notify);
    }
}
