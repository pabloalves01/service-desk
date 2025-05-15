<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function index() {
        $apiKey = env('WEATHER_API_KEY');
        $city = 'Imbituba';
        // $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric&lang=pt_br";
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid=30af2afcd113c08d711eb601e32a3c6d&units=metric&lang=pt_br";

        $response = file_get_contents($url);
        $weatherData = json_decode($response, true);

        if ($weatherData['cod'] !== 200) {
            return response()->json(['error' => 'City not found'], 404);
        }

        return response()->json([
            'temperature' => $weatherData['main']['temp'],
            'description' => $weatherData['weather'][0]['description'],
            'icon' => $weatherData['weather'][0]['icon'],
            'city' => $weatherData['name'],
            'country' => $weatherData['sys']['country'],
        ]);
    }
}
