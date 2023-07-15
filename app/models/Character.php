<?php

class Character
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = 'https://rickandmortyapi.com/api/character';
    }

    public function getAllCharacters()
    {
        $response = file_get_contents($this->apiUrl);
        $characters = json_decode($response, true);

        return $characters['results'];
    }

    public function getCharacterById($id)
    {
        $characterUrl = $this->apiUrl . '/' . $id;
        $response = file_get_contents($characterUrl);
        $character = json_decode($response, true);

        return $character;
    }

}
