<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Faker\Factory as Faker;
use App\Notifications\SendOTP;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

class AuthenticationController extends Controller {

    public function registerWithPhone( Request $request ) {

        //check if phone number exist
        $user = User::where( 'phone_number', '=', $request->phone_number );

        //generate otp
        $otpDetails = $this->generateOtp();

        $isPhoneExist = $user->exists();
        $userData = $user->with('drivers')->first();
        if ( $isPhoneExist ) {
            //update user otp
            $userData->update( [
                'otp' => $otpDetails[ 0 ],
                'otp_expires_at' => $otpDetails[ 1 ]
            ] );

            $token = $userData->createToken( 'authToken' )->plainTextToken;
            return response()->json( [
                'user' =>  $userData ,
                'token' => $token,
                'is_user_exists'=> true
            ] );

        } else {
            //if number doesnt exist register it
            $faker = Faker::create();
            $randomNumber = mt_rand( 10000000, 99999999 );
            $user = User::create( [
                'phone_number' => $request->phone_number,
                'name'=>'Unregistered',
                'email'=>$faker->unique()->safeEmail,
                'password'=>bcrypt( $randomNumber ),
                'otp'=> $otpDetails[ 0 ],
                'otp_expires_at' => $otpDetails[ 1 ]
            ] );
            $token = $user->first()->createToken( 'authToken' )->plainTextToken;

            return response()->json( [
                'user'=>$user,
                'token' => $token,
                'is_user_exists'=> false
            ] );

        }
    }

    public function updateUserData( Request $request ) {
        //check if phone number exist
        $user = User::where( 'phone_number', '=', $request->phone_number );

        $userData = $user->first();

        if ( $userData->email == $request->email ) {
            return  response()->json( [
                'message'=>$request->email.' alread exist, try a different email or login',
                'code'=>500
            ] );

        }
        $user->update( [
            'email' => $request->email,
            'name' => $request->name,
            'is_registered' => $request->is_registered
        ] );

        return response()->json( [
            'user'=>$user->first(),
        ] );
    }

    public function register( Request $request ) {
        $validatedData = $request->validate( [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'phone_number'=>'required|unique:users,phone_number'
        ] );

        $user = User::create( [
            'name' => $validatedData[ 'name' ],
            'email' => $validatedData[ 'email' ],
            'password' => bcrypt( $validatedData[ 'password' ] ),
            'phone_number' => $validatedData[ 'phone_number' ]
        ] );

        $token = $user->createToken( 'authToken' )->plainTextToken;

        return response()->json( [
            'user' => $user,
            'token' => $token
        ] );
    }

    public function login( Request $request ) {
        $validatedData = $request->validate( [
            'email' => 'required|email',
            'password' => 'required'
        ] );

        $user = User::where( 'email', $validatedData[ 'email' ] )->first();

        if ( ! $user || ! Hash::check( $validatedData[ 'password' ], $user->password ) ) {
            throw ValidationException::withMessages( [
                'email' => [ 'The provided credentials are incorrect.' ]
            ] );
        }

        // return $user;
        $token = $user->createToken( 'authToken' )->plainTextToken;

        return response()->json( [ 'token' => $token ] );
    }

    public function logout( Request $request ) {
        $request->user()->tokens()->delete();

        return response()->json( [
            'message' => 'Logged out successfully'
        ] );
    }

    public function generateOtp() {

        // Generate a 4-digit random OTP
        $otp = rand( 1000, 9999 );

        $expireDate = now()->addMinutes( 1 );

        return [ $otp, $expireDate ];

    }

    public function verifyOtp( Request $request ) {
        $otpCode = User::where( 'phone_number', $request->phone )
        ->where( 'otp', $request->otp )
        ->where( 'otp_expires_at', '>', now() )
        ->first();

        if ( $otpCode ) {
            // OTP is valid
            return response()->json( [
                'message' => 'OTP is valid',
                'code'=>200
            ] );
        } else {
            // OTP is invalid
            return response()->json( [
                'message' => 'OTP is invalid',
                'code'=>404
            ] );
        }
    }

}
