<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeResponse extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'question_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
