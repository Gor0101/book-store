<?php

namespace App\Repositories;

use App\Contracts\GenreRepositoryContract;
use App\Models\Genre;

class GenreRepository implements GenreRepositoryContract
{

    protected Genre $genre;

    public function __construct(Genre $genre)
    {
        $this->genre = $genre;
    }

    public function getAllGenres()
    {
        return $this->genre::all();
    }

}
