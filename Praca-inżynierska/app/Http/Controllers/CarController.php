<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Car;
use Auth;

class CarController extends Controller
{
    public function addCarView(){
        return view('pages.car');
    }

    public function addCar(Request $request){

        $car = Car::create([
            'user_id' => Auth::user()->id,
            'brand' => $request->brand,
            'model' => $request->model,
            'year_of_pr' => $request->year_of_production,
            'licence_plate_num' => $request->licence_plate_number,
        ]);
        Auth::user()->cars()->save($car);

        return redirect()->route('userCars');
    }

    public function deleteCar(Car $car){

        $car->delete();

        return redirect()->route('userCars');
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
            'updated_at' => now()
        ]);

        return redirect()->route('userCars');
    }

    public function userCarsView(){
        return view('pages.userCars');
    }
}
