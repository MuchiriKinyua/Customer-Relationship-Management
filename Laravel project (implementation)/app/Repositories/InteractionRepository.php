<?php

namespace App\Repositories;

use App\Models\Interaction;
use App\Repositories\BaseRepository;

class InteractionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'client_id',
        'lead_id',
        'type',
        'description',
        'interactions_date'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Interaction::class;
    }
    public function query()
    {
        return Interaction::query();
    }
}
