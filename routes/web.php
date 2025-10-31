<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BelaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\NonTenderController;
use App\Http\Controllers\SatkerController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\EkatalogReportController;
use App\Http\Controllers\TokoDaringReportController;
use App\Services\NonTenderService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StrukturAnggaranController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MonitoringController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [FrontController::class, 'index'])->middleware('guest')->name('front');
Route::post('/', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::get('/graph-report', [FrontController::class, 'report'])->name('report');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::group([
    'prefix' => 'non-tender',
    'as' => 'non-tender.',
    'middleware' => 'auth',
], function() {
    Route::get('/list', [NonTenderController::class, 'index'])->name('list');
    Route::get('/show/{code}', [NonTenderController::class, 'show'])->name('show');
    Route::get('/realization', [NonTenderController::class, 'realization'])->name('realization');

     // ✅ Tambahkan di sini agar tetap di dalam middleware auth
     Route::get('/view-pdf', [NonTenderController::class, 'viewPdf'])->name('viewPdf');
     Route::get('/download-pdf', [NonTenderController::class, 'downloadPdf'])->name('downloadPdf');
     Route::get('search', [NonTenderController::class, 'search'])->name('search');

});

Route::group([
    'prefix' => 'tender',
    'as' => 'tender.',
    'middleware' => 'auth',
], function() {
    Route::get('/api/list', [TenderController::class, 'list'])->name('api.list');
    Route::get('/list', [TenderController::class, 'index'])->name('list');
    Route::get('/show/{code}', [TenderController::class, 'show'])->name('show');
    Route::get('/realization', [TenderController::class, 'realization'])->name('realization');
    Route::get('/fund-source', [SatkerController::class, 'sourceReport'])->name('fund.source');
    Route::post('/update/{code}', [TenderController::class, 'update'])->name('update');

    Route::get('/view-pdf', [TenderController::class, 'viewPdf'])->name('view-pdf');
    Route::get('/download-pdf', [TenderController::class, 'downloadPdf'])->name('download-pdf');  
    Route::get('search', [TenderController::class, 'search'])->name('search');  
});

Route::group([
    'prefix' => 'report',
    'as' => 'report.',
    'middleware' => 'auth',
], function () {
    Route::get('/ekatalog', [EkatalogReportController::class, 'index'])->name('ekatalog');
    Route::get('/ekatalog/show/{version}/{code}', [EkatalogReportController::class, 'show'])->name('ekatalog.show');
    Route::get('/ekatalog/export-pdf', [EkatalogReportController::class, 'exportPdf'])->name('ekatalog.exportpdf');

    // ✅ Tambahkan ini
    Route::get('/tokodaring', [TokoDaringReportController::class, 'index'])->name('tokodaring');
    Route::get('/tokodaring/export-pdf', [TokoDaringReportController::class, 'exportPdf'])->name('tokodaring.exportpdf');
});

Route::group([
    'prefix' => 'vendor',
    'as' => 'vendor.',
    'middleware' => 'auth',
], function() {
    Route::get('/list', [VendorController::class, 'index'])->name('list');
    Route::get('/show/{code}', [VendorController::class, 'show'])->name('show');
    Route::post('/update/{code}', [VendorController::class, 'update'])->name('update');

    Route::post('/add-skill/{code}', [VendorController::class, 'addSkill'])->name('skill.add');
    Route::post('/delete-skill/{id}', [VendorController::class, 'removeSkill'])->name('skill.delete');
});
Route::get('/graph-report', [DashboardController::class, 'index'])->name('report');
Route::get('/update-chart-data', [HomeController::class, 'updateChartData']);


Route::group([
    'prefix' => 'report',
    'as' => 'report.',
    'middleware' => 'auth',
], function() {
    Route::get('/categorize', [SatkerController::class, 'categorizeReport'])->name('categorize');
    Route::get('/rup', [SatkerController::class, 'rup'])->name('rup');
    Route::get('/rup/pdf', [SatkerController::class, 'exportPdf'])->name('rup.pdf');
    Route::get('/rup/excel', [SatkerController::class, 'exportExcel'])->name('rup.excel');
    Route::get('/all', [SatkerController::class, 'all'])->name('all');
    Route::get('/review', [SatkerController::class, 'review'])->name('review');
});



Route::get('/struktur-anggaran', [StrukturAnggaranController::class, 'index'])->name('struktur-anggaran.index');



Route::group([
    'prefix' => 'bela',
    'as' => 'bela.',
    'middleware' => ['auth', 'onlyadmin'],
], function() {
    Route::get('/update', [BelaController::class, 'formUpdate'])->name('update');
    Route::post('/update', [BelaController::class, 'update']);
});

Route::group([
    'prefix' => 'user',
    'as' => 'user.',
    'middleware' => ['auth', 'onlyadmin'],
], function () {
    Route::get('/list', [UserController::class, 'list'])->name('list');
    Route::get('/add', [UserController::class, 'formAdd'])->name('add');
    Route::post('/add', [UserController::class, 'add']);
    Route::get('/update/{id}', [UserController::class, 'formUpdate'])->name('update');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::post('/delete/{id}', [UserController::class, 'delete'])->name('delete');
});

Route::group([
    'prefix' => 'monitoring',
    'as' => 'monitoring.',
    'middleware' => 'auth',
], function () {
    Route::get('/realisasi-satker', [MonitoringController::class, 'presentaseRealisasi'])->name('realisasi.satker');
    Route::get('/rekap-realisasi', [MonitoringController::class, 'rekapRealisasi'])->name('rekap.realisasi');
    Route::get('/rekap-realisasi-berlangsung', [MonitoringController::class, 'rekapRealisasiBerlangsung'])->name('rekap.realisasi-berlangsung');

    Route::get('/realisasi-pdf', [MonitoringController::class, 'exportRealisasiToPDF'])->name('realisasi.pdf');
    Route::get('/rekap-realisasi-pdf', [MonitoringController::class, 'exportRekapRealisasiToPDF'])->name('rekap.realisasi.pdf');
    Route::get('/rekap-realisasi-berlangsung-pdf', [MonitoringController::class, 'exportRealisasiBerlangsungPdf'])->name('rekap.realisasi-berlangsung.pdf');

    Route::get('/kontrak', [MonitoringController::class, 'kontrak'])->name('kontrak');
    Route::get('/kontrak/{satker}/detail', [MonitoringController::class, 'kontrakDetail'])->name('kontrak.detail');
    Route::get('/non-tender', [MonitoringController::class, 'kontrakNonTender'])->name('kontrak.non_tender');
    Route::get('/non-tender/{satker}/detail', [MonitoringController::class, 'kontrakNonTenderDetail'])->name('kontrak.non_tender_detail');

    Route::get('/kontrak/{satker}/detail/pdf', [MonitoringController::class, 'exportKontrakDetailPdf'])->name('kontrak.detail.pdf');
    Route::get('/non-tender/{satker}/detail/pdf', [MonitoringController::class, 'exportNonTenderDetailPdf'])->name('non_tender.detail.pdf');  
});
