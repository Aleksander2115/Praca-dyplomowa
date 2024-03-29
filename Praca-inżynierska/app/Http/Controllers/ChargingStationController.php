<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\Charging_station;
use App\Models\Charging_point;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

use Auth;


class ChargingStationController extends Controller
{
    public function userPageView(){

        $charStat = Charging_station::all()->where('is_verified','1');

        return view('userPage', ['charStat'=>$charStat]);
    }

    public function modPageView(){

        $charging_stations = Charging_station::all()->where('is_verified', '1');

        return view('modPage', ['charging_stations' => $charging_stations]);
    }

    public function addStationView(){
        return view('pages.charging_station');
    }

    public function filter(Request $request, Charging_station $charging_station){

        $charStat = Charging_station::all()->where('is_verified', '1');
        $charging_station = $charging_station->newQuery();

        if ($request->postcode != null) {
            $charging_station->where('postcode', $request->input('postcode'));
        }

        if ($request->plug_type != null){
            $charging_station->whereRelation('charging_points', 'plug_type', $request->input('plug_type'))->get();
        }

        if ($request->is_available_now != null) {
            $charging_station->doesntHave('charging_points.users')->get();
        }

        return view('userPage', ['charStat'=>$charging_station->get()]);
    }

    public function addStation(Charging_station $charging_station, Charging_point $charging_point, Request $request){

        $validator = Validator::make($request->all(), [
            'postcode' => 'required|regex:/^[0-9]{2}-[0-9]{3}/',
            'city' => 'required|string|min:3',
            'street' => 'required|min:3',
            'street_number' => 'required',
        ],
        [
            'postcode.regex' => 'The postcode must be in 00-000 format'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if(Auth::user()->roles()->where('role_name', 'mod')->exists()){
            $charging_station = Charging_station::create([
                'postcode' => $request->postcode,
                'city' => $request->city,
                'street' => $request->street,
                'street_number' => $request->street_number,
                'number_of_charging_points' => $request->number_of_charging_points,
                'is_verified' => '1'
            ]);

            if($request->number_of_charging_points == 1){

                $charging_point = Charging_point::create([
                    'type_of_electric_current' => $request->type_of_electric_current,
                    'plug_type' => $request->plug_type,
                    'power' => $request->power
                ]);

                $charging_station->charging_points()->attach($charging_point->id);

            } else if($request->number_of_charging_points == 2) {
                $charging_point = Charging_point::create([
                    'type_of_electric_current' => $request->type_of_electric_current,
                    'plug_type' => $request->plug_type,
                    'power' => $request->power
                ]);

                $charging_station->charging_points()->attach($charging_point->id);

                $charging_point = Charging_point::create([
                    'type_of_electric_current' => $request->type_of_electric_current2,
                    'plug_type' => $request->plug_type2,
                    'power' => $request->power2
                ]);

                $charging_station->charging_points()->attach($charging_point->id);
            }

            return redirect()->route('modPage')->with('status', 'Charging station successfully added');

        } else if(Auth::user()->roles()->where('role_name', 'user')->exists()){
            $charging_station = Charging_station::create([
                'postcode' => $request->postcode,
                'city' => $request->city,
                'street' => $request->street,
                'street_number' => $request->street_number,
                'number_of_charging_points' => $request->number_of_charging_points,
                'is_verified' => '0'
            ]);

            if($request->number_of_charging_points == 1){

                $charging_point = Charging_point::create([
                    'type_of_electric_current' => $request->type_of_electric_current,
                    'plug_type' => $request->plug_type,
                    'power' => $request->power
                ]);

                $charging_station->charging_points()->attach($charging_point->id);

            } else if($request->number_of_charging_points == 2){
                $charging_point = Charging_point::create([
                    'type_of_electric_current' => $request->type_of_electric_current,
                    'plug_type' => $request->plug_type,
                    'power' => $request->power
                ]);

                $charging_station->charging_points()->attach($charging_point->id);

                $charging_point = Charging_point::create([
                    'type_of_electric_current' => $request->type_of_electric_current2,
                    'plug_type' => $request->plug_type2,
                    'power' => $request->power2
                ]);

                $charging_station->charging_points()->attach($charging_point->id);

            }
            return redirect()->route('userPage')->with('status', 'Charging station successfully suggested');
        }
    }

    public function editStationView(Charging_station $charging_station){
        return view('editStation', [
            'charging_station'=>$charging_station,
            'charging_point'=>$charging_point = $charging_station->charging_points->first(),
            'charging_point2'=>$charging_point2 = $charging_station->charging_points->skip(1)->take(1)->first()]);
    }

    public function updateStation(Charging_station $charging_station, Request $request){

        $charging_station->update([
            'postcode' => $request->postcode,
            'city' => $request->city,
            'street' => $request->street,
            'street_number' => $request->street_number,
            'number_of_charging_points' => $request->number_of_charging_points,
            'updated_at' => now()
        ]);


        if($request->number_of_charging_points == 1){
            $charging_point = $charging_station->charging_points->first();

            $charging_point->update([
                'type_of_electric_current' => $request->type_of_electric_current,
                'plug_type' => $request->plug_type,
                'power' => $request->power
            ]);
        } else if($request->number_of_charging_points == 2){
            $charging_point = $charging_station->charging_points->first();
            $charging_point2 = $charging_station->charging_points->skip(1)->take(1)->first();

            $charging_point->update([
                'type_of_electric_current' => $request->type_of_electric_current,
                'plug_type' => $request->plug_type,
                'power' => $request->power
            ]);

            $charging_point2->update([
                'type_of_electric_current' => $request->type_of_electric_current2,
                'plug_type' => $request->plug_type2,
                'power' => $request->power2
            ]);
        }

        return redirect()->route('modPage')->with('status', 'Charging station successfully updated');
    }

    public function deleteStation(Charging_station $charging_station){

        $id = $charging_station->charging_points->first()->id;

        for($i = 0; $i < $charging_station->number_of_charging_points; ++$i){
            $charging_station->charging_points()->detach($id);
            Charging_point::find($id)->delete();
            $id = $id + 1;
        }

        $charging_station->delete();

        return redirect()->route('modPage')->with('alert', 'Charging station successfully deleted');
    }

    public function verifyStation(Charging_station $charging_station){

        $charging_station->update([
            'is_verified' => '1'
        ]);

        return redirect()->route('station_requests')->with('status', 'Charging station successfully verified');
    }

    public function stationRequestView(){

        $charging_stations = Charging_station::all()->where('is_verified', '0');

        return view('pages.station_requests', ['charging_stations'=>$charging_stations]);
    }
}
