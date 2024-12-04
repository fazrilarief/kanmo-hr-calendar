<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeResponse;
use App\Models\Feedback;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSummaryDataController extends Controller
{
    public function response_index()
    {
        $employeeResponses = EmployeeResponse::join('employees', 'employee_responses.employee_id', '=', 'employees.id')
            ->join('questions', 'employee_responses.question_id', '=', 'questions.id')
            ->whereNotNull('questions.department')
            ->select(
                'questions.department as employee_department',
                'employees.division as employee_division',
                'employees.source as employee_source',
                'employee_responses.*'
            )
            ->orderByDesc('updated_at')
            ->orderByDesc('created_at')
            ->get();

        $totalResponsesPerDepartment = $employeeResponses->groupBy('employee_department')
            ->map(function ($responses) {
                return $responses->count();
            });

        $allDepartments = Question::whereNotNull('department')->distinct('department')->pluck('department');

        foreach ($allDepartments as $department) {
            if (!isset($totalResponsesPerDepartment[$department])) {
                $totalResponsesPerDepartment[$department] = 0;
            }
        }

        return view('admin.summarydata.response.index', compact('totalResponsesPerDepartment'));
    }

    public function response_department($department)
    {
        $employeeResponses = EmployeeResponse::join('employees', 'employee_responses.employee_id', '=', 'employees.id')
            ->join('questions', 'employee_responses.question_id', '=', 'questions.id')
            ->where('questions.department', $department)
            ->select(
                'questions.category',
                'employee_responses.*'
            )
            ->orderByDesc('updated_at')
            ->orderByDesc('created_at')
            ->get();

        $totalResponsesPerCategory = $employeeResponses->groupBy('category')
            ->map(function ($responses) {
                return $responses->count();
            });

        return view('admin.summarydata.response.department', compact('department', 'totalResponsesPerCategory'));
    }

    public function response_category($category)
    {
        $employeeResponses = EmployeeResponse::join('employees', 'employee_responses.employee_id', '=', 'employees.id')
            ->join('questions', 'employee_responses.question_id', '=', 'questions.id')
            ->where('questions.category', $category)
            ->select(
                'questions.question',
                'employee_responses.*'
            )
            ->orderByDesc('updated_at')
            ->orderByDesc('created_at')
            ->get();

        $totalResponsesPerQuestion = $employeeResponses->groupBy('question')
            ->map(function ($responses) {
                return $responses->count();
            });

        return view('admin.summarydata.response.category', compact('category', 'totalResponsesPerQuestion'));
    }

    public function response_question($question)
    {
        $employeeResponses = EmployeeResponse::select([
            'questions.question AS question',
            'employees.nip AS nip',
            'employees.name AS name',
            'employees.division AS division',
            'employees.department AS department',
            'employee_responses.created_at AS created_at',
        ])
            ->join('questions', 'employee_responses.question_id', '=', 'questions.id')
            ->join('employees', 'employee_responses.employee_id', '=', 'employees.id')
            ->where('questions.question', 'like', '%' . $question . '%')
            ->get();

        return view('admin.summarydata.response.employee', compact('question', 'employeeResponses'));
    }

    public function feedback_index()
    {
        $employeeFeedbacks = Feedback::select('rating', DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->orderBy('rating')
            ->get();

        return view('admin.summarydata.feedback.index', compact('employeeFeedbacks'));
    }

    public function feedback_rating($rating)
    {
        $employeeFeedbacks = Feedback::where('rating', $rating)->get();

        return view('admin.summarydata.feedback.rating', compact('employeeFeedbacks', 'rating'));
    }

    public function question_index()
    {
        $employeeQuestions = Question::all();

        $departmentTotals = $employeeQuestions->groupBy('department')
            ->map(function ($questions, $department) {
                return [
                    'department' => $department,
                    'totalQuestion' => $questions->count(),
                ];
            });

        $departmentTotals = $departmentTotals->sortByDesc('totalQuestion');

        $departmentTotals = $departmentTotals->filter(function ($departmentTotal) {
            return !empty($departmentTotal['department']);
        });

        return view('admin.summarydata.question.index', compact('departmentTotals'));
    }

    public function question_department($department)
    {
        $departmentQuestions = Question::where('department', $department)->get();

        $categoryTotals = $departmentQuestions->groupBy('category')
            ->map(function ($questions, $category) {
                return [
                    'category' => $category,
                    'totalQuestion' => $questions->count(),
                ];
            });

        $categoryTotals = $categoryTotals->sortByDesc('totalQuestion');

        return view('admin.summarydata.question.department', compact('department', 'categoryTotals'));
    }

    public function question_category($category)
    {
        $categoryQuestions = Question::where('category', $category)
            ->get();

        return view('admin.summarydata.question.category', compact('category', 'categoryQuestions'));
    }

    public function employee_index()
    {
        $sources = Employee::leftJoin('employee_responses', 'employees.id', '=', 'employee_responses.employee_id')
            ->select('employees.source', DB::raw('COUNT(employees.id) AS TotalEmployeeSource'), DB::raw('COUNT(employee_responses.employee_id) AS TotalEmployeeResponseSource'))
            ->whereNotNull('employees.source')
            ->where('employees.source', '!=', '')
            ->groupBy('employees.source')
            ->get();

        return view('admin.summarydata.employee.index', compact('sources'));
    }

    public function employee_source($sources)
    {
        $divisions = Employee::leftJoin('employee_responses', 'employees.id', '=', 'employee_responses.employee_id')
            ->select(
                'employees.source',
                'employees.division',
                DB::raw('COUNT(employees.id) AS TotalEmployeeDivision'),
                DB::raw('COUNT(employee_responses.employee_id) AS TotalEmployeeResponseDivision')
            )
            ->where('employees.source', $sources)
            ->groupBy('employees.source', 'employees.division')
            ->get();

        return view('admin.summarydata.employee.source', compact('divisions', 'sources'));
    }

    public function employee_division($sources, $divisions)
    {
        $departments = Employee::leftJoin('employee_responses', function ($join) {
            $join->on('employees.id', '=', 'employee_responses.employee_id');
        })
            ->select(
                'employees.source',
                'employees.department',
                'employees.division',
                DB::raw('COUNT(employees.id) AS TotalEmployeeDepartment'),
                DB::raw('SUM(CASE WHEN employee_responses.employee_id IS NOT NULL THEN 1 ELSE 0 END) AS TotalEmployeeResponseDepartment'),
                DB::raw('SUM(CASE WHEN employee_responses.employee_id IS NULL THEN 1 ELSE 0 END) AS TotalEmployeeWithoutResponseDepartment')
            )
            ->where('employees.division', $divisions)
            ->where('employees.source', $sources)
            ->groupBy('employees.source', 'employees.division', 'employees.department')
            ->get();

        return view('admin.summarydata.employee.department', compact('sources', 'divisions', 'departments'));
    }

    public function employee_division_detail($sources, $divisions, $departments)
    {
        $employees = EmployeeResponse::leftJoin('employees', 'employee_responses.employee_id', '=', 'employees.id')
            ->leftJoin('questions', 'employee_responses.question_id', '=', 'questions.id')
            ->select(
                'employees.source',
                'employees.department',
                'employees.division',
                'employees.name',
                'employees.nip',
                'questions.question',
                'questions.answer',
                'employee_responses.created_at',
                'employee_responses.updated_at',
            )
            ->where('employees.department', $departments)
            ->where('employees.division', $divisions)
            ->where('employees.source', $sources)
            ->groupBy('employees.source', 'employees.division', 'employees.department', 'employees.nip', 'employees.name', 'questions.question', 'questions.answer', 'employee_responses.created_at', 'employee_responses.updated_at')
            ->orderByDesc('created_at')
            ->orderByDesc('updated_at')
            ->get();

        return view('admin.summarydata.employee.department', compact('employees', 'sources', 'divisions', 'departments'));
    }

    public function response_employee_index()
    {
        $sources = Employee::leftJoin('employee_responses', 'employees.id', '=', 'employee_responses.employee_id')
            ->select('employees.source', DB::raw('COUNT(employee_responses.employee_id) AS TotalEmployeeResponseSource'))
            ->whereNotNull('employees.source')
            ->where('employees.source', '!=', '')
            ->groupBy('employees.source')
            ->get();

        return view('admin.summarydata.response_employee.index', compact('sources'));
    }

    public function response_employee_source($sources)
    {
        $divisions = Employee::leftJoin('employee_responses', 'employees.id', '=', 'employee_responses.employee_id')
            ->select(
                'employees.source',
                'employees.division',
                DB::raw('COUNT(employee_responses.employee_id) AS TotalEmployeeResponseDivision')
            )
            ->where('employees.source', $sources)
            ->groupBy('employees.source', 'employees.division')
            ->get();

        return view('admin.summarydata.response_employee.source', compact('divisions', 'sources'));
    }

    public function response_employee_division($sources, $divisions)
    {
        $departments = Employee::leftJoin('employee_responses', 'employees.id', '=', 'employee_responses.employee_id')
            ->select(
                'employees.source',
                'employees.department',
                'employees.division',
                DB::raw('COUNT(employee_responses.employee_id) AS TotalEmployeeResponseDepartment')
            )
            ->where('employees.division', $divisions)
            ->where('employees.source', $sources)
            ->groupBy('employees.source', 'employees.division', 'employees.department')
            ->get();

        return view('admin.summarydata.response_employee.department', compact('sources', 'divisions', 'departments'));
    }

    public function response_employee_detail($sources, $divisions, $departments)
    {
        $employees = EmployeeResponse::leftJoin('employees', 'employee_responses.employee_id', '=', 'employees.id')
            ->leftJoin('questions', 'employee_responses.question_id', '=', 'questions.id')
            ->select(
                'employees.source',
                'employees.department',
                'employees.division',
                'employees.name',
                'employees.nip',
                'questions.question',
                'questions.answer',
                'employee_responses.created_at',
                'employee_responses.updated_at',
            )
            ->where('employees.department', $departments)
            ->where('employees.division', $divisions)
            ->where('employees.source', $sources)
            ->groupBy('employees.source', 'employees.division', 'employees.department', 'employees.nip', 'employees.name', 'questions.question', 'questions.answer', 'employee_responses.created_at', 'employee_responses.updated_at')
            ->orderByDesc('created_at')
            ->orderByDesc('updated_at')
            ->get();

        return view('admin.summarydata.response_employee.detail', compact('sources', 'departments', 'employees'));
    }

    public function employee_response_division($sources, $divisions, $departments)
    {
        $employees = EmployeeResponse::leftJoin('employees', 'employee_responses.employee_id', '=', 'employees.id')
            ->leftJoin('questions', 'employee_responses.question_id', '=', 'questions.id')
            ->select(
                'employees.source',
                'employees.department',
                'employees.division',
                'employees.name',
                'employees.nip',
                'questions.question',
                'questions.answer',
                'employee_responses.created_at',
                'employee_responses.updated_at',
            )
            ->where('employees.department', $departments)
            ->where('employees.division', $divisions)
            ->where('employees.source', $sources)
            ->groupBy('employees.source', 'employees.division', 'employees.department', 'employees.nip', 'employees.name', 'questions.question', 'questions.answer', 'employee_responses.created_at', 'employee_responses.updated_at')
            ->orderByDesc('created_at')
            ->orderByDesc('updated_at')
            ->get();

        return view('admin.summarydata.response_employee.detail', compact('sources', 'departments', 'employees'));
    }

    public function employee_not_response_division($sources, $divisions, $departments)
    {
        $employees = Employee::leftJoin('employee_responses', 'employees.id', '=', 'employee_responses.employee_id')
            ->leftJoin('questions', 'employee_responses.question_id', '=', 'questions.id')
            ->select(
                'employees.source',
                'employees.department',
                'employees.division',
                'employees.name',
                'employees.nip',
                'questions.question',
                'questions.answer',
                'employee_responses.created_at',
                'employee_responses.updated_at'
            )
            ->where('employees.department', $departments)
            ->where('employees.division', $divisions)
            ->where('employees.source', $sources)
            ->whereNull('employee_responses.employee_id')
            ->groupBy(
                'employees.source',
                'employees.division',
                'employees.department',
                'employees.nip',
                'employees.name',
                'questions.question',
                'questions.answer',
                'employee_responses.created_at',
                'employee_responses.updated_at'
            )
            ->orderByDesc('created_at')
            ->orderByDesc('updated_at')
            ->get();

        return view('admin.summarydata.employee.not_response', compact('sources', 'departments', 'employees'));
    }
}
