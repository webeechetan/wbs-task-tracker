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

        $tasks = Task::all();

        return view('admin.tasks.index', compact('tasks'));
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
        $task->project_id = $request->project_id;

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {

        // echo "update";
        // exit
        $request ->validate([
            'due_date' => 'required',
            'task_name' => 'required',
        ]);
        $task->due_date = $request->due_date;
        $task->task_name = $request->task_name;
        $task->project_id = $request->project_id;

        
        if($task->save()){
            $this->alert('success','Task Updated successfully','success');
            return redirect()->route('task-index');
        }
        $this->alert('error','Something went wrong','danger');
        return redirect()->back();

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
}
