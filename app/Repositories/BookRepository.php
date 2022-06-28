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

    /**
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        return $this->book::create($data);
    }

    public function getAllBooks($search)
    {
        return $this->book::when($search, fn($query)=>
        $query->where('name', 'like', '%' . $search . '%'))
            ->with(['user','genre','payment'])
            ->paginate(4);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOneBook($id)
    {
        return $this->book::where('id',$id)->first();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->book::where('user_id',$id)->delete();
    }

}
