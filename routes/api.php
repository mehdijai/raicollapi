<?php

use Illuminate\Support\Facades\Route;

Route::prefix("v1")->group(function () {
    Route::get('/', function () {
        return [
            "api_version" => env("APP_VERSION"),
            "status" => env("APP_STATUS")
        ];
    });
    require __DIR__ . '/v1/api.php';
});
