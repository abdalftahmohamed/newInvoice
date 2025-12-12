<?php

namespace App\Http\Controllers\Dashboard\Auth\Passwords;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestPasswordRequest;
use Illuminate\Support\Facades\Session;
use App\Services\Auth\PasswordService;

class RestPasswordController extends Controller
{
    private $passwordService;
    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }
    public function showRestForm($email)
    {
        // dd($email);
        return view('dashboard.auth.passwords.rest', compact("email"));
    }
    public function rest(RestPasswordRequest $request)
    {

        $admin = $this->passwordService->rest($request->email, $request->password);

        if (!$admin) {
            Session::flash('error', 'try again later');
            return redirect()->back();
        }

        Session::flash('success', trans('messages.updateed_successfully'));
        return redirect()->route('dashboard.login.showLoginForm');
    }
}
