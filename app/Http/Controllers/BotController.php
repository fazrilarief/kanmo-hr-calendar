<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeResponse;
use App\Models\Feedback;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class BotController extends Controller
{
    public function showForm()
    {
        $questions = Question::whereNotNull('answer')
            ->whereNotNull('department')
            ->orderBy('department')
            ->orderByDesc('updated_at')
            ->orderByDesc('created_at')
            ->get();

        return view('index', compact('questions'));
    }

    public function saveUserAndQuestion(Request $request)
    {
        if ($request->filled('name') && $request->filled('nip')) {
            $inputName = $request->input('name');
            $nip = $request->input('nip');

            $employee = Employee::where('nip', $nip)->first();

            if (!$employee) {
                return redirect()->back()->with('error', 'Your nip is wrong. 😞');
            }

            $partialMatch = Employee::where('name', 'like', '%' . $inputName . '%')
                ->where('nip', $nip)
                ->first();

            if ($partialMatch) {
                $request->session()->put('name', $partialMatch->name);
                $request->session()->put('nip', $nip);

                return redirect()->back();
            } else {
                return redirect()->back()->with('error', 'Your name is not found. 😞');
            }
        } else {
            session(['savedData' => $request->all()]);
            $request->validate([
                'user_question' => 'string|required',
            ]);

            $userQuestion = $request->input('user_question');

            $question = Question::where('question', $userQuestion)->first();

            if ($question) {
                $name = $request->session()->get('name');
                $nip = $request->session()->get('nip');

                $employee = Employee::where('name', $name)
                    ->where('nip', $nip)
                    ->first();

                $employeeResponse = new EmployeeResponse([
                    'question_id' => $question->id,
                ]);

                $employee->employeeResponses()->save($employeeResponse);

                $latestResponse = EmployeeResponse::with('question')
                    ->where('employee_id', $employee->id)
                    ->whereHas('question', function ($query) use ($userQuestion) {
                        $query->where('question', $userQuestion)
                            ->whereNotNull('answer')
                            ->whereNotNull('question');
                    })
                    ->latest('created_at')
                    ->first();

                $response = [
                    'answer' => $question->answer,
                    'latestResponse' => $latestResponse,
                    'question' => $question->question,
                ];

                return response()->json($response);
            } else {
                $response = [
                    'answer' => 'No matching question found.',
                    'history' => [],
                    'question' => $userQuestion,
                ];

                return response()->json($response);
            }
        }
    }

    public function saveUserAndQuestionAnother(Request $request)
    {
        $request->validate([
            'user_question' => 'string|required',
        ]);

        $userQuestionText = $request->input('user_question');

        $userQuestion = new Question();
        $userQuestion->department = null;
        $userQuestion->category = null;
        $userQuestion->question = $userQuestionText;
        $userQuestion->answer = null;
        $userQuestion->save();

        $name = $request->session()->get('name');
        $nip = $request->session()->get('nip');

        $questionId = $userQuestion->id;

        $employee = Employee::where('name', $name)
            ->where('nip', $nip)
            ->first();

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        $employeeResponse = new EmployeeResponse([
            'question_id' => $questionId,
        ]);

        $employee->employeeResponses()->save($employeeResponse);

        $response = [
            'question' => $userQuestion,
            'employee_response' => $employeeResponse,
        ];

        $data = [
            'name' => $name,
            'nip' => $nip,
            'questionId' => $questionId,
            'question' => $userQuestionText,
        ];

        $recipientEmails = [
            'muhamad.agung@kanmogroup.com',
            'syahadatan.agdesuri@kanmogroup.com',
            'izzah.faizal@kanmogroup.com',
            'melki.saputro@kanmogroup.com',
            'sella.wulansari@kanmogroup.com',
            'wahyuningsih@kanmogroup.com',
            'wiwit.kristianto@kanmogroup.com',
            'yudi.priyanto@kanmogroup.com',
            'maulidhya.pramono@kanmogroup.com',
            'nadia.fadilah@kanmogroup.com',
        ];

        Mail::to($recipientEmails)->send(new SendEmail($data));

        return response()->json($response);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect()->route('showForm');
    }

    public function getChatHistory(Request $request)
    {
        $name = $request->session()->get('name');
        $nip = $request->session()->get('nip');

        $employee = Employee::where('name', $name)
            ->where('nip', $nip)
            ->first();

        if (!$employee) {
            return Response::json(['error' => 'Employee not found'], 404);
        }

        $history = EmployeeResponse::with('question')->where('employee_id', $employee->id)->get();

        $response = [
            'history' => $history,
        ];

        return Response::json($response);
    }

    public function saveUserAndFeedback(Request $request)
    {
        $request->validate([
            'rating' => 'required',
        ]);

        $name = $request->session()->get('name');
        $nip = $request->session()->get('nip');

        $employee = Employee::where('name', $name)
            ->where('nip', $nip)
            ->first();

        $employeeFeedback = new Feedback([
            'feedback' => $request->feedback ?? NULL,
            'rating' => $request->rating,
        ]);

        $employee->employeeFeedbacks()->save($employeeFeedback);

        $request->session()->flush();

        return redirect()->route('showForm');
    }
}
