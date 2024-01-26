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

        $charging_cost = $this->calculateChargingCost1($request->start_time, $request->end_time, $charging_station);
        $actualWallet = Auth::user()->money;
        $newWallet = ($actualWallet - $charging_cost) - 5;

        if (count(Auth::user()->cars->where('in_use','1')) === 0){
            return redirect()->route("queueView", $charging_station)->with('alert', 'Select a car before enrolling in the queue');
        }

        foreach ($charging_point->users as $u) {
            if (Carbon::parse($request->start_time)->greaterThan(Carbon::parse($u->start_time)) && Carbon::parse($request->start_time)->lessThan(Carbon::parse($u->end_time))
                || Carbon::parse($request->end_time)->greaterThan(Carbon::parse($u->start_time)) && Carbon::parse($request->end_time)->lessThan(Carbon::parse($u->end_time)))
                return redirect()->route("queueView", $charging_station)->with('alert', 'Charging time is taken');
        }

        if ($newWallet < 0){
            return redirect()->route("queueView", $charging_station)->with('alert', 'Not enough funds');
        }

        if (Auth::user()->charging_point == null || Auth::user()->charging_point->id == $charging_point->id){
            Auth::user()->update([
                'charging_point_id' => $charging_point->id,
                'sign_up_time' => Carbon::now()->toDateTimeString(),
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'money' => $newWallet,
            ]);

            $charging_point->users()->save(Auth::user());

            return redirect()->route("queueView", $charging_station)->with('status', 'Successfully enrolled! Charged - '.$charging_cost.' + service charge (5)');
        } else {
            return redirect()->route("queueView", $charging_station)->with('alert', 'You are enrolled in another queue');
        }
    }

    public function enroll2(Charging_station $charging_station, Request $request){

        $charging_point2 = $charging_station->charging_points->skip(1)->take(1)->first();

        $charging_cost = $this->calculateChargingCost2($request->start_time2, $request->end_time2, $charging_station);
        $actualWallet = Auth::user()->money;
        $newWallet = $actualWallet - $charging_cost - 5;

        if(count(Auth::user()->cars->where('in_use','1')) === 0){
            return redirect()->route("queueView", $charging_station)->with('alert', 'Select a car before enrolling in the queue');
        }

        if(Auth::user()->charging_point != null && Auth::user()->charging_point != $charging_station->charging_points->skip(1)->take(1)->first()){
            return redirect()->route("queueView", $charging_station)->with('alert', 'You are enrolled in another queue' );
        }

        foreach ($charging_point2->users as $u) {
            if (Carbon::parse($request->start_time2)->greaterThanOrEqualTo(Carbon::parse($u->start_time)) && Carbon::parse($request->start_time2)->lessThan(Carbon::parse($u->end_time))
                || Carbon::parse($request->end_time2)->greaterThan(Carbon::parse($u->start_time)) && Carbon::parse($request->end_time2)->lessThanOrEqualTo(Carbon::parse($u->end_time)))
                return redirect()->route("queueView", $charging_station)->with('alert', 'Charging time is taken');
        }

        if($newWallet < 0){
            return redirect()->route("queueView", $charging_station)->with('alert', 'Not enough funds');
        }

        Auth::user()->update([
            'charging_point_id' => $charging_point2->id,
            'sign_up_time' => Carbon::now()->toDateTimeString(),
            'start_time' => $request->start_time2,
            'end_time' => $request->end_time2,
            'money' => $newWallet,
        ]);

        $charging_point2->users()->save(Auth::user());

        return redirect()->route("queueView", $charging_station)->with('status', 'Successfully enrolled! Charged - '.$charging_cost.' + service charge (5)');
    }

    public function leave(Charging_station $charging_station){

        if (Auth::user()->charging_point == null){
            return redirect()->route("queueView", $charging_station)->with('alert', 'You are not enrolled in any queue');
        }

        $charging_cost = $this->calculateChargingCost1(Auth::user()->start_time, Auth::user()->end_time, $charging_station);
        $actualWallet = Auth::user()->money;
        $leavingCharge = $charging_cost / 4;


        if(Carbon::now()->greaterThan(Carbon::parse(Auth::user()->start_time)->subMinutes(20)) && Carbon::now()->lessThan(Carbon::parse(Auth::user()->start_time))){

            if(Auth::user()->charging_point->id == $charging_station->charging_points->first()->id){

                $newWallet = $actualWallet + $leavingCharge;

                Auth::user()->update([
                    'sign_up_time' => null,
                    'start_time' => null,
                    'end_time' => null,
                    'money' => $newWallet,
                ]);

                Auth::user()->charging_point()->dissociate();
                Auth::user()->save();

                return redirect()->route("queueView", $charging_station)->with('status',
                'Exit the queue 20 minutes (or less) before its scheduled start time. Reimbursed 25% of charging_cost ('.$leavingCharge.') + service charge (5)');
            } else {
                return redirect()->route("queueView", $charging_station)->with('alert', 'You are not enrolled in this queue');
            }
        }

        if (Carbon::now()->greaterThan(Carbon::parse(Auth::user()->start_time)) && Carbon::now()->lessThan(Carbon::parse(Auth::user()->end_time)) || Carbon::now()->greaterThan(Carbon::parse(Auth::user()->end_time))){

            if (Auth::user()->charging_point->id == $charging_station->charging_points->first()->id){

                Auth::user()->update([
                    'sign_up_time' => null,
                    'start_time' => null,
                    'end_time' => null,
                ]);

                Auth::user()->charging_point()->dissociate();
                Auth::user()->save();

                return redirect()->route("queueView", $charging_station)->with('status', 'Left the queue while charging or after the end time had passed, costs will not be reimbursed');
            } else {
                return redirect()->route("queueView", $charging_station)->with('alert', 'You are not enrolled in this queue');
            }
        }

        if (Auth::user()->charging_point->id == $charging_station->charging_points->first()->id){

            $newWallet = $actualWallet + $charging_cost;

            Auth::user()->update([
                'sign_up_time' => null,
                'start_time' => null,
                'end_time' => null,
                'money' => $newWallet,
            ]);

            Auth::user()->charging_point()->dissociate();
            Auth::user()->save();

            return redirect()->route("queueView", $charging_station)->with('status', 'Successfully left the queue, charging cost ('.$charging_cost.') has been refunded');
        } else {
            return redirect()->route("queueView", $charging_station)->with('alert', 'You are not enrolled in this queue');
        }
    }

    public function leave2(Charging_station $charging_station){

        if(Auth::user()->charging_point == null){
            return redirect()->route("queueView", $charging_station)->with('alert', 'You are not enrolled in any queue');
        }

        $charging_cost = $this->calculateChargingCost2(Auth::user()->start_time, Auth::user()->end_time, $charging_station);
        $actualWallet = Auth::user()->money;
        $leavingCharge = $charging_cost / 4;

        if(Carbon::now()->greaterThan(Carbon::parse(Auth::user()->start_time)->subMinutes(20)) && Carbon::now()->lessThan(Carbon::parse(Auth::user()->start_time))){

            if(Auth::user()->charging_point->id == $charging_station->charging_points->skip(1)->take(1)->first()->id){

                $newWallet = $actualWallet + $leavingCharge;

                Auth::user()->update([
                    'sign_up_time' => null,
                    'start_time' => null,
                    'end_time' => null,
                    'money' => $newWallet,
                ]);

                Auth::user()->charging_point()->dissociate();
                Auth::user()->save();

                return redirect()->route("queueView", $charging_station)->with('status',
                'Exit the queue 20 minutes (or less) before its scheduled start time. Reimbursed 25% of charging_cost ('.$leavingCharge.') + service charge (5)');
            } else {
                return redirect()->route("queueView", $charging_station)->with('alert', 'You are not enrolled in this queue');
            }
        }

        if (Carbon::now()->greaterThan(Carbon::parse(Auth::user()->start_time)) && Carbon::now()->lessThan(Carbon::parse(Auth::user()->end_time))){

            if (Auth::user()->charging_point->id == $charging_station->charging_points->skip(1)->take(1)->first()->id){

                Auth::user()->update([
                    'sign_up_time' => null,
                    'start_time' => null,
                    'end_time' => null,
                ]);

                Auth::user()->charging_point()->dissociate();
                Auth::user()->save();

                return redirect()->route("queueView", $charging_station)->with('status', 'Left the queue while charging, costs will not be reimbursed');
            } else {
                return redirect()->route("queueView", $charging_station)->with('alert', 'You are not enrolled in this queue');
            }
        }

        if(Auth::user()->charging_point->id == $charging_station->charging_points->skip(1)->take(1)->first()->id){

            $newWallet = $actualWallet + $charging_cost;

            Auth::user()->update([
                'sign_up_time' => null,
                'start_time' => null,
                'end_time' => null,
                'money' => $newWallet,
            ]);

            Auth::user()->charging_point()->dissociate();
            Auth::user()->save();

            return redirect()->route("queueView", $charging_station)->with('status', 'Successfully left the queue, charging cost ('.$charging_cost.') has been refunded');
        } else {
            return redirect()->route("queueView", $charging_station)->with('alert', 'You are not enrolled in this queue');
        }
    }

    public function addMoney(Request $request){

        $updatedFunds = Auth::user()->money + $request->money;

        if($updatedFunds > 9999){
            return back()->with('alert', 'Maximum funds in wallet is 9999');
        }

        Auth::user()->update([
            'money' => $updatedFunds,
        ]);

        return back()->with('status', 'Funds have been added');
    }

    private function calculateChargingCost1(String $start_time, String $end_time, Charging_station $charging_station){

        $charging_point = $charging_station->charging_points->first();

        $start = Carbon::parse($start_time);
        $end = Carbon::parse($end_time);
        $charging_time = $start->diffInMinutes($end);

        $costPerMin = ($charging_point->power * $charging_point->rate_per_kwh) / 60;
        $charging_cost = $costPerMin * $charging_time;

        return $charging_cost;
    }

    private function calculateChargingCost2(String $start_time, String $end_time, Charging_station $charging_station){

        $charging_point2 = $charging_station->charging_points->skip(1)->take(1)->first();

        $start = Carbon::parse($start_time);
        $end = Carbon::parse($end_time);
        $charging_time = $start->diffInMinutes($end);

        $costPerMin = ($charging_point2->power * $charging_point2->rate_per_kwh) / 60;
        $charging_cost = $costPerMin * $charging_time;

        return $charging_cost;
    }
}
