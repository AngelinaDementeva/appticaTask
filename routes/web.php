<?php

use App\Http\Controllers\AppTopCategoryController;
use App\Http\Middleware\LogRequestMiddleware;

Route::middleware(['throttle:5,1', LogRequestMiddleware::class])->group(function () {
    Route::get('/appTopCategory', [AppTopCategoryController::class, 'index']);
}
);
