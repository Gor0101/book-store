<?php

namespace App\Repositories;

use App\Models\User;
use App\Contracts\UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function userRegistrationStore($data): mixed
    {
        $user = $this->user::create($data);
        return $user->assignRole('user','buyer');
    }

    /**
     * @param $email
     * @return mixed
     */
    public function emailCheck($email): mixed
    {
        return $this->user::where('email',$email)->whereNotNull('email_verified_at')->first();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function updateEmailVerifiedColumn($params = []): mixed
    {
        return $this->user::where($params)->update(['email_verified_at' => today()]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOneUser($id)
    {
        return $this->user::where('id',$id)->with('roles','subscriptions')->first();
    }

    /**
     * @return mixed
     */
    public function getAllUsers()
    {
        return $this->user::select()->with('books')->paginate(3);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function deleteUser($params = []): mixed
    {
        return $this->user::where($params)->delete() ;
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getOneUserByOauth($params = [])
    {
        return $this->user::select('id')->where($params)->first();
    }

    /**
     * @param $params
     * @return mixed
     */
    public function storeByGit($params = []){
        $user = $this->user::create($params);
        return $user->assignRole('user','buyer');
    }


}
