<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DriverController extends Controller
{
    public  function index(Request $request){
        $user= $request->user();
        $user->load('driv');

        return $user;
    }

//
    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|numeric',
            'make' => 'required|string',
            'model' => 'required|string',
            'color' => 'required|string',
            'license_plate' => 'required|string',
            'name' => 'required|string',
        ]);

        $user = $request->user();

        $user->update($request->only('name'));

        $user->driv()->updateorCreate($request->only('year', 'make', 'model', 'color', 'license_plate'));

        return $user->load('driv');
    }
}
