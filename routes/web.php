<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');
Route::patch('/invoices/{invoice}/status', [InvoiceController::class, 'status'])->name('invoices.status');
Route::resource('invoices', InvoiceController::class);
