<?php

namespace App\Contracts;

interface UserRepositoryContract
{
    public function userRegistrationStore($data);
    public function emailCheck($email);
    public function updateEmailVerifiedColumn($id);
    public function getOneUser($id);
    public function getAllUsers();
    public function deleteUser($params);
    public function getOneUserByOauth($params);
    public function storeByGit($params);
}
