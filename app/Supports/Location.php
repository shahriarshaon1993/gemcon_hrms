<?php

namespace App\Supports;

class Location
{
    public static function getLocation($latitude = null, $longitude = null)
    {
        $apiKey = "AIzaSyCAqdwRPpTtDGc6lWZKlSO0EPgkAKRo-8o";

        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude&key=$apiKey";

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        $response = file_get_contents($url);
        $response = json_decode($response, true);

        if ($response['status'] === "OK") {
            return $response['results'][0]['formatted_address'];
        } else {
            return "Error: " . $response['status'];
        }
    }
}
