<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Car;

class CarController extends Controller
{
    protected function addCar(array $data){

        $car = Car::create([
            'brand' => $data['brand'],
            'model' => $data['model'],
            'year_of_pr' => $data['year_of_production'],
            'licence_plate_num' => $data['licence_plate_number'],
        ]);

        Auth::user()->cars()->save($car);
    }
}
