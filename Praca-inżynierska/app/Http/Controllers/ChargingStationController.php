<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\Charging_station;

use Auth;


class ChargingStationController extends Controller
{
    public function modPageView(){

        $charging_stations = Charging_station::all()->where('is_verified', '1');

        return view('modPage', ['charging_stations' => $charging_stations]);
    }

    public function addStationView(){
        return view('pages.charging_station');
    }

    public function addStation(Charging_station $charging_station, Request $request){

        if(Auth::user()->roles()->where('role_name', 'mod')->exists()){
            $charging_station = Charging_station::create([
                'postcode' => $request->postcode,
                'city' => $request->city,
                'street' => $request->street,
                'street_number' => $request->street_number,
                'number_of_chargers' => $request->number_of_chargers,
                'is_verified' => '1'
            ]);
            return redirect()->route('modPage');

        } else if(Auth::user()->roles()->where('role_name', 'user')->exists()){
            $charging_station = Charging_station::create([
                'postcode' => $request->postcode,
                'city' => $request->city,
                'street' => $request->street,
                'street_number' => $request->street_number,
                'number_of_chargers' => $request->number_of_chargers,
                'is_verified' => '0'
            ]);
            return redirect()->route('userPage');
        }
    }

    public function editStationView(Charging_station $charging_station){
        return view('editStation', ['charging_station'=>$charging_station]);
    }

    public function updateStation(Charging_station $charging_station, Request $request){

        $charging_station->update([
            'postcode' => $request->postcode,
            'city' => $request->city,
            'street' => $request->street,
            'street_number' => $request->street_number,
            'number_of_chargers' => $request->number_of_chargers,
            'updated_at' => now()
        ]);

        return redirect()->route('modPage');
    }

    public function deleteStation(Charging_station $charging_station){

        $charging_station->delete();

        return redirect()->route('modPage');
    }

    public function verifyStation(Charging_station $charging_station){

        $charging_station->update([
            'is_verified' => '1'
        ]);

        return redirect()->route('station_requests');
    }

    public function stationRequestView(){

        $charging_stations = Charging_station::all()->where('is_verified', '0');

        return view('pages.station_requests', ['charging_stations'=>$charging_stations]);
    }
}
