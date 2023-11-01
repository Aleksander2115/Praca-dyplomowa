<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;

class AdminPageController extends Controller
{
    public function adminRolesView(){

        $users = User::all();

        return view('adminPage', ['users' => $users]);
    }

    public function changeToUser(User $user){

        $user->roles()->sync(2);

        return redirect()->back();
    }

    public function changeToAdmin(User $user){

        $user->roles()->sync(1);

        return redirect()->back();
    }

    public function changeToMod(User $user){

        $user->roles()->sync(3);

        return redirect()->route('adminPage');
    }
}
