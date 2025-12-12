<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ClientRequest;
use App\Services\Dashboard\ClientService;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index()
    {
        return view('dashboard.clients.index');
    }

    public function getAll()
    {
        return $this->clientService->getClientsForDatatables();
    }

    public function create()
    {
        return view('dashboard.clients.create');
    }

    public function store(ClientRequest $request)
    {
//         dd($request->all());
        $data = $request->only(['name', 'status', 'logo', 'phone', 'address', 'email']);
        $client = $this->clientService->createClient($data);

        if (!$client) {
            Session::flash('erorr', __('messages.general_error'));
            return redirect()->back();
        }
        Session::flash('success', __('messages.added_successfully'));
        return redirect()->back();

    }

    public function edit(string $id)
    {
        $client = $this->clientService->getClient($id);
        return view('dashboard.clients.edit', compact('client'));

    }

    public function update(ClientRequest $request, string $id)
    {
        $data = $request->only(['name', 'status', 'logo']);
// dd($data);
        $client = $this->clientService->updateClient($id, $data);
        if (!$client) {
            Session::flash('erorr', __('messages.general_error'));
            return redirect()->back();
        }
        Session::flash('success', __('messages.updateed_successfully'));
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        if (!$this->clientService->deleteClient($id)) {
            Session::flash('erorr', __('messages.general_error'));
            return redirect()->back();
        }
        Session::flash('success', __('messages.deleted_successfully'));
        return redirect()->back();
    }


}
