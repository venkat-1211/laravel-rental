<?php

use Illuminate\Support\Facades\Route;
use Modules\Property\Http\Controllers\BookingController;
use Modules\Property\Http\Controllers\CouponController;
use Modules\Property\Http\Controllers\PaymentController;
use Modules\Property\Http\Controllers\PropertyController;
use Modules\Property\Http\Controllers\SpecialDayController;

Route::get('/property/test', [PropertyController::class, 'index']);

Route::middleware(['auth', 'web'])->group(function () {
    Route::middleware(['role:super_admin|admin'])->group(function () {
        Route::get('/manage-properties', [PropertyController::class, 'manageProperties'])->name('manage.properties');
        Route::post('/add-property', [PropertyController::class, 'addProperty'])->name('add.property');
        Route::put('/edit-property/{property}', [PropertyController::class, 'editProperty'])->name('edit.property');
        Route::delete('/delete-property/{property}', [PropertyController::class, 'deleteProperty'])->name('delete.property');
        Route::post('/property/remove-image/{property_image}', [PropertyController::class, 'PropertyRemoveImage'])->name('property.remove-image');

        // Property Image
        Route::get('/property/{property}/images', [PropertyController::class, 'propertyImages'])->name('property.images');
        Route::delete('/property/{property}/image/{id}', [PropertyController::class, 'deletePropertyImage'])->name('property.images.delete');
        Route::post('/property/{property}/image', [PropertyController::class, 'addPropertyImage'])->name('property.images.add');

        // Special Days
        Route::get('/manage-special-days', [SpecialDayController::class, 'index'])->name('manage.special.days');
        Route::post('/add-special-day', [SpecialDayController::class, 'addSpecialDay'])->name('add.special.day');
        Route::put('/edit-special-day/{special_day}', [SpecialDayController::class, 'editSpecialDay'])->name('edit.special.day');
        Route::delete('/delete-special-day/{id}', [SpecialDayController::class, 'deleteSpecialDay'])->name('delete.special.day');
        Route::post('/special-day/toggle', [SpecialDayController::class, 'toggleSpecialDay'])->name('special.day.toggle');

        // Coupons
        Route::get('/manage-coupons', [CouponController::class, 'index'])->name('manage.coupons');
        Route::post('/add-coupon', [CouponController::class, 'addCoupon'])->name('add.coupon');
        Route::post('/remove-coupon-property/{coupon}', [CouponController::class, 'removeCouponProperty'])->name('remove.coupon.property');
        Route::post('/coupon/toggle', [CouponController::class, 'toggleCoupon'])->name('coupon.toggle');
        Route::delete('/delete-coupon/{coupon}', [CouponController::class, 'deleteCoupon'])->name('delete.coupon');
        Route::put('/edit-coupon/{coupon}', [CouponController::class, 'editCoupon'])->name('edit.coupon');
    });

    Route::get('/property/{property}/details', [PropertyController::class, 'propertyDetails'])->name('property.details');

    // Bookings
    Route::get('/property/{property}/make-booking', [BookingController::class, 'makeBooking'])->name('make.booking');
    Route::post('/property/{property}/apply-coupon', [BookingController::class, 'applyCoupon'])->name('apply.coupon');
    Route::get('/manage-bookings', [BookingController::class, 'manageBookings'])->name('manage.bookings');
    Route::get('/property/{property}/view-booking/{booking}', [BookingController::class, 'viewBooking'])->name('view.booking');

    // Payment
    Route::post('/property/{property}/make-payment', [PaymentController::class, 'initiatePayment'])->name('phonepe.initiate');
    Route::post('/payment/callback', [PaymentController::class, 'paymentCallback'])->name('phonepe.callback');
});
