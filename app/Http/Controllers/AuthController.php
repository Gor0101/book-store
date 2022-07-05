<?php

namespace App\Http\Controllers;

use App\Contracts\RoleRepositoryContract;
use App\Contracts\RoleUserRepositoryContract;
use App\Contracts\UserRepositoryContract;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    protected UserRepositoryContract $userRepositoryContract;
    protected RoleRepositoryContract $roleRepositoryContract;
    protected RoleUserRepositoryContract $roleUserRepositoryContract;

    public function __construct(UserRepositoryContract $userRepositoryContract , RoleRepositoryContract $roleRepositoryContract ,  RoleUserRepositoryContract $roleUserRepositoryContract)
    {
        $this->userRepositoryContract = $userRepositoryContract;
        $this->roleRepositoryContract = $roleRepositoryContract;
        $this->roleUserRepositoryContract = $roleUserRepositoryContract;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function registrationUserPage()
    {
        return view('pages.registration');
    }

    public function userProfilePage($id)
    {
        $user = $this->userRepositoryContract->getOneUser(['id' => $id]);
        return view('pages.profile',compact('user'));
    }

    /**
     * @param UserRegistrationRequest $userRegistrationRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function registrationUserSubmit(UserRegistrationRequest $userRegistrationRequest)
    {
        $image = Storage::putFile('public/profileImages', $userRegistrationRequest->file('profileImage'),'private');
        $user_avatar = Str::replaceFirst('public', 'storage', $image);
        $data = [
            'name' => $userRegistrationRequest->input('name'),
            'last_name' => $userRegistrationRequest->input('lastName'),
            'email' => $userRegistrationRequest->input('email'),
            'password' => Hash::make($userRegistrationRequest->input('password')),
            'profile_image' => $user_avatar,
            'email_verified_at' => Carbon::now(),
        ];
        $user = $this->userRepositoryContract->UserRegistrationStore($data);
        $roles = $this->roleRepositoryContract->getAll();
        $userRoleData = [
            'user_id' => $user->id,
            'role_id' => $roles->id,
        ];
        $this->roleUserRepositoryContract->store($userRoleData);
        \Mail::to($user->email)->send(new \App\Mail\OrderShipped($user));
        return redirect(route('index'));
    }


    /**
     * @param UserLoginRequest $userLoginRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function loginUserSubmit(UserLoginRequest $userLoginRequest)
    {
        $email = $userLoginRequest->input('email');
        $password = $userLoginRequest->input('password');
        if ($this->userRepositoryContract->emailCheck($email) && Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect(route('index'));
        } else {
            return redirect()->back();
        }
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function loginUserPage()
    {
        return view('pages.login');
    }


    /**
     * @param $id
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function verifyEmail($id){
        $user = $this->userRepositoryContract->updateEmailVerifiedColumn(['id' => $id]);
        $userId = $this->userRepositoryContract->getOneUser(['id' => $id]);

        if($user){
            Auth::loginUsingId($userId->id);
            return redirect(route('index'));
        }else{
            return redirect()->back();
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::logout();
        return redirect(route('LoginUserPage'));
    }

    public function github()
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubRedirect()
    {
        $user = Socialite::driver('github')->user();
        $getLoggedUser = $this->userRepositoryContract->getOneUserByOauth(['oauth_id' => $user->id]);

        if($getLoggedUser){
            Auth::loginUsingId($getLoggedUser->id);
            return redirect(route('index'));
        }else{
            $userGitData = [
                'name' => $user->name,
                'last_name' => $user->nickname,
                'profile_image' => $user->avatar,
                'email' => $user->email,
                'email_verified_at' => Carbon::now(),
                'oauth_id' => $user->id,
            ];

            $createdUser = $this->userRepositoryContract->storeByGit($userGitData);
            $roles = $this->roleRepositoryContract->getAll();
            $userRoleData = [
                'user_id' => $createdUser->id,
                'role_id' => $roles->id,
            ];
            $this->roleUserRepositoryContract->store($userRoleData);
            Auth::loginUsingId($createdUser->id);
            return redirect(route('index'));
        }
    }

}
