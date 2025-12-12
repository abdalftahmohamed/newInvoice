<?php

namespace App\Repositories\Auth;

use App\Models\User;
use Ichtrojan\Otp\Otp;

class PasswordRepository
{

    public function findByEmail($email)
    {
        $user = User::where('email', $email)->first();

        return $user;
    }
    public function verifyOtp($email, $token)
    {
        $otp = (new Otp)->validate($email, $token);

        return $otp;
    }
    public function rest($email, $password)
    {
        $user = $this->findByEmail($email);

        $user->update([
            'password' => bcrypt($password)
        ]);
        return $user;

    }
}
