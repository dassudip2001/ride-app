<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'origin'=> 'required',
            'destination'=> 'required',
            'distinction_name'=> 'required',
        ]);
        $request->user()->trips()->create($request->only(['origin', 'destination', 'distinction_name']));
    }

    public function show(Request $request,$trip)
    {
        if($trip->user->id=== $request->user()->id){
            return $trip;
        }

        if($trip->driver && $request->user()->driver){
            return $trip;
        }
        if($trip->driver->id === $request->user()->driver->id){
            return $trip;
        }
        return response()->json([
            'message' => 'Cannot access this trip'
        ], 401);
    }


    public function accept(Request $request, Trip $trip)
    {

        $request->validate([
            'driver_location' => 'required'
        ]);
        $trip->update([
            'driver_id' => $request->user()->id,
            'driver_location' => $request->driver_location,

        ]);

        $trip->load('driver.user');

        return $trip;
    }

    public function start(Request $request, Trip $trip)
    {
            $trip->update([
                'is_started' => true
            ]);
            return $trip->load('driver.user');
    }


    public function end(Request $request, Trip $trip)
    {
        $trip->update([
            'is_complete' => true
        ]);
        return $trip->load('driver.user');
    }


    public function location(Request $request, Trip $trip)
    {
        $request->validate([
            'driver_location' => 'required'
        ]);
        $trip->update([
            'driver_location' => $request->driver_location
        ]);
        return $trip->load('driver.user');
    }


}
