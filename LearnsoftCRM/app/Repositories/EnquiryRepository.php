<?php

namespace App\Repositories;

use App\Models\Enquiry;
use App\Repositories\BaseRepository;

class EnquiryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'full_names',
        'phone_number',
        'email',
        'records'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Enquiry::class;
    }
    public function query()
    {
        return Enquiry::query();
    }
}
