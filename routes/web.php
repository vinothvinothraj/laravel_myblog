<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Pages\Reports;
use App\Filament\Pages\CreateNewReport;
use App\Filament\Pages\ReportsDashboard;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('input-form', [TaskController::class, 'index']);
Route::get('search-autocomplete', [TaskController::class, 'searchAutocomplete']);

Route::get('/reports', Reports::class)->name('reports');
Route::get('/create-new-report', CreateNewReport::class)->name('create-new-report');
Route::get('/reports-dashboard', ReportsDashboard::class)->name('reports-dashboard');