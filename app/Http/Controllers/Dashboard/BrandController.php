<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Services\Dashboard\ClientService;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    protected $brandService;
    public function __construct(ClientService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index()
    {
        return view('dashboard.brands.index');
    }

    public function getAll()
    {
        return $this->brandService->getBrandsForDatatables();
    }
    public function create()
    {
        return view('dashboard.brands.create');
    }

    public function store(BrandRequest $request)
    {
        // dd($request->all());
        $data = $request->only(['name', 'status', 'logo']);
        $brand = $this->brandService->createBrand($data);

        if (!$brand) {
            Session::flash('erorr', __('messages.general_error'));
            return redirect()->back();
        }
        Session::flash('success', __('messages.added_successfully'));
        return redirect()->back();

    }

    public function edit(string $id)
    {
        $brand = $this->brandService->getBrand($id);
        return view('dashboard.brands.edit', compact('brand'));

    }
    public function update(BrandRequest $request, string $id)
    {
        $data = $request->only(['name', 'status', 'logo']);
// dd($data);
        $brand = $this->brandService->updateBrand($id, $data);
        if (!$brand) {
            Session::flash('erorr', __('messages.general_error'));
            return redirect()->back();
        }
        Session::flash('success', __('messages.updateed_successfully'));
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        if (!$this->brandService->deleteBrand($id)) {
            Session::flash('erorr', __('messages.general_error'));
            return redirect()->back();
        }
        Session::flash('success', __('messages.deleted_successfully'));
        return redirect()->back();
    }



}
