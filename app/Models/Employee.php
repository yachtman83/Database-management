<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['name', 'surname', 'rank', 'salary', 'workshop_id'];


    // Связь Many-to-One с Workshop
    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

     // Связь One-to-Many с SalaryHistory
     public function salaryHistory()
     {
         return $this->hasMany(SalaryHistory::class);
     }
}
