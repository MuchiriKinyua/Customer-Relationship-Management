<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Interaction extends Model
{
    public $table = 'interactions';

    public $fillable = [
        'client_id',
        'lead_id',
        'type',
        'employee_id',
        'description',
        'interactions_date'
    ];

    protected $casts = [
        'type' => 'string',
        'description' => 'string',
        'interactions_date' => 'datetime'
    ];

    public static array $rules = [
        'client_id' => 'nullable', // Ensure client_id is provided
        'lead_id' => 'required|exists:leads,id', // Ensure lead_id is provided
        'employee_id' => 'required|exists:employees,id', // Make sure employee_id is provided and valid
        'type' => 'required|string|max:30',
        'description' => 'required|string|max:65535',
        'interactions_date' => 'required|date',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
    

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Client::class, 'client_id');
    }

    public function lead(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Lead::class, 'lead_id');
    }
    public function employee()
{
    return $this->belongsTo(Employee::class);
}
    public function getInteractionsDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
}
