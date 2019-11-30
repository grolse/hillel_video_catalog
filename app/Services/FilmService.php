<?php

namespace App\Services;

use App\Film;
use GuzzleHttp\Client;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class FilmService implements FilmServiceInterface
{
    /** @var Client $httpClient */
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client(
            [
                'base_uri' => 'http://www.omdbapi.com'
            ]
        );
    }

    /**
     * Получить один фильм.
     *
     * @param string $title
     * @return Film
     */
    public function getFilm(string $title): Film
    {
        $film = Film::where('title', 'like', '%' . $title. '%')->first();
        if ($film) {
            return $film;
        }
        $apiFilm = $this->getApiFilm($title);
        $foundedFilm = new Film();
        $foundedFilm->title = $apiFilm['Title'];
        $foundedFilm->year = $apiFilm['Year'];
        $foundedFilm->genre = json_encode(explode(',', $apiFilm['Genre']));
        $foundedFilm->director = $apiFilm['Director'];
        $foundedFilm->runtime = $apiFilm['Runtime'];
        $foundedFilm->plot = $apiFilm['Plot'];
        $foundedFilm->actors = json_encode(explode(',', $apiFilm['Actors']));
        $foundedFilm->imdb_id = $apiFilm['imdbID'];
        $foundedFilm->poster = $apiFilm['Poster'];
        $foundedFilm->save();

        return $foundedFilm;
    }

    /**
     * @param string $title
     * @return array
     * @throws \Exception
     */
    private function getApiFilm(string $title): array
    {
        $request = $this->httpClient->get(
            '',
            [
                'query' => [
                    'apikey' => config('app.omdb_api_key'),
                    't' => $title
                ]
            ]
        );
        $response = json_decode($request->getBody()->getContents(), true);

        if ($response['Response'] === 'False') {
            throw new \Exception('Film not found');
        }
        return $response;
    }
}
