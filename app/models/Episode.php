<?php

class Episode
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = 'https://rickandmortyapi.com/api/episode';
    }

    public function getAllEpisodes()
    {
        $response = file_get_contents($this->apiUrl);
        $episodes = json_decode($response, true);

        return $episodes['results'];
    }

    public function getEpisodeById($id)
    {
        $episodeUrl = $this->apiUrl . '/' . $id;
        $response = file_get_contents($episodeUrl);
        $episode = json_decode($response, true);

        return $episode;
    }
}
