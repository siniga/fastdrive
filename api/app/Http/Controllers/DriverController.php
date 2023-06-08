<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller {
    public function index() {
        $drivers = Driver::all();
        return response()->json( $drivers );
    }

    public function getNearByDrivers( $status ) {
        // TODO: change this location to reflect where user is in real time
        $userLat = -6.7635980;
        $userLng = 39.2337060;

        $radius = 10;

        // In kilometers
        $drivers = Driver::select( '*' )
        ->join( 'users', 'users.id', 'drivers.user_id' )
        ->selectRaw( '( 6371 * acos( cos( radians(?) ) *
        cos( radians( latitude ) )
        * cos( radians( longitude ) - radians(?)
        ) + sin( radians(?) ) *
        sin( radians( latitude ) ) )
    ) AS distance', [ $userLat, $userLng, $userLat ] )
        ->havingRaw( 'distance < ?', [ $radius ] )
        ->where( 'status', $status )
        ->orderBy( 'distance' )
        ->get();

        return response()->json( $drivers );

    }

    public function show( $id ) {
        $driver = Driver::find( $id );
        return response()->json( $driver );
    }
    

    public function uploadDocument( Request $request ) {
        if ( $request->hasFile( 'image' ) ) {
            $image = $request->file( 'image' );
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs( 'public/uploads', $filename );

            //add filename to driver db
            $driver = Driver::find( $request->id );

            if ( $request->flag == 1 ) {
                //update avatar
                $driver->update( [ 'avatar'=> $filename ] );

            } else if ( $request->flag == 2 ) {
                //update national identity
                $driver->update( [ 'national_identity'=> $filename ] );
            } else {
                 //update national licence
                $driver->update( [ 'licence'=> $filename ] );
            }

            return response()->json( [ 'message' => 'File uploaded successfully' ], 200 );
        }

        return response()->json( [ 'message' => 'No file uploaded' ], 400 );
    }

    public function updateDriverStatus(Request $request){

        $driver = Driver::findOrFail( $request->id );
        $driver->update( ['status'=> $request->status]);
        return response()->json( $driver );
    }
    public function store( Request $request ) {

        $driverExist = Driver::where( 'vehicle_license_plate', '=', $request->vehicle_license_plate )->exists();

        if ( !$driverExist ) {
            $driver = Driver::create( $request->all() );

            $driverData = Driver::find( $driver->id );
            return response()->json( $driverData );
        } else {
            return response()->json( [
                'message' => 'Number plate already exists',
                'code'=>500
            ] );
        }

    }

    public function update( Request $request, $id ) {
        //TODO:request all is dangerous, change it for more security
        $driver = Driver::find( $id );
        $driver->update( $request->all() );
        return response()->json( $driver );
    }

    public function destroy( $id ) {
        $driver = Driver::find( $id );
        $driver->delete();
        return response()->json( [ 'message' => 'Driver deleted' ] );
    }
}

