<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class AdminEmployeeController extends Controller
{
    public function index()
    {
        $employee = Employee::latest()->get();

        return view('admin.employee.index', compact('employee'));
    }

    public function show($encryptedId)
    {
        $id = decrypt($encryptedId);
        $employee = Employee::findOrFail($id);

        return view('admin.employee.edit', compact('employee'));
    }

    public function update(Request $request, $encryptedId)
    {
        $id = decrypt($encryptedId);
        $employee = Employee::findOrFail($id);

        $validate = $request->validate([
            'name' => 'required',
            'nip' => 'required',
        ]);

        $employee->name = $validate['name'];
        $employee->nip = $validate['nip'];

        $employee->save();

        return redirect()->route('admin.employee.index')->with('success', 'Successfully updated data');
    }

    public function destroy($encryptedId)
    {
        $id = decrypt($encryptedId);
        $employee = Employee::findOrFail($id);
        $employee->employeeResponses()->delete();
        $employee->delete();

        return redirect()->back()->with('success', 'Successfully deleted data');
    }
}
