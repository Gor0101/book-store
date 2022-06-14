<?php

namespace App\Http\Controllers;

use App\Contracts\RoleUserRepositoryContract;
use App\Contracts\UserRepositoryContract;
use Illuminate\Http\Response;

class AdminDashboardController extends Controller
{

    protected UserRepositoryContract $userRepositoryContract;
    protected RoleUserRepositoryContract $roleUserRepositoryContract;

    public function __construct(UserRepositoryContract $userRepositoryContract, RoleUserRepositoryContract $roleUserRepositoryContract)
    {
        $this->userRepositoryContract = $userRepositoryContract;
        $this->roleUserRepositoryContract = $roleUserRepositoryContract;
    }


    public function index()
    {
        $users = $this->userRepositoryContract->getAllUsers();
        return view('pages.dashboard',compact('users'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response
     */
    public function deleteUser($id)
    {
        $this->roleUserRepositoryContract->deleteRoleUser($id);
        $user = $this->userRepositoryContract->getOneUser(['id' => $id]);
        dd( unlink($user->profile_image));
        unlink(public_path($user->profile_image));
        $this->userRepositoryContract->deleteUser(['id' => $id]);
        return response()->json([
            "success"=>1,
            'your user successfully deleted'
        ]);
    }
}
