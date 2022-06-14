<?php

namespace App\Contracts;

interface BookRepositoryContract
{
    public function store($data);
    public function getAllBooks();
    public function getOneBook($id);
}
