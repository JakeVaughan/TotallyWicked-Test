<?php

class LocationsController
{
    public function index()
    {
        // Fetch the list of locations from the API
        $locations = $this->fetchLocations();

        // Pass the locations to the view for rendering
        include_once 'app/views/locations/index.php';
    }

    public function show($id)
    {
        // Fetch the details of a specific location from the API
        $location = $this->fetchLocation($id);

        // Extract character ID and name functions
        function extractCharacterId($resident)
        {
            $urlParts = explode('/', $resident);
            return end($urlParts);
        }

        function extractCharacterName($resident)
        {
            $characterId = extractCharacterId($resident);
            $apiUrl = "https://rickandmortyapi.com/api/character/$characterId";
            $response = file_get_contents($apiUrl);
            $character = json_decode($response, true);
            return $character['name'];
        }

        // Get character image function
        function getCharacterImage($characterId)
        {
            $apiUrl = "https://rickandmortyapi.com/api/character/$characterId";
            $response = file_get_contents($apiUrl);
            $character = json_decode($response, true);
            return $character['image'];
        }

        // Pass the location and functions to the view for rendering
        include_once 'app/views/locations/show.php';
    }

    private function fetchLocations()
    {
        // Code to call the API and retrieve the list of locations

        // Example code to fetch locations using file_get_contents()
        $apiUrl = 'https://rickandmortyapi.com/api/location';
        $response = file_get_contents($apiUrl);
        $locations = json_decode($response, true);

        return $locations;
    }

    private function fetchLocation($id)
    {
        // Code to call the API and retrieve the details of a specific location

        // Example code to fetch a specific location using file_get_contents()
        $apiUrl = "https://rickandmortyapi.com/api/location/$id";
        $response = file_get_contents($apiUrl);
        $location = json_decode($response, true);

        return $location;
    }
}
