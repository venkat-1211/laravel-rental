<?php

use Illuminate\Support\Facades\Route;
use Modules\Nearby\Http\Controllers\NearbyController;

Route::middleware(['auth', 'web'])->group(function () {
    // Property Pricings
    Route::get('/property/{property}/nearbies', [NearbyController::class, 'propertyNearbies'])->name('property.nearbies');
    Route::post('/property/{property}/nearby', [NearbyController::class, 'addPropertyNearby'])->name('property.nearbies.add');
    Route::post('/nearby/toggle', [NearbyController::class, 'toggleNearby'])->name('nearby.toggle');
    Route::delete('/property/{property}/nearby/{id}', [NearbyController::class, 'deletePropertyNearby'])->name('property.nearbies.delete');
});
