<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DailyReport extends Model
{
    use HasFactory;

    // Define the table name (optional if it follows Laravel's naming convention)
    protected $table = 'daily_reports';

    // Specify the primary key (optional if it's the default 'id')
    protected $primaryKey = 'id';

    // Define which fields are mass assignable
    protected $fillable = [
        'employee_id', 
        'day',         
        'report',       
        'report_date',  
        'report_id',
        'is_submitted',
    ];

    protected $casts = [
        'report_date' => 'datetime', // Automatically cast to Carbon instance
    ];

    // Define the relationship with the Employee model
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

   


}

