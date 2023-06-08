<?php

namespace App\Http\Controllers;

use App\Models\UserLocation;
use App\Http\Requests\StoreUserLocationRequest;
use App\Http\Requests\UpdateUserLocationRequest;
use Symfony\Component\HttpFoundation\Request;

class UserLocationController extends Controller {
    /**
    * Display a listing of the resource.
    */

    public function index() {
        //
    }

    public function getUserLocations( $id ) {
        $locations = UserLocation::where( 'user_id', $id )->get();
        return response()->json( $locations );
    }

    /**
    * Show the form for creating a new resource.
    */

    public function create() {
        //
    }

    /**
    * Store a newly created resource in storage.
    */

    public function store( Request $request ) {
        //
        $userLocation = UserLocation::create( $request->all() );
        return response()->json( $userLocation );
        
    }

    /**
    * Display the specified resource.
    */

    public function show( Request $request ) {
        //

      
    }

    /**
    * Show the form for editing the specified resource.
    */

    public function edit( UserLocation $userLocation ) {
        //
    }

    /**
    * Update the specified resource in storage.
    */

    public function update( Request $request ) {
        //TODO: update longitude and latitude sent by user
        $userLocation = UserLocation::find( $request->location_id );
        $userLocation->update( $request->all() );
        return response()->json( $userLocation );
    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy( UserLocation $userLocation ) {
        //
    }
}
