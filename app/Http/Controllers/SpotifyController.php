<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SpotifyController extends Controller
{
    public function getToken()
    {
        $client_id = env('SPOTIFY_CLIENT_ID');
        $client_secret = env('SPOTIFY_CLIENT_SECRET');

        Log::info("Requesting Spotify token with client ID: $client_id");

        $response = Http::asForm()->withBasicAuth($client_id, $client_secret)->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'client_credentials',
        ]);

        if ($response->successful()) {
            Log::info("Spotify token retrieved successfully.");
            return response()->json($response->json());
        } else {
            Log::error("Failed to retrieve Spotify token.", ['response' => $response->body()]);
            return response()->json(['error' => 'Failed to retrieve Spotify token.'], $response->status());
        }
    }
}