<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;

class AdminEmployeeFeedbackController extends Controller
{
    public function index()
    {
        $employeeFeedbacks = Feedback::all();

        return view('admin.feedback.index', compact('employeeFeedbacks'));
    }
}
