<?php

use Illuminate\Support\Facades\Route;
use Modules\Amenity\Http\Controllers\AmenityController;

Route::middleware(['auth', 'web'])->group(function () {
    Route::middleware(['role:super_admin|admin'])->group(function () {
        Route::get('/manage-amenities', [AmenityController::class, 'manageAmenties'])->name('manage.amenities');
        Route::post('/add-amenity', [AmenityController::class, 'addAmenity'])->name('add.amenity');
        Route::post('/edit-amenity/{id}', [AmenityController::class, 'editAmenity'])->name('edit.amenity');
        Route::post('/amenity/toggle', [AmenityController::class, 'toggleAmenity'])->name('amenities.toggle');
        Route::delete('/delete-amenity/{id}', [AmenityController::class, 'deleteAmenity'])->name('delete.amenity');

        // Property Amenity
        Route::get('/property/{property}/amenities', [AmenityController::class, 'propertyAmenities'])->name('property.amenities');
        Route::delete('/property/{property}/amenity/{id}', [AmenityController::class, 'deletePropertyAmenity'])->name('property.amenities.delete');
        Route::post('/property/{property}/amenity', [AmenityController::class, 'addPropertyAmenity'])->name('property.amenities.add');
    });

});
