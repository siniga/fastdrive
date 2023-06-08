<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//resert cache routes
// clear route cache
Route::get('/clear-route-cache', function () {
    Artisan::call('route:cache');
    return 'Routes cache has clear successfully !';
});

//clear config cache
Route::get('/clear-config-cache', function () {
    Artisan::call('config:cache');
    return 'Config cache has clear successfully !';
});

// clear application cache
Route::get('/clear-app-cache', function () {
    Artisan::call('cache:clear');
    return 'Application cache has clear successfully!';
});


// clear view cache
Route::get('/clear-view-cache', function () {
    Artisan::call('view:clear');
    return 'View cache has clear successfully!';
});

Route::post('/register', 'AuthenticationController@register'); 
Route::post('/login', 'AuthenticationController@login'); 
Route::post('/register-with-phone','AuthenticationController@registerWithPhone');
Route::post('/verify-otp','AuthenticationController@verifyOtp');
Route::post('/update/user','AuthenticationController@updateUserData');

Route::group(['middleware' => ['auth:sanctum']], function(){
    //users
    Route::get('/users', 'UserController@index'); 
    Route::get('/users/{id}', 'UserController@show'); 
    Route::post('/users', 'UserController@store'); 
    Route::put('/users/{id}', 'UserController@update');
    Route::delete('/users/{id}', 'UserController@destroy'); 

    //user locations
   
    Route::get('/user/{id}/locations', 'UserLocationController@getUserLocations'); 
    Route::post('/user/location', 'UserLocationController@store');
    Route::put('/user/location', 'UserLocationController@update'); 

    //drivers
    Route::get('/drivers', 'DriverController@index'); 
    Route::get('/drivers/nearby/{status}', 'DriverController@getNearByDrivers');
    Route::get('/drivers/{id}', 'DriverController@show'); 
    Route::put('driver/status/update','DriverController@updateDriverStatus');
    Route::post('/driver', 'DriverController@store'); 
    Route::put('/drivers/{id}', 'DriverController@update'); 
    Route::delete('/drivers/{id}', 'DriverController@destroy'); 
    Route::post('/driver/upload/document', 'DriverController@uploadDocument'); 

    //rides
    Route::get('/rides/driver/{id}', 'RideController@getDriverRides');
    Route::get('/rides/{id}', 'RideController@show');
    Route::post('/rides/request', 'RideController@requestRide');
    Route::post('/rides', 'RideController@store'); 
    Route::put('/rides/{id}', 'RideController@update'); 
    Route::delete('/rides/{id}', 'RideController@destroy'); 


    //payment methods
    Route::get('/payment-methods', 'PaymentMethodController@index'); // Get all payment methods
    Route::get('/payment-methods/{id}', 'PaymentMethodController@show'); // Get a specific payment method
    Route::post('/payment-methods', 'PaymentMethodController@store'); // Create a new payment method
    Route::put('/payment-methods/{id}', 'PaymentMethodController@update'); // Update a payment method
    Route::delete('/payment-methods/{id}', 'PaymentMethodController@destroy'); // Delete a payment method

    //ratings 
    Route::get('/ratings', 'RatingController@index'); // Get all ratings
    Route::get('/ratings/{id}', 'RatingController@show'); // Get a specific rating
    Route::post('/ratings', 'RatingController@store'); // Create a new rating
    Route::put('/ratings/{id}', 'RatingController@update'); // Update a rating
    Route::delete('/ratings/{id}', 'RatingController@destroy'); // Delete a rating



    
});
