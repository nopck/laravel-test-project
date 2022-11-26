<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\MainController@index')->name('main-index');

Route::get('/clients', 'App\Http\Controllers\ClientController@index')->name('clients-index');
Route::post('/clients', 'App\Http\Controllers\ClientController@store')->name('clients-store');
Route::get('/clients/{phone_number}', 'App\Http\Controllers\ClientController@show')->name('clients-show');

Route::delete('/clients/{phone_number}/vehicles/{ru_vehicle_registration}', 'App\Http\Controllers\VehicleController@destroy');




