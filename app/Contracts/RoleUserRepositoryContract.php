<?php

namespace App\Contracts;

interface RoleUserRepositoryContract
{
    public function store($userRoleData);
    public function deleteRoleUser($id);
}
