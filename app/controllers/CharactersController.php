<?php

class CharactersController
{
    public function index()
    {
        // Fetch the list of characters from the API
        $characters = $this->fetchCharacters();

        // Pass the characters to the view for rendering
        include_once __DIR__ . '/../views/characters/index.php';
    }

    public function show($id)
    {
        // Fetch the details of a specific character from the API
        $character = $this->fetchCharacter($id);

        // Pass the character to the view for rendering
        include_once __DIR__ . '/../views/characters/show.php';
    }

    private function fetchCharacters()
    {
        // Code to call the API and retrieve the list of characters

        // Example code to fetch characters using file_get_contents()
        $apiUrl = 'https://rickandmortyapi.com/api/character';
        $response = file_get_contents($apiUrl);
        $characters = json_decode($response, true);

        return $characters;
    }

    private function fetchCharacter($id)
    {
        // Code to call the API and retrieve the details of a specific character

        // Example code to fetch a specific character using file_get_contents()
        $apiUrl = "https://rickandmortyapi.com/api/character/$id";
        $response = file_get_contents($apiUrl);
        $character = json_decode($response, true);

        return $character;
    }
}

