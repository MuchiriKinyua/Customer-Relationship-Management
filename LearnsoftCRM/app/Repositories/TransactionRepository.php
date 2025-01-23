<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\BaseRepository;

class TransactionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'order_id',
        'amount_paid',
        'payment_date',
        'payment_method',
        'status',
        'transaction_reference',
        'client_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Transaction::class;
    }
    public function query()
    {
        return Transaction::query();
    }
}
