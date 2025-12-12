<?php

namespace App\Repositories\Dashboard;

use App\Models\Client;

class ClientRepository
{

    public function getClients()
    {
        $clients = Client::withCount('invoices')->latest()->get();
        return $clients;
    }
    public function getClient($id)
    {
        $client = Client::find($id);
        return $client;
    }
    public function createClient($data)
    {
        $client = Client::create($data);
        return $client;
    }
    public function updateClient($client, $data)
    {
        return $client->update($data);
    }
    public function deleteClient($client)
    {
        return $client->delete();
    }


}
