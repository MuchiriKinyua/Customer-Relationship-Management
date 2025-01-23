<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    public $table = 'enquiries';

    public $fillable = [
        'full_names',
        'phone_number',
        'email',
        'records'
    ];

    protected $casts = [
        'full_names' => 'string',
        'email' => 'string',
        'records' => 'string'
    ];

    public static array $rules = [
        'full_names' => 'required|string|max:200',
        'phone_number' => 'required',
        'email' => 'required|string|max:100',
        'records' => 'required|string|max:800'
    ];

    
}
