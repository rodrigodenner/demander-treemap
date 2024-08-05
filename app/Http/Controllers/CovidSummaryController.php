<?php

namespace App\Http\Controllers;

use App\Services\CovidDataService;
use Illuminate\Http\Request;

class CovidSummaryController extends Controller
{
  public function __construct(protected CovidDataService $covidService)
  {
  }

  public function showSummary()
  {
    $countryData = $this->covidService->getSouthAmerica();

    return view('summary', [
      'countries' => $countryData,
    ]);

  }
}
