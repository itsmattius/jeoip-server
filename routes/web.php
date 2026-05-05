<?php

use Illuminate\Support\Facades\Route;
use Jeoip\Server\Http\Controllers\ApiController;

Route::group(['prefix' => 'api'], function () {
    Route::get('/asn', ['as' => 'ip.self.asn', 'uses' => ApiController::class . '@asn']);
    Route::get('/country-code', ['as' => 'ip.self.countryCode', 'uses' => ApiController::class . '@countryCode']);
    Route::get('/country', ['as' => 'ip.self.country', 'uses' => ApiController::class . '@country']);
    Route::get('/city', ['as' => 'ip.self.city', 'uses' => ApiController::class . '@city']);
    Route::get('/json', ['as' => 'ip.self.json', 'uses' => ApiController::class . '@json']);
    Route::get('/query', ['as' => 'ip.self.query', 'uses' => ApiController::class . '@query']);

    Route::get('/ip', ['as' => 'ip.ip', 'uses' => ApiController::class.'@ip']);
    Route::get('/my', ['as' => 'ip.my', 'uses' => ApiController::class.'@ip']);
    Route::get('/{ip}', ['as' => 'ip.info', 'uses' => ApiController::class.'@query']);
    Route::get('/{ip}/country-code', ['as' => 'ip.countryCode', 'uses' => ApiController::class.'@countryCode']);
    Route::get('/{ip}/country', ['as' => 'ip.country', 'uses' => ApiController::class.'@country']);
    Route::get('/{ip}/city', ['as' => 'ip.city', 'uses' => ApiController::class.'@city']);
    Route::get('/{ip}/asn', ['as' => 'ip.asn', 'uses' => ApiController::class.'@asn']);
    Route::get('/{ip}/json', ['as' => 'ip.json', 'uses' => ApiController::class . '@json']);
});
