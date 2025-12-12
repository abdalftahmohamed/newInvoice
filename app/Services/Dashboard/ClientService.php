<?php

namespace App\Services\Dashboard;

use Nette\Utils\Image;
use App\Utils\ImageManger;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Dashboard\ClientRepository;

class ClientService
{

    protected $clientRepository, $imageManger;

    public function __construct(ClientRepository $clientRepository, ImageManger $imageManger)
    {
        $this->clientRepository = $clientRepository;
        $this->imageManger = $imageManger;
    }
    public function getClients() // new
    {
        return $this->clientRepository->getClients();
    }
    public function getClient($id)
    {
        $client = $this->clientRepository->getClient($id);
        if (!$client) {
            abort(404);
        }
        return $client;
    }
    public function getClientsForDatatables()
    {

        $clients = $this->clientRepository->getClients();
        return DataTables::of($clients)
            ->addIndexColumn()

            ->addColumn('logo', function ($client) {
                return view('dashboard.clients.datatables.logo', compact('client'));
            })

            ->addColumn('statusName', function ($client) {
                return $client->status_name;
            })
            ->addColumn('countInvoice', function ($client) {
                return $client->invoices_count;
            })
            ->addColumn('action', function ($client) {
                return view('dashboard.clients.datatables.actions', compact('client'));
            })
            ->rawColumns(['action', 'logo']) // for render html content
            ->make(true);
    }

    public function createClient($data)
    {
        if (array_key_exists('logo', $data) && $data['logo'] != null) {
            $file_name = $this->imageManger->uploadSingleImage('/', $data['logo'], 'clients');
            $data['logo'] = $file_name;
        }
        $this->clientCache();
        // dd($data);
        return $this->clientRepository->createClient($data);
    }


    public function updateClient($id, $data)
    {
        $client = $this->getClient($id);
        // dd($data);
        if (array_key_exists('logo', $data) && $data['logo'] != null) {
            // delete old logo
            $this->imageManger->deleteImageFromLocal($client->logo);

            $file_name = $this->imageManger->uploadSingleImage('/', $data['logo'], 'clients');
            $data['logo'] = $file_name;
        }

        return $this->clientRepository->updateClient($client, $data);
    }
    public function deleteClient($id)
    {
        $client = $this->getClient($id);
        // ckeck if has logo?
        if ($client->logo != null) {
            $this->imageManger->deleteImageFromLocal($client->logo);
        }

        $client = $this->clientRepository->deleteClient($client);
        $this->clientCache();
        return $client;
    }

    public function clientCache()
    {
        Cache::forget('clients_count');
    }
}
