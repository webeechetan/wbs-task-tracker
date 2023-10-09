<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::where('user_id', auth()->user()->id)->orderBy('status')->get();
        $clients = Task::select('client')->distinct()->get();
        return view('admin.tasks.index', compact('tasks','clients'));
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
        $task = new Task();
        $task->user_id = 1;
        $task->due_date = $request->due_date;
        $task->name = $request->task_name;
        $task->client = $request->client;

        if ($task->save()) {
            $this->alert('success', 'Task Added successfully', 'success');
            return redirect()->route('task-index');
        }
        $this->alert('error', 'Something went wrong', 'error');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('admin.tasks.index', compact('edit_task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        $task = Task::find($request->taskId);
        $task->due_date = $request->due_date;
        $task->name = $request->task_name;
        $task->client = $request->client;
        try{
            $task->save();
            $this->alert('success','Task Updated successfully','success');
            return redirect()->route('task-index');
        }
        catch(\Exception $e){
            $this->alert('error','Something went wrong','danger');
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if ($task->delete()) {
            $this->alert('success', 'Task Deleted successfully', 'success');
            return redirect()->route('task-index');
        } else {
            $this->alert('error', 'Something went wrong', 'danger');
            return redirect()->back();
        }
    }


    public function statusupdate(Request $request, Task $task)
    {
        if($request->status=='pending'){
            $task->status = 'completed';
        }
        if($request->status=='completed'){
            $task->status = 'pending';
        }
        $task->save();

        return response()->json(['message' => 'Task status updated successfully'], 200);
    }

}
