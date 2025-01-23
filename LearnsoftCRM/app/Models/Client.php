<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $table = 'clients';

    public $fillable = [
        'full_name',
        'company_name',
        'email_address',
        'phone_number',
        'lead_id',
        'employee_id',
        'client_date',
        'location'
    ];

    protected $casts = [
        'full_name' => 'string',
        'company_name' => 'string',
        'email_address' => 'string',
        'lead_date' => 'date',
        'location' => 'string'
    ];

    public static array $rules = [
        'full_name' => 'nullable|string|max:100',
        'company_name' => 'nullable|string|max:100',
        'email_address' => 'nullable|string|max:100|email',
        'phone_number' => 'nullable|string',
        'lead_id' => 'nullable|exists:leads,id',
        'location' => 'nullable|string|max:200',
        'client_date' => 'nullable|date',
    ];
    

    public function lead(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Lead::class, 'lead_id');
    }

    public function interactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Interaction::class, 'client_id');
    }

    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Order::class, 'client_id');
    }

    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Transaction::class, 'client_id');
    }

    public function employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Employee::class, 'employee_id');
    }

    protected static function booted()
    {
        parent::boot();

        // Automatically create an interaction for new clients
        static::created(function ($client) {
            Interaction::create([
                'client_id' => $client->id,
                'lead_id' => $client->lead_id,  // Link to the lead if provided
                'type' => 'Client',
                'description' => 'New order made',
                'employee_id'=> $client->employee_id,
                'interactions_date' => now()->toDateString(),
            ]);
        });
    }
    public function getClientDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }
}
