<?php

class Location
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = 'https://rickandmortyapi.com/api/location';
    }

    public function getAllLocations()
    {
        $response = file_get_contents($this->apiUrl);
        $locations = json_decode($response, true);

        return $locations['results'];
    }

    public function getLocationById($id)
    {
        $locationUrl = $this->apiUrl . '/' . $id;
        $response = file_get_contents($locationUrl);
        $location = json_decode($response, true);

        return $location;
    }
}
