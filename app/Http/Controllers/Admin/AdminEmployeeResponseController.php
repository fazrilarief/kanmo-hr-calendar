<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminEmployeeResponseController extends Controller
{
    public function index()
    {
        $department = Auth::guard('admin')->user()->department;

        if ($department === 'ALL') {
            $employeeResponses = EmployeeResponse::join('employees', 'employee_responses.employee_id', '=', 'employees.id')
                ->join('questions', 'employee_responses.question_id', '=', 'questions.id')
                ->select(
                    'employees.name as employee_name',
                    'employees.nip',
                    'employees.department as employee_department',
                    'questions.id as question_id',
                    'questions.department',
                    'questions.question',
                    'questions.category',
                    'questions.answer',
                    'employee_responses.*'
                )->orderByDesc('updated_at')
                ->orderByDesc('created_at')
                ->get();
        } else {
            $employeeResponses = EmployeeResponse::join('employees', 'employee_responses.employee_id', '=', 'employees.id')
                ->join('questions', 'employee_responses.question_id', '=', 'questions.id')
                ->where('questions.department', '=', $department)
                ->select(
                    'employees.name as employee_name',
                    'employees.nip',
                    'employees.name as employee_department',
                    'questions.id as question_id',
                    'questions.department',
                    'questions.category',
                    'questions.question',
                    'questions.answer',
                    'employee_responses.*'
                )->orderByDesc('updated_at')
                ->orderByDesc('created_at')
                ->get();
        }

        return view('admin.response.index', compact('employeeResponses'));
    }
}
