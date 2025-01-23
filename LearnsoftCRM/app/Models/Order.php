<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = 'orders';

    public $fillable = [
        'quantity_ordered',
        'unit_price',
        'total_price',
        'order_date',
        'client_id',
        'lead_id', 
        'status',
        'order_ref_number',
    ];
    

    protected $casts = [
        'unit_price' => 'float',
        'total_price' => 'float',
        'order_date' => 'date',
        'status' => 'string',
    ];

    public static array $rules = [
        'quantity_ordered' => 'nullable',
        'total_price' => 'nullable|numeric',
        'order_date' => 'nullable',
        'status' => 'nullable|string|max:20',
        'client_id' => 'nullable',
        'lead_id' => 'nullable',
    ];

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Client::class, 'client_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
                    ->withPivot('quantity', 'price', 'total_price')
                    ->withTimestamps();
    }

    public function getProductNameAttribute()
    {
        return $this->product ? $this->product->product_name : 'N/A';
    }
    

    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Transaction::class, 'order_id');
    }

    public function lead()
    {
    return $this->belongsTo(\App\Models\Lead::class, 'lead_id');
    }

    public function getOrderDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('m-d-Y');
    }

}
