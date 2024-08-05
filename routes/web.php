<?php

use App\Http\Controllers\CovidSummaryController;
use App\Http\Controllers\MarketController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CovidSummaryController::class, 'showSummary'])->name('covid.summary');


