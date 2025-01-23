<?php

namespace App\Repositories;

use App\Models\Report;
use App\Repositories\BaseRepository;

class ReportRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'lead_name',
        'client_name',
        'lead_date',
        'client_date',
        'product_id',
        'quantity_ordered',
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Report::class;
    }
    public function query()
    {
        return Report::query();
    }
}
