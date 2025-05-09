<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\MedicationsController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\XRayController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UltrasoundController;
use App\Http\Controllers\Doctor_noteController;
use App\Http\Controllers\DiagnoseController;




Route::get('/dashboard', [DashboardController::class, 'index']);


Route::prefix('/patients')->group(function () {
    Route::get('/', [PatientsController::class, 'index']); 
    Route::post('/store', [PatientsController::class, 'store']); 
    Route::get('/edit/{id}', [PatientsController::class, 'edit']);
    Route::put('/update/{id}', [PatientsController::class, 'update']); 
    Route::delete('/{id}', [PatientsController::class, 'destroy']);
    Route::get('/re-admission/{id}', [PatientsController::class, 'Re_admission'])->name('patients.re_admission');
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
    Route::get('/search', [MedicationsController::class, 'search'])->name('search');


});
    // Lời dặn
    Route::prefix('doctor_note')->name('doctor_note.')->group(function () {
        Route::get('/', [Doctor_noteController::class, 'index'])->name('index');
        Route::post('/store', [Doctor_noteController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [Doctor_noteController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [Doctor_noteController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [Doctor_noteController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('diagnose')->name('diagnose.')->group(function () {
        Route::get('/', [DiagnoseController::class, 'index'])->name('index');
        Route::post('/store', [DiagnoseController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [DiagnoseController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [DiagnoseController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [DiagnoseController::class, 'destroy'])->name('destroy');
    });
    


Route::prefix('examination')->name('examination.')->group(function () {
    Route::get('/', [ExaminationController::class, 'index'])->name('index');
    Route::post('/store', [ExaminationController::class, 'store'])->name('store');
    Route::post('/store-medication', [ExaminationController::class, 'storeMedication']);
    Route::post('/store-service', [ExaminationController::class, 'storeService']);
    Route::get('/print_prescription/{id}', [ExaminationController::class, 'print_prescription'])->name('print_prescription');
    Route::get('/print_service/{id}', [ExaminationController::class, 'print_service'])->name('print_service');
    
    // X-ray routes
    Route::prefix('x-ray')->name('x-ray.')->group(function () {
        Route::get('/', [XRayController::class, 'index'])->name('index');
        Route::post('/store', [XRayController::class, 'store'])->name('store');
    });
    

    
    // Ultrasound routes
    Route::prefix('ultrasound')->name('ultrasound.')->group(function () {
        Route::get('/', [UltrasoundController::class, 'index'])->name('index');
        Route::post('/store', [UltrasoundController::class, 'store'])->name('store');
    });

    // Test routes
    Route::prefix('test')->name('test.')->group(function () {
        Route::get('/', [TestController::class, 'index']);
        Route::post('/store', [TestController::class, 'store']);
    });

    // ECG routes
    Route::prefix('ecg')->name('ecg.')->group(function () {
        Route::get('/', [XRayController::class, 'showECGForm']);
        Route::post('/store', [XRayController::class, 'store']);
        Route::get('/print/{id}', [XRayController::class, 'print']);
    });

    

});
