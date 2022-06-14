<?php

namespace App\Repositories;


use App\Contracts\BookRepositoryContract;
use App\Models\Book;

class BookRepository implements BookRepositoryContract
{

    protected Book $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }


    public function store($data)
    {
        return $this->book::create($data);
    }

    public function getAllBooks()
    {
        return $this->book::select()->with(['user','genre','payment'])->paginate(4);
    }

    public function getOneBook($id)
    {
        return $this->book::where('id',$id)->first();
    }

}
