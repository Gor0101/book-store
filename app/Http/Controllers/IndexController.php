<?php

namespace App\Http\Controllers;

use App\Contracts\PlanRepositoryContract;
use App\Contracts\RoleUserRepositoryContract;
use App\Contracts\UserRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    protected PlanRepositoryContract $planRepositoryContract;
    protected UserRepositoryContract $userRepositoryContract;

    public function __construct(PlanRepositoryContract $planRepositoryContract,UserRepositoryContract $userRepositoryContract)
    {
        $this->planRepositoryContract = $planRepositoryContract;
        $this->userRepositoryContract = $userRepositoryContract;
    }

    public function index()
    {
        $user = $this->userRepositoryContract->getOneUser(Auth::id());
        $plans = $this->planRepositoryContract->getAllPlans();
        return view('pages.index',compact('plans','user'));
    }
}
