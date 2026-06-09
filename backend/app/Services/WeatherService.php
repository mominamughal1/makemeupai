<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    private const DEFAULT_WEATHER = [
        'temp' => 25,
        'condition' => 'clear',
        'description' => 'pleasant weather',
    ];

    public function getWeather(string $city): array
    {
        $apiKey = config('services.openweather.key');

        if (empty($apiKey)) {
            return self::DEFAULT_WEATHER;
        }

        try {
            $response = Http::timeout(5)->get('http://api.openweathermap.org/data/2.5/weather', [
                'q' => $city,
                'appid' => $apiKey,
                'units' => 'metric',
            ]);

            if (! $response->successful()) {
                return self::DEFAULT_WEATHER;
            }

            $data = $response->json();

            return [
                'temp' => (int) round($data['main']['temp'] ?? 25),
                'condition' => strtolower($data['weather'][0]['main'] ?? 'clear'),
                'description' => $data['weather'][0]['description'] ?? 'pleasant weather',
            ];
        } catch (\Throwable) {
            return self::DEFAULT_WEATHER;
        }
    }
}
