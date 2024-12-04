<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminQuestionController extends Controller
{
    public function index()
    {
        $dept = Auth::guard('admin')->user()->department;

        if ($dept === 'ALL') {
            $question = Question::orderByDesc('updated_at')
                ->orderByDesc('created_at')->get();
        } else {
            $question = Question::where('department', $dept)
                ->orderByDesc('updated_at')
                ->orderByDesc('created_at')
                ->get();
        }

        return view('admin.question.index', compact('question'));
    }

    public function add()
    {
        $dept = Department::all();

        return view('admin.question.add', compact('dept'));
    }

    public function store(Request $request)
    {
        $question = new Question();

        $validate = $request->validate([
            'department' => 'required',
            'category' => 'required',
            'question' => 'required',
            'answer' => 'required',
        ]);

        $question->department = $validate['department'];
        $question->category = $validate['category'];
        $question->question = $validate['question'];
        $question->answer = $validate['answer'];

        $question->save();

        return redirect()->route('admin.question.index')->with('success', 'Successfully added data');
    }

    public function show($encryptedId)
    {
        $id = decrypt($encryptedId);
        $question = Question::findOrFail($id);
        $dept = Department::all();

        return view('admin.question.edit', compact('question', 'dept'));
    }

    public function update(Request $request, $encryptedId)
    {
        $id = decrypt($encryptedId);
        $question = Question::findOrFail($id);

        $validate = $request->validate([
            'department' => 'required',
            'category' => 'required',
            'question' => 'required',
            'answer' => 'required',
        ]);

        $question->department = $validate['department'];
        $question->category = $validate['category'];
        $question->question = $validate['question'];
        $question->answer = $validate['answer'];

        $question->save();

        return redirect()->route('admin.question.index')->with('success', 'Successfully updated data');
    }

    public function destroy($encryptedId)
    {
        $id = decrypt($encryptedId);
        $question = Question::findOrFail($id);
        $question->employeeResponses()->delete();
        $question->delete();

        return redirect()->back()->with('success', 'Successfully deleted data');
    }
}
