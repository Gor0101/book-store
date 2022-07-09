<?php

namespace App\Http\Controllers;

use App\Contracts\BookRepositoryContract;
use App\Contracts\RoleUserRepositoryContract;
use App\Contracts\UserRepositoryContract;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = $this->userRepositoryContract->getAllUsers();
        return view('pages.dashboard', compact('users'));
    }


    public function deleteUser($id)
    {
        try {
            DB::beginTransaction();
            $this->roleUserRepositoryContract->deleteRoleUser($id);
            $user = $this->userRepositoryContract->getOneUser(['id' => $id]);
            if (!$user->oauth_id) {
                unlink(public_path($user->profile_image));
            }
            $this->userRepositoryContract->deleteUser(['id' => $id]);
            $this->bookRepositoryContract->destroy($id);
            return response()->json([
                "success" => 1,
                'your user successfully deleted'
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back(compact(["error" => $e->getMessage()]));
        }
    }
}
