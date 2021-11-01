<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class WeatherController extends Controller
{
    public function index()
    {
        $apiKey = config('services.openweather.key');

        $lat = request('lat');
        $lon = request('lon');

        $client = new Client();
        $response = $client->request('GET', "http://api.openweathermap.org/data/2.5/forecast?lat=$lat&lon=$lon&cnt=20&appid=$apiKey&units=metric", ['JSON']);

        return $response->getBody();
    }
}
