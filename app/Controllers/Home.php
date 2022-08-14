<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $key = '451a8659289b87fe4a6b3cde9fe4b93e'; //TMDB API

    private function tmdbApi($url, $query = [])
    {
        $client = \Config\Services::curlrequest();
        $response = $client->request('GET', $url, ['query' => $query]);
        $result = $response->getBody();
        $result = json_decode($result, true);
        return $result;
    }

    public function index()
    {
        $movie = 'https://api.themoviedb.org/3/trending/movie/day';
        $series = 'https://api.themoviedb.org/3/trending/tv/day';
        $query = [
            'api_key' => $this->key
        ];

        $data = [
            'title' => 'filmku',
            'nav' => 'trending',
            'movie' => $this->tmdbApi($movie, $query)['results'],
            'series' => $this->tmdbApi($series, $query)['results']
        ];

        return view('index', $data);
    }

    public function populer()
    {
        $movie = 'https://api.themoviedb.org/3/discover/movie';
        $series = 'https://api.themoviedb.org/3/discover/tv';
        $query = [
            'api_key' => $this->key,
            'vote_average.gte' => 8
        ];

        $data = [
            'title' => 'filmku | Populer',
            'nav' => 'populer',
            'movie' => $this->tmdbApi($movie, $query)['results'],
            'series' => $this->tmdbApi($series, $query)['results']
        ];

        return view('index', $data);
    }

    public function genres()
    {
        $genres = 'https://api.themoviedb.org/3/genre/movie/list';
        $query = [
            'api_key' => $this->key
        ];

        $data = [
            'title' => 'filmku | Genres',
            'nav' => 'genre',
            'genre' => $this->tmdbApi($genres, $query)['genres']
        ];

        return view('genre', $data);
    }

    function genre($name)
    {
        $movie = 'https://api.themoviedb.org/3/discover/movie';
        $series = 'https://api.themoviedb.org/3/discover/tv';
        $query = [
            'api_key' => $this->key,
            'with_genres' => $name
        ];

        $data = [
            'title' => 'filmku | ' . $name,
            'nav' => 'genre',
            'movie' => $this->tmdbApi($movie, $query)['results'],
            'series' => $this->tmdbApi($series, $query)['results']
        ];

        return view('index', $data);
    }

    public function detail($type, $id)
    {
        $url = 'https://api.themoviedb.org/3/' . $type . '/' . $id;
        $query = [
            'api_key' => $this->key,
            'append_to_response' => 'videos'
        ];

        $queryIndo = [
            'api_key' => $this->key,
            'append_to_response' => 'videos',
            'language' => 'id'
        ];

        $result = $this->tmdbApi($url, $query);
        $deskripsi = $this->tmdbApi($url, $queryIndo)['overview'];

        if ($deskripsi == '') {
            $deskripsi = $this->tmdbApi($url, $query)['overview'];
        }

        if ($type == 'movie') {
            $title = $result['title'];
            $year = $result['release_date'];
            $duration = $result['runtime'];
        } else {
            $title = $result['name'];
            $year = $result['first_air_date'];
            $duration = 0;
        }

        //tambahkan season kalau series
        $season = '';
        if ($type == 'tv') {
            $season = $result['seasons'];
        }

        $data = [
            'title' => 'filmku | ' . $title,
            'result' => $result,
            'title' => $title,
            'year' => $year,
            'duration' => $duration,
            'deskripsi' => $deskripsi,
            'season' => $season
        ];

        return view('detail', $data);
    }

    public function search()
    {
        $keyword = $this->request->getVar('keyword');
        $movie = 'https://api.themoviedb.org/3/search/movie';
        $series = 'https://api.themoviedb.org/3/search/tv';
        $query = [
            'api_key' => $this->key,
            'query' => $keyword
        ];

        $resultMovie = $this->tmdbApi($movie, $query)['results'];
        $resultSeries = $this->tmdbApi($series, $query)['results'];

        $data = [
            'title' => 'filmku',
            'nav' => 'trending',
            'movie' => $resultMovie,
            'series' => $resultSeries
        ];

        return view('index', $data);
    }
}
