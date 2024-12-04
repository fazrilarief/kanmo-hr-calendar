<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'nip'];

    public function employeeResponses()
    {
        return $this->hasMany(EmployeeResponse::class, 'employee_id');
    }

    public function employeeFeedbacks()
    {
        return $this->hasMany(Feedback::class, 'employee_id');
    }
}
