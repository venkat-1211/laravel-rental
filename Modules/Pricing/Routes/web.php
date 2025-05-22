<?php

use Illuminate\Support\Facades\Route;
use Modules\Pricing\Http\Controllers\PricingController;

Route::middleware(['auth', 'web'])->group(function () {
    // Property Pricings
    Route::get('/property/{property}/pricings', [PricingController::class, 'propertyPricings'])->name('property.pricings');
    Route::post('/property/{property}/pricing', [PricingController::class, 'addPropertyPricing'])->name('property.pricings.add');
    Route::post('/edit-pricing/{pricing}', [PricingController::class, 'editPropertyPricing'])->name('edit.pricing');
    Route::post('/pricing/toggle', [PricingController::class, 'togglePricing'])->name('pricing.toggle');
    Route::delete('/property/{property}/pricing/{id}', [PricingController::class, 'deletePropertyPricing'])->name('property.pricings.delete');
});
