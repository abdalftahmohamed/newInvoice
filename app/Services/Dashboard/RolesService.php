<?php

namespace App\Services\Dashboard;

use App\Repositories\Dashboard\RolesRepository;

class RolesService
{
    protected $rolesRepository;

    public function __construct()
    {
        $this->rolesRepository = new RolesRepository();

    }
    public function createRole($request)
    {
        $role = $this->rolesRepository->createRole($request);
        return $role;
    }

    public function getRoles()
    {
        return $this->rolesRepository->getRoles();
    }
    public function getRole($id)
    {
        return $this->rolesRepository->getRole($id);

    }
    public function updateRole($request, $id)
    {
        $role = $this->rolesRepository->getRole($id);
        if (!$role) {
            return false;
        }
        return $this->rolesRepository->updateRole($request, $role);
    }

    public function destroy($id)
    {
        $role = $this->rolesRepository->getRole($id);

        if ($role->admins->count() > 0 || !$role) {
            return false;
        }

        return $this->rolesRepository->destroy($role);

    }
}
