<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\ImageController;


/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/
// Auth::routes(['verify'=>true]);
Route::group(
    [
        'middleware' => 'api',
        'namespace'  => 'App\Http\Controllers',
        'prefix'     => 'auth',
    ],
    function ($router) {
        //admin functions
        Route::post('loginAdmin', 'adminController@loginAdmin');
        Route::post('registerAdmin', 'adminController@registerAdmin');
        Route::post('UserTokens', 'adminController@UserTokens');
        Route::post('addTokens', 'adminController@addTokens');


        //user functions
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::post('logout', 'AuthController@logout');
        Route::post('qrtoken', 'AuthController@qrtoken');
        Route::post('mytokens', 'AuthController@mytokens');
        Route::post('buytiket', 'AuthController@buytiket');
        Route::post('image', 'AuthController@image');
        Route::post('imageadd', 'AuthController@addimage');
        Route::get('profile', 'AuthController@profile');
        Route::post('refresh', 'AuthController@refresh');

        //bus driver functions
        Route::post('bustrip', 'TripsController@bustrip');
        Route::post('history', 'TripsController@history');
        Route::post('passengers', 'TripsController@passengers');
        Route::get('days', 'TripsController@days');
        Route::post('getTrips','TripsController@getTrips');
        Route::get('scheduleTrips','TripsController@scheduleTrips');
        Route::post('update','ReservationController@update');
        Route::post('index','ReservationController@index');
        Route::post('show','ReservationController@show');
        Route::get('getCompanyBuses', 'TripsController@getCompanyBuses');
        Route::get('getEmptyBuses', 'TripsController@getEmptyBuses');
        
        

      

       

        //email verification
        Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify'); // Make sure to keep this as your route name
        Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');
    }
);
 

Route::group(
    [
        'middleware' => 'api',
        'namespace'  => 'App\Http\Controllers',
    ],
    function ($router) {
        Route::resource('todos', 'TodoController');
      
    }
);
