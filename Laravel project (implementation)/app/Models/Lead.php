<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    public $table = 'leads';

    public $fillable = [
        'full_name',
        'email',
        'phone_number',
        'source',
        'employee_id',
        'description',
        'status',
        'product_id',
        'quantity',
        'lead_date',
    ];

    protected $casts = [
        'full_name' => 'string',
        'email' => 'string',
        'source' => 'string',
        'status' => 'string',
        'lead_date' => 'date',
        'description' => 'string'
    ];

    public static array $rules = [
        'full_name' => 'nullable|string|max:100',
        'email' => 'required|string|max:30',
        'phone_number' => 'nullable',
        'source' => 'nullable|string|max:30',
        'status' => 'nullable|string|max:30',
        'employee_id' => 'nullable',
        'lead_date' => 'nullable', 
        'description' => 'nullable|string|max:65535',
    ];

    public function employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Employee::class, 'employee_id');
    }

    public function client(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\Client::class, 'lead_id');
    }

    public function interactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Interaction::class, 'lead_id');
    }

    public function products()
{
    return $this->belongsToMany(Product::class, 'lead_product')
                ->withPivot('quantity')
                ->withTimestamps();
}

    public function getProductNameAttribute()
    {
        return $this->product ? $this->product->product_name : 'N/A';
    }

    protected static function booted()
    {
        parent::boot();

        // Automatically create an interaction for new leads
        static::created(function ($lead) {
            Interaction::create([
                'lead_id' => $lead->id,
                'client_id' => null,
                'type' => 'Lead',
                'description' => $lead->description,
                "employee_id" => $lead->employee_id,
                'interactions_date' => Carbon::now()->toDateString(),
            ]);
        });

        // Default status to 'Pending' if not set
        static::creating(function ($lead) {
            if (is_null($lead->status)) {
                $lead->status = 'Pending';
            }
            if (is_null($lead->lead_date)) {
                $lead->lead_date = Carbon::now()->toDateString();  // Set to current date if null
            }
        });
        
    }
    public function getLeadDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }
}
