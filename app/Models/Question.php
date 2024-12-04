<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['department', 'question', 'answer'];

    public function employeeResponses()
    {
        return $this->hasMany(EmployeeResponse::class, 'question_id');
    }
}
