<?php
namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait ApiOpenweathermapTrait {

    public function getWeatherCurrent($city, $country, $units)
    {
        $url = config('openweathermap.openweathermap_url');
        $api_key = config('openweathermap.openweathermap_key');

        $response = Http::get($url.'weather', [
            'q' => $city . ',' . $country,
            'units' => $units,
            'appid' => $api_key
        ]);

        $current = json_decode($response->body());

        // logging 
        Log::channel('weather')->info('Getting current weather for ', [
            'city' => $city,
            'country' => $country,
            'units' => $units,
            'current_weather_api' => $current
        ]);

        return $current;
    }

    public function getWeatherForecast($city, $country, $units, $days)
    {
        $url = config('openweathermap.openweathermap_url');
        $api_key = config('openweathermap.openweathermap_key');
        $forecasts = array();

        $response = Http::get($url.'forecast', [
            'q' => $city . ',' . $country,
            'units' => $units,
            'appid' => $api_key
        ]);

        $threeHours = json_decode($response->body());

        for ($i = 0; $i < $days; $i++) {
            $forecasts[$i] = $threeHours->list[$i * 8];
        }

        // logging 
        Log::channel('weather')->info('Getting forecasts weather for ', [
            'city' => $city,
            'country' => $country,
            'units' => $units,
            'days' => $days,
            'current_weather_api' => $forecasts
        ]);

        return [
            'city' => $threeHours->city->name,
            'country' => $threeHours->city->country,
            'forecasts' => $forecasts
        ];
    }
}