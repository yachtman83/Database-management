<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryHistory extends Model
{
    protected $fillable =['amount', 'date', 'employee_id'];

    // Связь Many-to-One с Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
