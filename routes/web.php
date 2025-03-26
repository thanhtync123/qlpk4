<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\MedicationsController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\XRayController;
use App\Http\Controllers\TestController;



Route::get('/dashboard', [DashboardController::class, 'index']);


Route::prefix('/patients')->group(function () {
    Route::get('/', [PatientsController::class, 'index']); // patient/
    Route::post('/store', [PatientsController::class, 'store']); // patient/store
    Route::get('/edit/{id}', [PatientsController::class, 'edit']);
    Route::put('/update/{id}', [PatientsController::class, 'update']); // patient/{id}
    Route::delete('/{id}', [PatientsController::class, 'destroy']); // patient/{id}
});

Route::prefix('service')->name('service.')->group(function () {
    Route::get('/', [ServicesController::class, 'index'])->name('index');
    Route::post('/store', [ServicesController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [ServicesController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [ServicesController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [ServicesController::class, 'destroy'])->name('delete');
});

Route::prefix('medication')->name('medication.')->group(function () {
    Route::get('/', [MedicationsController::class, 'index'])->name('index');
    Route::post('/store', [MedicationsController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [MedicationsController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [MedicationsController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [MedicationsController::class, 'destroy'])->name('delete');
});


Route::prefix('examination')->name('examination.')->group(function () {
    Route::get('/', [ExaminationController::class, 'index'])->name('index');
    Route::post('/store', [ExaminationController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [ExaminationController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [ExaminationController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [ExaminationController::class, 'destroy'])->name('delete');

    // X-ray routes
    Route::prefix('x-ray')->name('x-ray.')->group(function () {
        Route::get('/', [XRayController::class, 'showXRayForm'])->name('index');
        Route::post('/store', [XRayController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [XRayController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [XRayController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [XRayController::class, 'destroy'])->name('delete');
        Route::get('/print/{id}', [XRayController::class, 'print'])->name('print');
    });

    // Ultrasound routes
    Route::prefix('ultrasound')->name('ultrasound.')->group(function () {
        Route::get('/', [UltrasoundController::class, 'index'])->name('index');
        Route::post('/store', [UltrasoundController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UltrasoundController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [UltrasoundController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UltrasoundController::class, 'destroy'])->name('delete');
    });

    // Test routes
    Route::prefix('test')->name('test.')->group(function () {
        Route::get('/', [XRayController::class, 'showTestForm']);
        Route::post('/store', [XRayTestController::class, 'store']);
        Route::get('/print/{id}', [XRayController::class, 'print']);
        // Route::get('/edit/{id}', [TestController::class, 'edit'])->name('edit');
        // Route::post('/update/{id}', [TestController::class, 'update'])->name('update');
        // Route::delete('/delete/{id}', [TestController::class, 'destroy'])->name('delete');
    });

    // ECG routes
    Route::prefix('ecg')->name('ecg.')->group(function () {
        Route::get('/', [XRayController::class, 'showECGForm']);
        Route::post('/store', [XRayController::class, 'store']);
        Route::get('/print/{id}', [XRayController::class, 'print']);
        // Route::get('/edit/{id}', [EcgController::class, 'edit'])
        // Route::post('/update/{id}', [EcgController::class, 'update'])
        // Route::delete('/delete/{id}', [EcgController::class, 'destroy'])
    });
});
