<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $table = 'departments';
    public $timestamps = true; // Enable automatic timestamps

    public $fillable = [
        'dept_name',
        'description',
        'employee_id'
    ];

    protected $casts = [
        'dept_name' => 'string',
        'description' => 'string',
       'employee_id' => 'integer'
    ];

    public static array $rules = [
        'dept_name' => 'nullable|string|max:100',
        'description' => 'nullable|string|max:65535',
        'employee_id' => 'nullable|exists:employees,id',
    ];

    public function employees(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Employee::class, 'department_id');
    }

    public function head()
{
    return $this->belongsTo(Employee::class, 'employee_id');
}


public function reports()
{
    return $this->hasMany(Report::class);
}


}
