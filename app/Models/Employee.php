<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $table = 'employees';

    public $fillable = [
        'full_name',
        'email',
        'phone_number',
        'department_id'
    ];

    protected $casts = [
        'full_name' => 'string',
        'email' => 'string'
    ];

    public static array $rules = [
        'full_name' => 'nullable|string|max:100',
        'email' => 'nullable|string|max:30',
        'phone_number' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'department_id' => 'nullable'
    ];

    public function department(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Department::class, 'department_id');
        return $this->hasOne(Department::class, 'employee_id');
    }

    public function leads(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Lead::class, 'employee_id');
    }

    public function clients(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    return $this->hasMany(\App\Models\Client::class, 'employee_id');
}
    // public function getFullNameAttribute(): string
    // {
    //     return "{$this->first_name} {$this->last_name}";
    // }
    public function dailyReports()
    {
        return $this->hasMany(DailyReport::class);
    }

    public function reports()
{
    return $this->hasMany(Report::class);
}


}
