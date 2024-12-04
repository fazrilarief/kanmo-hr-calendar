<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.profile.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->guard('admin')->user();

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $admin = Admin::where('id', $user->id)->first();
        $admin->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('admin.index')->with('success', 'Successfully updated profile.');
    }

    public function reset_password(Request $request)
    {
        $user = auth()->guard('admin')->user();

        $request->validate([
            'password' => 'required|confirmed|min:5',
        ]);

        $admin = Admin::find($user->id);
        $admin->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('admin.index')->with('success', 'Successfully updated password.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
