<?php

namespace App\Repositories;

use App\Models\Client;

class ClientRepository
{
    // Paginate clients with eager loading of the 'lead' relationship
    public function paginate($perPage = 10)
    {
        return Client::with('lead')->paginate($perPage); // Eager load the 'lead' relationship
    }

    // Other repository methods like find, create, delete, etc.
    public function find($id)
    {
        return Client::find($id);
    }

    public function create(array $data)
    {
        return Client::create($data);
    }

    public function update(array $data, $id)
    {
        $client = Client::find($id);
        if ($client) {
            $client->update($data);
            return $client;
        }
        return null;
    }

    public function delete($id)
    {
        return Client::destroy($id);
    }
    public function query()
    {
        return Client::query();
    }
}
