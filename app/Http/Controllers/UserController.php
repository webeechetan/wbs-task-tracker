<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Team::all();
        return view('admin.user.create',compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->emp_name;
        $user->email = $request->emp_email;
        $user->password = Hash::make($request->password);
        $user->type = $request->type;
        $user->slack_id = $request->emp_slack_id;
        if ($user->save()) {
            $user->teams()->attach($request->team);
            $this->alert('success', 'Employee Added successfully', 'success');
            return redirect()->route('user-index');
        }
        $this->alert('error', 'Something went wrong', 'error');
        return redirect()->back();
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
    public function edit(User $user)
    {
        $teams = Team::all();
        return view('admin.user.edit', compact('user','teams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->emp_name;
        $user->email = $request->emp_email;
        $user->type = $request->type;
        $user->slack_id = $request->emp_slack_id;
        if ($user->save()) {
            $user->teams()->sync($request->team);
            $this->alert('success', 'Employee Updated successfully', 'success');
            return redirect()->route('user-index');
        }
        $this->alert('error', 'Something went wrong', 'error');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        if ($user->delete()) {
            $this->alert('success', 'User Deleted successfully', 'success');
            return redirect()->route('user-index');
        } else {
            $this->alert('error', 'Something went wrong', 'danger');
            return redirect()->back();
        }
    }

    public function member_calander(User $user){
        $currentDate = now();
        return view('admin.tasks.calanderph',compact('user','currentDate'));
    }
}
