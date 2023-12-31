<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected string $key;

    public function __construct()
    {
        $this->key = env('TMDBKey');
    }

    private function tmdbApi($url, $query = [])
    {
        $client = \Config\Services::curlrequest();
        $response = $client->request('GET', $url, ['query' => $query]);
        $result = $response->getBody();
        $result = json_decode($result, true);
        return $result;
    }

    public function pager($totalReuslts)
    {
        $pager = service('pager');

        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 20;
        $total = $totalReuslts;

        $pager_links = $pager->makeLinks($page, $perPage, $total, 'crimson');

        return $pager_links;
    }

    public function index()
    {
        $movie = 'https://api.themoviedb.org/3/discover/movie';
        $series = 'https://api.themoviedb.org/3/discover/tv';
        $query = [
            'api_key' => $this->key,
            'page' => $this->request->getGet('page'),
            'include_adult' => false,
            'certification_country' => 'US',
            'certification.lte' => 'R'
        ];

        $movieResult = $this->tmdbApi($movie, $query);
        $seriesResult = $this->tmdbApi($series, $query);

        if ($movieResult > $seriesResult) {
            $totalReuslts = $movieResult['total_results'];
        } else {
            $totalReuslts = $seriesResult['total_results'];
        }

        $data = [
            'title' => 'trending',
            'movie' => $movieResult['results'],
            'series' => $seriesResult['results'],
            'pager_links' => $this->pager($totalReuslts)
        ];

        return view('index', $data);
    }

    public function topRated()
    {
        $movie = 'https://api.themoviedb.org/3/movie/top_rated';
        $series = 'https://api.themoviedb.org/3/tv/top_rated';
        $query = [
            'api_key' => $this->key,
            'page' => $this->request->getGet('page')
        ];

        $movieResult = $this->tmdbApi($movie, $query);
        $seriesResult = $this->tmdbApi($series, $query);

        if ($movieResult > $seriesResult) {
            $totalReuslts = $movieResult['total_results'];
        } else {
            $totalReuslts = $seriesResult['total_results'];
        }

        $data = [
            'title' => 'best',
            'movie' => $movieResult['results'],
            'series' => $seriesResult['results'],
            'pager_links' => $this->pager($totalReuslts)

        ];

        return view('index', $data);
    }

    public function genres()
    {
        $movie = 'https://api.themoviedb.org/3/genre/movie/list';
        $series = 'https://api.themoviedb.org/3/genre/tv/list';
        $query = [
            'api_key' => $this->key
        ];

        $data = [
            'title' => 'genre',
            'movie' => $this->tmdbApi($movie, $query)['genres'],
            'series' => $this->tmdbApi($series, $query)['genres']
        ];

        return view('genre', $data);
    }

    function genre($id)
    {
        $movie = 'https://api.themoviedb.org/3/discover/movie';
        $series = 'https://api.themoviedb.org/3/discover/tv';
        $query = [
            'api_key' => $this->key,
            'page' => $this->request->getGet('page'),
            'with_genres' => $id
        ];

        $movieResult = $this->tmdbApi($movie, $query);
        $seriesResult = $this->tmdbApi($series, $query);

        if ($movieResult > $seriesResult) {
            $totalReuslts = $movieResult['total_results'];
        } else {
            $totalReuslts = $seriesResult['total_results'];
        }

        $data = [
            'title' => 'genre | ' . $id,
            'movie' => $movieResult['results'],
            'series' => $seriesResult['results'],
            'pager_links' => $this->pager($totalReuslts)
        ];

        return view('index', $data);
    }

    public function search()
    {
        $keyword = $this->request->getVar('keyword');
        $movie = 'https://api.themoviedb.org/3/search/movie';
        $series = 'https://api.themoviedb.org/3/search/tv';
        $query = [
            'api_key' => $this->key,
            'page' => $this->request->getGet('page'),
            'query' => $keyword
        ];

        $movieResult = $this->tmdbApi($movie, $query);
        $seriesResult = $this->tmdbApi($series, $query);

        if ($movieResult > $seriesResult) {
            $totalReuslts = $movieResult['total_results'];
        } else {
            $totalReuslts = $seriesResult['total_results'];
        }

        $data = [
            'title' => 'trending',
            'movie' => $movieResult['results'],
            'series' => $seriesResult['results'],
            'pager_links' => $this->pager($totalReuslts)

        ];

        return view('index', $data);
    }

    public function detail($type, $id, $seasonid = '')
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
        $rating = $result['vote_average'];
        $genre = $result['genres'];

        if ($type == 'movie') {
            $title = $result['title'];
            $year = $result['release_date'];
            $duration = $result['runtime'];
        } elseif ($type == 'tv') {
            // kalau season urlnya ada isi
            if ($seasonid == '') {
                $title = $result['name'];
                $year = $result['first_air_date'];
                $duration = 0;
            } else {
                $url = 'https://api.themoviedb.org/3/tv/' . $id . '/season' . '/' . $seasonid;
                $result = $this->tmdbApi($url, $query);
                $title = $result['name'];
                $year = $result['air_date'];
                $duration = 0;
                $rating = 0.0;
                $genre = null;
            }
        }

        $deskripsi = $this->tmdbApi($url, $queryIndo)['overview'];

        if ($deskripsi == '') {
            $deskripsi = $this->tmdbApi($url, $query)['overview'];
        }

        //tambahkan season kalau series
        $season = '';
        if ($type == 'tv') {
            if ($seasonid == '') {
                $season = $result['seasons'];
            } else {
                $season = 'TRUE';
            }
        }

        $data = [
            'title' => $title,
            'result' => $result,
            'year' => $year,
            'duration' => $duration,
            'deskripsi' => $deskripsi,
            'season' => $season,
            'id' => $id,
            'key' => $this->key,
            'rating' => $rating,
            'genre' => $genre
        ];

        return view('detail', $data);
    }
}
