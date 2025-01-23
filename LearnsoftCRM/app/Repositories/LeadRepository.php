<?php

namespace App\Repositories;

use App\Models\Lead;
use App\Repositories\BaseRepository;

class LeadRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'full_name',
        'email',
        'phone_number',
        'source',
        'status',
        'employee_id',
        'description',
        'lead_date'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Lead::class;
    }
    public function query()
    {
        return Lead::query();
    }
}
