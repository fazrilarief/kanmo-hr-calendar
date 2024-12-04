<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeResponse;
use App\Models\Feedback;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $sourcesGrafik = EmployeeResponse::leftJoin('employees', 'employee_responses.employee_id', '=', 'employees.id')
            ->select(
                'employees.source',
                DB::raw('DATE_FORMAT(employee_responses.created_at, "%d %b %Y") as formatted_date'),
                DB::raw('count(*) as total')
            )
            ->groupBy('employees.source', 'formatted_date')
            ->get();

        $ratingsGrafik = Feedback::leftJoin('employees', 'feedback.employee_id', '=', 'employees.id')
            ->select(
                'employees.source',
                DB::raw('DATE_FORMAT(feedback.created_at, "%d %b %Y") as formatted_date'),
                'feedback.rating',
                DB::raw('count(*) as total')
            )
            ->groupBy('employees.source', 'formatted_date', 'feedback.rating')
            ->get();

        $questionGrafik = Question::select(
            'questions.department',
            DB::raw('DATE_FORMAT(questions.created_at, "%d %b %Y") as formatted_date'),
            DB::raw('count(*) as total')
        )
            ->whereNotNull('questions.department')
            ->groupBy('questions.department', 'formatted_date')
            ->get();
        return view('admin.index', compact('sourcesGrafik', 'ratingsGrafik', 'questionGrafik'));
    }
}
