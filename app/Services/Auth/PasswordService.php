<?php

namespace App\Services\Auth;

use App\Repositories\Auth\PasswordRepository;
use App\Notifications\SendOtpNotify;

class PasswordService
{
    protected $passwordRepository;

    public function __construct()
    {
        $this->passwordRepository = new PasswordRepository();

    }
    public function findByEmail($email)
    {
        return $this->passwordRepository->findByEmail($email);
    }
    public function sendOtp($email)
    {
        $admin = $this->findByEmail($email);
        if (!$admin) {
            return false;

        }
        $admin->notify(new SendOtpNotify());

        return $admin;
    }
    public function verifyOtp($email, $token)
    {
        $otp = $this->passwordRepository->verifyOtp($email, $token);

        return $otp->status;
    }
    public function rest($email, $password)
    {
       return $this->passwordRepository->rest($email, $password);
    }
}
