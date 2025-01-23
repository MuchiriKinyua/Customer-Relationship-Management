<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'product_id',
        'quantity_ordered',
        'unit_price',
        'total_price',
        'order_date',
        'status',
        'client_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Order::class;
    }
    public function query()
    {
        return Order::query();
    }
}
