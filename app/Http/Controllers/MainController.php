<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MainController extends Controller
{
    public function homePage(){
        return view('home');
    }
    public function getWeather(Request $request)
    {
        // Validate the request
        $request->validate([
            'city' => 'required|string|max:255',
        ]);

        $apiKey = "f5363d97e64da78267f992bc5cb68b2e";

        $city = $request->input('city');
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";
        // $url="https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}";
        $response = Http::get($url);

        // Check if the response is successful
        if ($response->successful()) {
            $weatherData = $response->json();
            $error=null;
        } else {
            $weatherData = null; // Or handle the error as needed
            $error = "Please enter a valid city!";
        }

        return view('home')->with(compact('weatherData','city','error'));
    }
}