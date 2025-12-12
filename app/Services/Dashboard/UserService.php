<?php

namespace App\Services\Dashboard;

use App\Repositories\Dashboard\UserRepository;

class UserService
{
    /**
     * Create a new class instance.
     */
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function getUsers()
    {
        $users = $this->userRepository->getUsers();
        return $users;
    }
    public function getUser($id)
    {
        $user = $this->userRepository->getUser($id);
        if (!$user) {
            return false;
        }
        return $user;
    }

    public function storeUser($data)
    {
        $user = $this->userRepository->storeUser($data);
        if (!$user) {
            return false;
        }
        return $user;

    }

    public function updateUser($data, $id)
    {
        $user = $this->userRepository->getUser($id);
        if (!$user) {
            abort(404);
        }
        if ($data['password'] == null) {
            unset($data['password']);
        }

        $user = $this->userRepository->updateUser($data, $user);
        if (!$user) {
            return false;
        }
        return $user;
    }

    public function destroy($id)
    {
        $user = $this->userRepository->getUser($id);
        if (!$user) {
            abort(404);
        }
        $user = $this->userRepository->destroy($user);
        return $user;

    }

    public function changeStatus($id)
    {
        $user = $this->userRepository->getUser($id);
        if (!$user) {
            abort(404);
        }
        $user->status == 1 ? $status = 0 : $status = 1;
        $status = $this->userRepository->changeStatus($user, $status);
        return $status;
    }




}
