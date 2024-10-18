<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ChartOfAccountController;
use App\Http\Controllers\JournalEntryController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('chart-of-accounts', ChartOfAccountController::class);
Route::resource('journal-entries', JournalEntryController::class);
Route::resource('vouchers', VoucherController::class);
Route::resource('sales', SaleController::class);
Route::resource('purchases', PurchaseController::class);
Route::resource('inventory', InventoryController::class);

// Additional routes for reports
Route::get('/reports/trial-balance', [ReportController::class, 'trialBalance'])->name('reports.trial-balance');
Route::get('/reports/balance-sheet', [ReportController::class, 'balanceSheet'])->name('reports.balance-sheet');
Route::get('/reports/profit-loss', [ReportController::class, 'profitloss'])->name('reports.profit-loss');

Route::get('/ledger', [LedgerController::class, 'index'])->name('ledger.index');
Route::get('/ledger/show', [LedgerController::class, 'show'])->name('ledger.show');

Route::get('/payment/form', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');

