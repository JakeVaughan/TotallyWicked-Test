<?php

class EpisodesController
{
    public function index()
    {
        // Fetch the list of episodes from the API
        $episodes = $this->fetchEpisodes(1);

        // Pass the episodes to the view for rendering
        include_once 'app/views/episodes/index.php';
    }

    private function fetchEpisodes($pg)
    {
        // Code to call the API and retrieve the list of episodes
        // You can use functions like file_get_contents() or libraries like Guzzle

        // Example code to fetch episodes using file_get_contents()
        $apiUrl = "https://rickandmortyapi.com/api/episode?page=$pg";
        $response = file_get_contents($apiUrl);
        $episodes = json_decode($response, true);

        return $episodes;
    }

    private function fetchEpisode($id)
    {
        // Code to call the API and retrieve the details of a specific episode

        // Example code to fetch a specific episode using file_get_contents()
        $apiUrl = "https://rickandmortyapi.com/api/episode/$id";
        $response = file_get_contents($apiUrl);
        $episode = json_decode($response, true);

        return $episode;
    }

    private function fetchCharacter($url)
    {
        $response = file_get_contents($url);
        $character = json_decode($response, true);
        return $character;
    }

    public function show($id)
    {
        // Fetch the details of a specific episode from the API
        $episode = $this->fetchEpisode($id);

        // Fetch character information for each character in the episode
        $characters = [];
        foreach ($episode['characters'] as $characterUrl) {
            $character = $this->fetchCharacter($characterUrl);
            $characters[] = $character;
        }

        // Pass the episode and characters to the view for rendering
        include_once 'app/views/episodes/show.php';
    }
}
