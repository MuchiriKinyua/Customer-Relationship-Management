<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $table = 'transactions';

    public $timestamps = true; // Explicitly enable timestamps

    public $fillable = [
        'order_id',
        'amount_paid',
        'payment_date',
        'payment_method',
        'status',
        'transaction_reference',
        'client_id'
    ];

    protected $casts = [
        'amount_paid' => 'float',
        'payment_date' => 'date',
        'payment_method' => 'string',
        'status' => 'string',
        'transaction_reference' => 'string'
    ];

    public static array $rules = [
        'order_id' => 'nullable',
        'amount_paid' => 'nullable|numeric',
        'payment_date' => 'nullable',
        'payment_method' => 'nullable|string|max:20',
        'status' => 'nullable|string|max:20',
        'transaction_reference' => 'required|unique:transactions,transaction_reference|max:50',
        'client_id' => 'required'
    ];

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Client::class, 'client_id');
    }

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Order::class, 'order_id');
    }
    public function getPaymentDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }
}