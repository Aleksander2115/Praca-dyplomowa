<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\ChargingStationController;
use App\Http\Controllers\QueueController;
use Illuminate\Support\Facades\Route;
use App\Models\Charging_station;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('homePage');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified', 'roleCheck:admin'])->group(function () {
    Route::get('/adminPage', [AdminPageController::class, 'adminRolesView'])->name('adminPage');
    Route::patch('{user}', [AdminPageController::class, 'changeToAdmin'])->name('changeToAdmin');
    Route::patch('/adminPage/{user}', [AdminPageController::class, 'changeToUser'])->name('changeToUser');
    Route::post('/adminPage/{user}', [AdminPageController::class, 'changeToMod'])->name('changeToMod');
});

Route::middleware(['auth', 'verified', 'roleCheck:mod'])->group(function () {
    Route::get('/modPage', [ChargingStationController::class, 'modPageView'])->name('modPage');
    Route::patch('/charging_station/{charging_station}', [ChargingStationController::class, 'editStationView'])->name('editStationView');
    Route::put('/charging_station/{charging_station}', [ChargingStationController::class, 'updateStation'])->name('updateStation');
    Route::delete('/charging_station/{charging_station}', [ChargingStationController::class, 'deleteStation'])->name('deleteStation');
    Route::put('{charging_station}', [ChargingStationController::class, 'verifyStation'])->name('verifyStation');
    Route::get('/pages/station_requests', [ChargingStationController::class, 'stationRequestView'])->name('station_requests');
});

Route::group(['roleCheck' => ['role:mod|user']], function () {
    Route::post('/charging_station', [ChargingStationController::class, 'addStation'])->name('addStation');
    Route::get('/pages/charging_station', [ChargingStationController::class, 'addStationView'])->name('addStationView');
});

Route::middleware(['auth', 'verified', 'roleCheck:user'])->group(function () {
    Route::get('/userPage', [ChargingStationController::class, 'userPageView'])->name('userPage');
    Route::get('/pages/userCars', [CarController::class, 'userCarsView'])->name('userCars');
    Route::get('/pages/car', [CarController::class, 'addCarView'])->name('addCarView');
    Route::post('/car', [CarController::class, 'addCar'])->name('addCar');
    Route::delete('/car/{car}', [CarController::class, 'deleteCar'])->name('deleteCar');
    Route::patch('/car/{car}', [CarController::class, 'editCar'])->name('editCar');
    Route::put('/car/{car}', [CarController::class, 'updateCar'])->name('updateCar');
    Route::any('/pages/userCars/car/{car}', [CarController::class, 'inUse'])->name('inUse');
    Route::get('/queuePage/{charging_station}', [QueueController::class, 'queueView'])->name('queueView');
    Route::post('/queuePage/{charging_station}/enroll', [QueueController::class, 'enroll'])->name('enroll');
    Route::post('/queuePage/{charging_station}/enroll2', [QueueController::class, 'enroll2'])->name('enroll2');
    Route::delete('/queuePage/{charging_station}/leave', [QueueController::class, 'leave'])->name('leave');
    Route::delete('/queuePage/{charging_station}/leave2', [QueueController::class, 'leave2'])->name('leave2');
    Route::post('/userPage', [ChargingStationController::class, 'filter'])->name('filter');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/homePage', function () {
    return view('homePage');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
		Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
		Route::get('maps', ['as' => 'pages.maps', 'uses' => 'App\Http\Controllers\PageController@maps']);
		Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
		Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'App\Http\Controllers\PageController@rtl']);
		Route::get('tables', ['as' => 'pages.tables', 'uses' => 'App\Http\Controllers\PageController@tables']);
		Route::get('typography', ['as' => 'pages.typography', 'uses' => 'App\Http\Controllers\PageController@typography']);
		Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'App\Http\Controllers\PageController@upgrade']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

