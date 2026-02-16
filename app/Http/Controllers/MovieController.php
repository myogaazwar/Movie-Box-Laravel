<?php

namespace App\Http\Controllers;

use App\Favorite;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MovieController extends Controller
{

    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.omdb.base_url'),
        ]);
    }

    public function index($locale)
    {

        app()->setLocale($locale);

        return view('movies.movies', [
            'defaultQuery' => 'naruto',
        ]);
    }


    public function search($locale, Request $request)
    {
        app()->setLocale($locale);

        $title = $request->title;
        $page  = $request->page ?? 1;

        $response = $this->client->get('/', [
            'query' => [
                'apikey' => config('services.omdb.api_key'),
                's'      => $title,
                'page'   => $page,
            ]
        ]);

        return response()->json(
            json_decode($response->getBody(), true)
        );
    }


    public function show($locale, $id)
    {
        app()->setLocale($locale);

        $response = $this->client->get('/', [
            'query' => [
                'apikey' => config('services.omdb.api_key'),
                'i' => $id,
                'plot' => 'full'

            ]
        ]);

        $movie = json_decode($response->getBody(), true);

        $genres = isset($movie['Genre'])
            ? explode(',', $movie['Genre'])
            : [];

        $isFavorite = Favorite::where('user_id', Auth::id())
            ->where('imdb_id', $id)
            ->exists();



        return view('movies.detailMovie', compact('movie', 'isFavorite', 'genres'));
    }

    public function addToFavorites($locale, $id)
    {
        app()->setLocale($locale);

        $response = $this->client->get('/', [
            'query' => [
                'apikey' => config('services.omdb.api_key'),
                'i' => $id,
            ]
        ]);

        $movie = json_decode($response->getBody(), true);

        Favorite::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'imdb_id' => $movie['imdbID'],
            ],
            [
                'poster_path' => $movie['Poster'] ?? null,
                'title' => $movie['Title'] ?? null,
                'type' => $movie['Type'] ?? null,
                'release_date' => $movie['Year'] ?? null,
            ]
        );


        return redirect()->route('movies.show', [
            'locale' => $locale,
            'id' => $id
        ]);
    }


    public function removeFromFavorites($locale, $id)
    {
        app()->setLocale($locale);

        Favorite::where('user_id', Auth::id())
            ->where('imdb_id', $id)
            ->delete();

        return redirect()->route('movies.show', [
            'locale' => $locale,
            'id' => $id
        ]);
    }


    public function showFavorites($locale)
    {
        app()->setLocale($locale);

        $favorites = Favorite::where('user_id', Auth::id())->get();

        return view('movies.favoritesMovie', compact('favorites'));
    }
}
