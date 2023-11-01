<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Queue;
use App\Models\Charging_station;
use Auth;
use Carbon\Carbon;

class QueueController extends Controller
{
    public function queueView(Charging_station $charging_station){

        //dd(Queue::all()->where('charging_station_id', $charging_station->id)->first()->users->isEmpty());

        //$queue_id = Queue::where('charging_station_id', $charging_station->id)->first()->id;

        if(Queue::all()->where('charging_station_id', $charging_station->id)->first() == null){
            $users = [];
        }else{
            $users = Queue::all()->where('charging_station_id', $charging_station->id)->first()->users;
        }

        return view('queuePage', ['charging_station' => $charging_station, 'users' => $users]);
    }

    public function enroll(Charging_station $charging_station, Request $request){

        if(!Queue::where('charging_station_id', $charging_station->id)->exists()){
            $queue = Queue::create([
                'charging_stations_id' => $charging_station->id,
                'sign_up_time' => Carbon::now()->toDateTimeString(),
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);

            Auth::user()->update([
                'charging_stations_id' => $charging_station->id,
                'sign_up_time' => Carbon::now()->toDateTimeString(),
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);

            $queue->users()->save(Auth::user());

            $charging_station->queues()->save($queue);

        } else{

            Auth::user()->update([
                'charging_stations_id' => $charging_station->id,
                'sign_up_time' => Carbon::now()->toDateTimeString(),
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);

            $queue = Queue::all()->where('charging_station_id', $charging_station->id)->first();

            $queue->users()->save(Auth::user());
        }


        return back();
    }

    public function leave(Charging_station $charging_station){

        $queue = Queue::all()->where('charging_station_id', $charging_station->id)->first();

        Auth::user()->update([
            'sign_up_time' => null,
            'start_time' => null,
            'end_time' => null,
        ]);

        Auth::user()->queue()->dissociate();//do testu ale niby działa
        Auth::user()->save();//do testu ale niby działa

        if($queue->users->isEmpty()){
            $queue->delete();
        }

        return back();
    }
}
