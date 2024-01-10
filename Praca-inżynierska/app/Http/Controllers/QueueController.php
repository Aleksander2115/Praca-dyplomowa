<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Charging_station;
use App\Models\Charging_point;
use Auth;
use Carbon\Carbon;

class QueueController extends Controller
{
    public function queueView(Charging_station $charging_station){

        if($charging_station->number_of_charging_points === 1){

            $charging_point = $charging_station->charging_points->first();
            $charging_point2 = null;

            if($charging_point->users === null){
                $users = [];
                $users2 = [];
            } else{
                $users = $charging_point->users;
                $users2 = [];
            }

        }else if($charging_station->number_of_charging_points === 2){

            $charging_point = $charging_station->charging_points->first();
            $charging_point2 = $charging_station->charging_points->skip(1)->take(1)->first();

            if($charging_point->users === null){
                $users = [];
            } else{
                $users = $charging_point->users;
            }

            if($charging_point2->users === null){
                $users2 = [];
            } else{
                $users2 = $charging_point2->users;
            }

        }

        return view('queuePage', [
            'charging_station' => $charging_station,
            'users' => $users,
            'users2' => $users2,
            'charging_point' => $charging_point,
            'charging_point2' => $charging_point2
        ]);
    }

    public function enroll(Charging_station $charging_station, Request $request){

        $charging_point = $charging_station->charging_points->first();

        Auth::user()->update([
            'charging_point_id' => $charging_point->id,
            'sign_up_time' => Carbon::now()->toDateTimeString(),
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        $charging_point->users()->save(Auth::user());

        return back();
    }

    public function enroll2(Charging_station $charging_station, Request $request){

        $charging_point2 = $charging_station->charging_points->skip(1)->take(1)->first();

        Auth::user()->update([
            'charging_point_id' => $charging_point2->id,
            'sign_up_time' => Carbon::now()->toDateTimeString(),
            'start_time' => $request->start_time2,
            'end_time' => $request->end_time2,
        ]);

        $charging_point2->users()->save(Auth::user());

        return back();
    }

    public function leave(Charging_station $charging_station){

        if(Auth::user()->charging_point->id == $charging_station->charging_points->first()->id){

            Auth::user()->update([
                'sign_up_time' => null,
                'start_time' => null,
                'end_time' => null,
            ]);

            Auth::user()->charging_point()->dissociate();
            Auth::user()->save();

            return redirect()->route("queueView", $charging_station)->with('status', 'Successfully left the queue');
        } else {
            return redirect()->route("queueView", $charging_station)->with('alert', 'You are not enrolled in this queue');
        }
    }

    public function leave2(Charging_station $charging_station){

        if(Auth::user()->charging_point->id == $charging_station->charging_points->skip(1)->take(1)->first()->id){

            Auth::user()->update([
                'sign_up_time' => null,
                'start_time' => null,
                'end_time' => null,
            ]);

            Auth::user()->charging_point()->dissociate();
            Auth::user()->save();

            return redirect()->route("queueView", $charging_station)->with('status', 'Successfully left the queue');
        } else {
            return redirect()->route("queueView", $charging_station)->with('alert', 'You are not enrolled in this queue');
        }
    }
}
