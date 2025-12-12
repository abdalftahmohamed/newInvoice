<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\Dashboard\RolesService;
use App\Services\Dashboard\UserService;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $userService , $roleService;
    public function __construct(UserService $userService , RolesService $roleService)
    {
        $this->userService = $userService;
        $this->roleService  = $roleService;
    }
    public function index()
    {
        $users = $this->userService->getUsers();
        return view('dashboard.users.index' , compact('users'));
    }


    public function create()
    {
        $roles = $this->roleService->getRoles();
        return view('dashboard.users.create' , ['roles'=>$roles]);
    }


    public function store(UserRequest $request)
    {
        $data = $request->only(['name' , 'email' , 'password' , 'role_id' , 'status']);
        $user = $this->userService->storeUser($data);
        if(!$user){
            Session::flash('error' , __('messages.general_error'));
            return redirect()->back();
        }
        Session::flash('success' , __('messages.added_successfully'));
        return redirect()->route('dashboard.users.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       if(!$user = $this->userService->getUser($id)){
           Session::flash('error' , 'user not found');
           return redirect()->back();
       }
       return view('dashboard.users.show' , ['user'=>$user]);


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = $this->roleService->getRoles();

        if(!$user = $this->userService->getUser($id)){
            Session::flash('error' , 'user not found');
            return redirect()->back();
        }
        return view('dashboard.users.edit' , ['user'=>$user , 'roles'=>$roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $data = $request->only(['name' , 'email' , 'password' , 'role_id',  'status']);

        if(!$this->userService->updateUser($data , $id)){
            Session::flash('erorr' , __('messages.general_error'));
            return redirect()->back();
        }

        Session::flash('success' , __('messages.updated_successfully'));
        return redirect()->route('dashboard.users.index');
    }


    public function changeStatus($id)
    {
        if(!$this->userService->changeStatus($id)){
            Session::flash('erorr' , __('messages.general_error'));
            return redirect()->back();
        }
        Session::flash('success' , __('messages.updated_successfully'));
        return redirect()->route('dashboard.users.index');
    }

    public function destroy(string $id)
    {
       $user = $this->userService->destroy($id);
       if(!$user){
         Session::flash('erorr' , __('messages.general_error'));
         return redirect()->back();
       }
       Session::flash('success' , __('messages.deleted_successfully'));
       return redirect()->route('dashboard.users.index');


    }
}
