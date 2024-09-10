<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// Route::get('/dashboard', function () {
//     return view('layouts.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', [InvoiceController::class, 'index'])->name('dashboard');
    Route::post('/company/store', [InvoiceController::class, 'companyStore'])->name('company.store');
    Route::get('/company/{id}/edit', [InvoiceController::class, 'companyEdit'])->name('company.edit');
    Route::post('/company/update', [InvoiceController::class, 'companyUpdate'])->name('company.update');
    Route::post('/company/logo-update', [InvoiceController::class, 'companyLogoUpdate'])->name('company.updateLogo');
    Route::post('/invoice/register', [InvoiceController::class, 'register'])->name('invoice.register');
    Route::post('/invoice/reset', [InvoiceController::class, 'reset'])->name('invoice.reset');
    Route::get('/invoice/{slug}', [InvoiceController::class, 'workplace'])->name('invoice.workplace');
    Route::post('/invoice-data/store', [InvoiceController::class, 'detailStore'])->name('invoice.detailStore');
    Route::get('/invoice-data/export/{slug}', [InvoiceController::class, 'export'])->name('invoice.export');
    Route::get('/invoice-data/{id}/delete', [InvoiceController::class, 'delete'])->name('invoice.delete');
    Route::post('/invoice-data/store-receipt', [InvoiceController::class, 'receiptStore'])->name('invoice.receiptStore');
    Route::get('/invoice-data/{id}/reset-receipt', [InvoiceController::class, 'receiptReset'])->name('invoice.receiptReset');
    Route::get('/invoice-data/export-receipt/{id}', [InvoiceController::class, 'receiptExport'])->name('invoice.receiptExport');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
