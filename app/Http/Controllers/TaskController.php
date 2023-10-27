<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use App\Models\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        $startOfTheMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endOfTheMonth = Carbon::now()->endOfMonth()->format('Y-m-d');

        $dates = collect();

        for ($date = $startOfTheMonth; $date <= $endOfTheMonth; $date = Carbon::parse($date)->addDay()->format('Y-m-d')) {
            if(Carbon::parse($date)->isWeekend()){
                continue;
            }
            if(Carbon::parse($date)->isFuture()){
                continue;
            }
            $dates->push($date);
        }

        $calanderData = $dates->map(function($date){
            $tasks = Task::where('user_id', auth()->user()->id)
                ->whereDate('created_at', $date)
                ->orderBy('status')
                ->get();
            return [
                'date' => $date,
                'tasks' => $tasks
            ];
        });


        $selectedDate = $request->input('date');
        if ($selectedDate) {
            $tasks = Task::where('user_id', auth()->user()->id)
                ->whereDate('created_at', $selectedDate)
                ->orderBy('status')
                ->get();
        }else{
            // $tasks = Task::where('user_id', auth()->user()->id)->orderBy('status')->get();

            $tasks = Task::where('user_id', auth()->user()->id)
            ->whereDate('created_at', today()) // Assuming you want to filter by the 'created_at' column
            ->orderBy('status')
            ->get();

        }
        $projects = Project::all();
        return view('admin.tasks.index', compact('tasks','projects','calanderData'));
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
        $user = Auth::user();
        $task = new Task();
        $task->user_id = $user->id;
        $task->due_date = $request->due_date;
        $task->name = $request->task_name;
        $task->project_id = $request->project_name;
        $project = Project::where('id', $request->project_name)->first();
        $clientId = $project->client_id;
        $task->client_id = $clientId;

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
        // $task = Task::find($request->taskId);
        // $task->due_date = $request->due_date;
        // $task->name = $request->task_name;
        // $task->client = $request->client;
        // $task->project_id = $request->project_name;


        $task = Task::find($request->taskId);
        $task->due_date = $request->due_date;
        $task->name = $request->task_name;

        $task->project_id = $request->project_name;

        $project = Project::where('id', $request->project_name)->first();
        $clientId = $project->client_id;
        $task->client_id = $clientId;


        try{
            $task->save();
            $this->alert('success','Task Updated successfully','success');
            //return redirect()->route('task-mytodo');
            return back();
        }
        catch(\Exception $e){
            Log::critical($e->getMessage());
            $this->alert('error',$e->getMessage(),'danger');
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
            // return redirect()->route('task-index');
            return back();

        } else {
            $this->alert('error', 'Something went wrong', 'danger');
            return redirect()->back();
        }
    }


    public function statusupdate(Request $request, Task $task)
    {
        $status = '';
        if($task->status == 'pending'){
            $status = 'completed';
        }else{
            $status = 'pending';
        }
        try{
            $task->status = $status;
            $task->save();
            return response()->json(['success' => true, 'message' => 'Task status updated successfully', 'data' => $task], 200);
        }catch(\Exception $e){
            return response()->json(['success' => false,'message' => 'Something went wrong'], 500);
        }

    }

    
    public function teammates()
    {
        $team = Team::getTeam();
        $teammates= $team->load('members');
        
        return view('admin.tasks.teammates', compact('teammates'));
        
    }

    public function member_task($id, $date)
    {
   
        $tasks = Task::where('user_id', $id)
        ->where('created_at', 'LIKE', $date . '%')->get();
        return view('admin.tasks.member_tasks', compact('tasks'));
    

    }

 
    public function mytodo(Request $request) {
    
        $startOfTheMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endOfTheMonth = Carbon::now()->endOfMonth()->format('Y-m-d');

        $dates = collect();

        for ($date = $startOfTheMonth; $date <= $endOfTheMonth; $date = Carbon::parse($date)->addDay()->format('Y-m-d')) {
            if(Carbon::parse($date)->isWeekend()){
                continue;
            }
            if(Carbon::parse($date)->isFuture()){
                continue;
            }
            $dates->push($date);
        }

        $calanderData = $dates->map(function($date){
            $tasks = Task::where('user_id', auth()->user()->id)
                ->whereDate('created_at', $date)
                ->orderBy('status')
                ->get();

                $pendingCount = $tasks->where('status', 'pending')->count();
                $completedCount = $tasks->where('status', 'completed')->count();
            
                
        return [
                'date' => $date,
                'tasks' => $tasks,
                'pendingCount' => $pendingCount,
                'completedCount' => $completedCount
            ];
        });

        return view('admin.tasks.mytodo' ,compact('calanderData'));
    }

}
