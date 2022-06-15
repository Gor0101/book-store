<?php
//
//namespace App\Http\Controllers;
//
//use App\Contracts\GenreRepositoryContract;
//use Illuminate\Http\Request;
//
//class GenreController extends Controller
//{
//
//    protected GenreRepositoryContract $genreRepositoryContract;
//
//    public function __construct(GenreRepositoryContract $genreRepositoryContract)
//    {
//        $this->genreRepositoryContract = $genreRepositoryContract;
//    }
//
//    public function getAllGenres()
//    {
//        $genres = $this->genreRepositoryContract->getAllGenres();
//        return view('layouts.main-layout',compact('genres'));
//    }
//}
