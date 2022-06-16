<?php

namespace App\Contracts;

interface BookRepositoryContract
{
    public function store($data);
    public function getAllBooks($search);
    public function getOneBook($id);
    public function destroy($id);
}
