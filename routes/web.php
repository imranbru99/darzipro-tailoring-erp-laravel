<?php

use App\Http\Controllers\OrderTrackController;
use App\Http\Controllers\PdfReceiptController;
use App\Http\Controllers\PublicPageController;
use Illuminate\Support\Facades\Route;

// Public Showcase & Landing
Route::get('/', [PublicPageController::class, 'home'])->name('home');
Route::get('/catalog', [PublicPageController::class, 'catalog'])->name('catalog.index');
Route::get('/track-order', [OrderTrackController::class, 'index'])->name('order.track');

// Unicode Bangla PDF Receipts & Tokens
Route::get('/orders/{order}/thermal-receipt', [PdfReceiptController::class, 'thermalReceipt'])->name('order.thermal-receipt');
Route::get('/orders/{order}/workshop-token', [PdfReceiptController::class, 'workshopToken'])->name('order.workshop-token');
