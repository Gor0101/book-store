<?php

namespace App\Http\Controllers;

use App\Contracts\BookRepositoryContract;
use App\Contracts\RoleUserRepositoryContract;
use App\Contracts\UserRepositoryContract;
use Illuminate\Http\Response;

class AdminDashboardController extends Controller
{

    protected UserRepositoryContract $userRepositoryContract;
    protected RoleUserRepositoryContract $roleUserRepositoryContract;
    protected BookRepositoryContract $bookRepositoryContract;

    public function __construct(UserRepositoryContract $userRepositoryContract, RoleUserRepositoryContract $roleUserRepositoryContract, BookRepositoryContract $bookRepositoryContract)
    {
        $this->userRepositoryContract = $userRepositoryContract;
        $this->roleUserRepositoryContract = $roleUserRepositoryContract;
        $this->bookRepositoryContract = $bookRepositoryContract;
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
        if($user->oauth_id){
            $this->userRepositoryContract->deleteUser(['id' => $id]);
            return response()->json([
                "success"=>1,
                'your user successfully deleted'
            ]);
        }
        unlink(public_path($user->profile_image));
        $this->userRepositoryContract->deleteUser(['id' => $id]);
        $this->bookRepositoryContract->destroy($id);
        return response()->json([
            "success"=>1,
            'your user successfully deleted'
        ]);
    }
}
