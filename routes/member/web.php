<?php

use App\Http\Controllers\Member\{DashboardController, InvoiceController, BookingController, PackageController, ProfileController, PaymentSuccessController};

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:user'])->group(function() {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::controller(InvoiceController::class)->name('invoice.')->group(function() {
        Route::get('invoice', 'index')->name('index');
        Route::get('invoice/datatables', 'datatables')->name('datatables');
        Route::get('invoice/{invoice:code}/print', 'print')->name('print');
        Route::get('invoice/{invoice:code}', 'show')->name('show');
    });

    Route::controller(BookingController::class)->name('booking')->group(function() {
        Route::get('/booking/{package:id}/{pricing:id}', 'detail')->name('detail');
        Route::post('/booking/{package:id}/{pricing:id}', 'store')->name('store');
    });

    Route::get('packages', [PackageController::class, 'index'])->name('packages');
    Route::get( '/payment-success', [PaymentSuccessController::class, 'index'])->name('paymentsuccess');
    //Route::get( '/invoice-preview', [InvoicePreviewController::class, 'index'])->name('invoiceprev');
    Route::controller(ProfileController::class)->group(function() {
        Route::get('/profile', 'index')->name('profile.index');
        Route::put('profile','update')->name('profile.update');
    });
});

include __DIR__ . '/auth.php';
