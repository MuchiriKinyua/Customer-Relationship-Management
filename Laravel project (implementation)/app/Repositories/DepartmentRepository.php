<?php

namespace App\Repositories;

use App\Models\Department;
use App\Repositories\BaseRepository;

class DepartmentRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'dept_name',
        'description'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Department::class;
    }
    public function query()
    {
        return Department::query();
    }
}
