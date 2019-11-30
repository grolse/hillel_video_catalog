<?php

namespace App\Http\Controllers;


use App\Film;
use App\Services\FilmServiceInterface;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::all();

        return view('search', compact('films'));
    }
    public function search(Request $request, FilmServiceInterface $filmService)
    {
        try {
            $film = $filmService->getFilm($request->get('title'));
            return view('result', compact('film'));
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
    }
}
