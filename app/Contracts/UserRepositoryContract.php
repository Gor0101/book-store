<?php

namespace App\Contracts;

interface UserRepositoryContract
{
    public function userRegistrationStore($data);
    public function emailCheck($email);
    public function updateEmailVerifiedColumn($id);
    public function getOneUser($params);
    public function getAllUsers();
    public function deleteUser($params);
    public function getOneUserByOauth($id);
    public function storeByGit($params);
}
