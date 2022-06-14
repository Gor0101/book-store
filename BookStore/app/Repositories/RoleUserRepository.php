<?php

namespace App\Repositories;

use App\Contracts\RoleUserRepositoryContract;
use App\Models\RoleUser;

class RoleUserRepository implements RoleUserRepositoryContract
{
    protected RoleUser $roleUser;

    public function __construct(RoleUser $roleUser)
    {
        $this->roleUser = $roleUser;
    }

    /**
     * @param $userRoleData
     * @return mixed
     */
    public function store($userRoleData)
    {
        return $this->roleUser::create($userRoleData);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function deleteRoleUser($id)
    {
        return $this->roleUser::where('user_id',$id)->delete();
    }

}
