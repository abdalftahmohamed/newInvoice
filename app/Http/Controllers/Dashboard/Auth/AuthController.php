<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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

    public function showRegisterForm()
    {
        $roles = Role::get();
        return view('dashboard.auth.register',compact('roles'));
    }

    public function register(UserRequest $request)
    {
        // Validate & prepare data
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data = Arr::except($data, ['password_confirmation']);

        // Create user inside a transaction to be safe
        DB::beginTransaction();
        try {
            $user = User::create($data);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('User registration failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->except('password', 'password_confirmation'),
            ]);

            Session::flash('error', trans('messages.create_failed', [], config('app.locale')));
            return redirect()->back()->withInput();
        }

        // Fire Registered event (useful for listeners like sending verification emails)
        event(new Registered($user));

        // Auto-login using your authService (keep using it if it handles guards/roles)
        $credentials = $request->only(['email', 'password']);
        $remember = (bool) $request->input('remember', false);

        $response = $this->authService->login($credentials, 'user', $remember);

        if (!empty($response['success']) && $response['success'] === true) {
            $authedUser = $response['user'];

            // If your app has an "active" flag, block inactive users immediately
            if (property_exists($authedUser, 'status') && $authedUser->status == 0) {
                $this->authService->logout('user');
                Session::flash('error', trans('auth.The user is not active.'));
                return redirect()->back();
            }

            Session::flash('success', trans('messages.successfully_logged'));
            return redirect()->intended(route('dashboard.home'));
        }

        // If login failed for any reason, show friendly error and keep old input
        Session::flash('error', trans('auth.failed'));
        return redirect()->back()
            ->withInput($request->except('password', 'password_confirmation'))
            ->withErrors(['email' => trans('auth.failed')]);
    }

    public function logout()
    {
        $this->authService->logout('user');
        Session::flash('success', trans('messages.successfully_loggedout'));
        return redirect()->route('dashboard.login.showLoginForm');

    }
}
