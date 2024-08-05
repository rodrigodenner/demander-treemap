<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CovidDataService
{
  public function getSouthAmerica(): array
  {
    $southAmericanCountries = [
      'Argentina', 'Bolivia', 'Brazil', 'Chile', 'Colombia',
      'Ecuador', 'Paraguay', 'Peru', 'Suriname',
      'Uruguay', 'Venezuela'
    ];

    $countryNamesInPortuguese = [
      'Argentina' => 'Argentina',
      'Bolivia' => 'Bolívia',
      'Brazil' => 'Brasil',
      'Chile' => 'Chile',
      'Colombia' => 'Colômbia',
      'Ecuador' => 'Equador',
      'Paraguay' => 'Paraguai',
      'Peru' => 'Peru',
      'Suriname' => 'Suriname',
      'Uruguay' => 'Uruguai',
      'Venezuela' => 'Venezuela',
    ];

    $client = new Client();
    $url = config('covid.api_url') . '/countries';

    try {
      $response = $client->get($url);
      $data = json_decode($response->getBody(), true);

      $filteredData = array_filter($data, function ($country) use ($southAmericanCountries) {
        return in_array($country['country'], $southAmericanCountries);
      });

      $totalCases = array_sum(array_column($filteredData, 'cases'));

      $countryStats = array_map(function ($country) use ($countryNamesInPortuguese, $totalCases) {
        $countryName = $country['country'];
        $countryNameInPortuguese = $countryNamesInPortuguese[$countryName] ?? $countryName;
        $cases = $country['cases'];
        $percentageOfTotalCases = $totalCases > 0 ? ($cases / $totalCases) * 100 : 0;

        return [
          'name' => $countryNameInPortuguese,
          'cases' => $cases,
          'recovered' => $country['recovered'],
          'deaths' => $country['deaths'],
          'flag' => $country['countryInfo']['flag'],
          'percentage' => round($percentageOfTotalCases, 2)
        ];
      }, $filteredData);

      $countryStats['total_cases'] = $totalCases;

      return $countryStats;
    } catch (RequestException $e) {
      return [];
    }
  }
}
