<?php

namespace App\Repositories\Dashboard;

use App\Models\User;

class UserRepository
{

    public function getUsers()
    {
        $users = User::select('id', 'name', 'email', 'created_at', 'role_id', 'status')->paginate(6);
        return $users;
    }

    public function getUser($id)
    {
        $user = User::find($id);
        return $user;
    }

    public function storeUser($data)
    {
        $user = User::create($data);
        return $user;
    }

    public function updateUser($data, $user)
    {
        $user = $user->update($data);
        return $user;
    }

    public function destroy($user)
    {
        return $user->delete();
    }

    public function changeStatus($user, $status)
    {
        $user = $user->update([
            'status' => $status,
        ]);

        return $user;
    }




}
