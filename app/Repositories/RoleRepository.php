<?php

namespace App\Repositories;

use App\Contracts\RoleRepositoryContract;
use App\Models\Role;

class RoleRepository implements RoleRepositoryContract
{

    protected Role $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|mixed
     */
    public function getAll()
    {
        return $this->role::all()->random();
    }

}
