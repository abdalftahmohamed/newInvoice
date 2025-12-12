<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Services\Dashboard\RolesService;
use Session;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $roleService;
    public function __construct(RolesService $roleService)
    {
        $this->roleService = $roleService;
    }
    public function index()
    {
        $roles = $this->roleService->getRoles();
        return view('dashboard.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $role = $this->roleService->createRole($request);
        if (!$role) {
            return back()->with('error', __('messages.general_error'));
        }
        return redirect()->back()->with('success', __('messages.added_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = $this->roleService->getRole($id);
        if (!$role) {
            return back()->with('error', __('messages.general_error'));
        }
        return view('dashboard.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id)
    {
        $role = $this->roleService->updateRole($request, $id);
        if (!$role) {
            return back()->with('error', __('messages.general_error'));
        }
        return redirect()->back()->with('success', __('messages.added_successfully'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $role = $this->roleService->destroy($id);
       if (!$role) {
        return back()->with('error', __('messages.general_error'));
    }
    return redirect()->back()->with('success', __('messages.added_successfully'));

    }
}
