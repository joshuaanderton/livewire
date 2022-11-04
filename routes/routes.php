<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
  
    Route::post('api/tall/batch', fn () => [])->name('tall.batch');
    
});