<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Session;
use function Laravel\Prompts\alert;

//use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public $authService;

    public function __construct(AuthService $authService)
    {
        $this->middleware(['guest:user'])->only(['showLoginForm', 'login']);
        $this->middleware(['auth:user'])->only(['logout']);

        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('dashboard.auth.login');
    }

    public function login(CreateUserRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        $remember = $request->remember ?? false;
        $response = $this->authService->login($credentials, 'user', $remember);

        if ($response['success']) {
            $user = $response['user'];
            if ($user->status == 0) {
                Session::flash('error', trans('auth.The user is not active.'));
                $this->authService->logout('user');
                return redirect()->back();
            }

            Session::flash('success', trans('messages.successfully_logged'));
            return redirect()->intended(route('dashboard.home'));
        }

        Session::flash('error', trans('auth.failed'));
        return redirect()->back()->withInput()->withErrors([
            'email' => trans('auth.failed'),
        ]);
    }


    public function logout()
    {
        $this->authService->logout('user');
        Session::flash('success', trans('messages.successfully_loggedout'));
        return redirect()->route('dashboard.login.showLoginForm');

    }
}
