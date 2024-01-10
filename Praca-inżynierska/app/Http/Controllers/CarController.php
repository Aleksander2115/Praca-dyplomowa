<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Car;
use Illuminate\Support\Facades\Validator;
use Auth;

class CarController extends Controller
{
    public function addCarView(){
        return view('pages.car');
    }

    public function addCar(Request $request){

        $validator = Validator::make($request->all(), [
            'brand' => 'required|min:3|alpha:ascii',
            'model' => 'required|min:3',
            'year_of_production' => 'required|integer|digits:4',
            'licence_plate_number' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $car = Car::create([
            'user_id' => Auth::user()->id,
            'brand' => $request->brand,
            'model' => $request->model,
            'year_of_pr' => $request->year_of_production,
            'licence_plate_num' => $request->licence_plate_number,
            'plug_type' => $request->plug_type
        ]);
        Auth::user()->cars()->save($car);

        return redirect()->route('userCars')->with('status', 'Car successfully added');
    }

    public function deleteCar(Car $car){

        $car->delete();

        return back()->with('alert', 'Car successfully deleted');
    }

    public function editCar(Car $car){
        return view('editCar', ['car'=> $car]);
    }

    public function updateCar(Car $car, Request $request){

        $car->update([
            'brand' => $request->brand,
            'model' => $request->model,
            'year_of_pr' => $request->year_of_production,
            'licence_plate_num' => $request->licence_plate_number,
            'plug_type' => $request->plug_type,
            'updated_at' => now()
        ]);

        return redirect()->route('userCars')->with('status', 'Car successfully updated');
    }

    public function inUse(Car $car){

        if(count(Auth::user()->cars->where('in_use','1')) === 0){
            $car->update(['in_use'=>'1']);
        } else{
            $activeCar = Auth::user()->cars->where('in_use','1')->first();

            $car->update(['in_use'=>'1']);
            $activeCar->update(['in_use'=>'0']);
        }


        return back()->with('status', 'Car in use set to: '.$car->brand.' '.$car->model);
    }

    public function userCarsView(){
        return view('pages.userCars');
    }
}
