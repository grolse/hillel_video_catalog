<?php


namespace App\Services;

use App\Film;
use Illuminate\Database\Eloquent\Collection;

interface FilmServiceInterface
{
    /**
     * Получить один фильм.
     *
     * @param string $title
     * @return Film
     */
    public function getFilm(string $title): Film;
}
