<?php

namespace App\Http\Controllers;

use App\Events\SendRequestEvent;
use App\Models\Ride;
use Illuminate\Http\Request;
use App\Models\Trip;

class RideController extends Controller
{
    public function index()
    {
        $trips = Ride::all();
        return response()->json($trips);
    }

    public function getDriverRides($id){
        $trip = Ride::where('driver_id',$id)
            ->join('users','users.id','rides.user_id')
            ->select('rides.*', 'users.name as user_name')
            ->orderBy('rides.id','desc')->get();
        return response()->json($trip);
    }

    public function show($id)
    {
        $trip = Ride::find($id);
        return response()->json($trip);
    }

    public function requestRide(){
        event(new SendRequestEvent("Hii inanifelisha?"));
    }
    
    public function store(Request $request)
    {
        $trip = Ride::create($request->all());
        return response()->json($trip);
    }

    public function update(Request $request, $id)
    {
        $trip = Ride::find($id);
        $trip->update($request->all());
        return response()->json($trip);
    }

    public function destroy($id)
    {
        $trip = Ride::find($id);
        $trip->delete();
        return response()->json(['message' => 'Trip deleted']);
    }
}
