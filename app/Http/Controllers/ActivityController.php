<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Team;
USE App\Models\User;
use Illuminate\Http\Request;
use App\Models\Reminder;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewActivityAssigned;
use Carbon\Carbon;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $user = Auth::user();
        // if($user->type == '1' ){
            if($user->type == '1' || $user->type == '2' || $user->type == '3'){
            //$activities = Activity::with(['team','assignedUsers','reminders'])->orderBy('status')->get();
        
            $activities = Activity::with(['team', 'assignedUsers', 'reminders'])
            ->orderByRaw("CASE 
                WHEN status = 'pending' THEN 0 
                WHEN status = 'in_progress' THEN 1
                ELSE 2 
                END")
            ->get();

        }else{
            $assigned_teams = $user->teams()->pluck('team_id')->toArray();
            $activities = Activity::with(['team','assignedUsers','reminders'])->whereIn('team_id',$assigned_teams)->get();
        }
        $teams = Team::all();
        $users = User::all();
        return view('admin.activity.index',compact('activities','teams','users'));
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

        // return $request->all();

        
        $request->validate([
                'team' => 'required|int',
                'activity' => 'required',
                'first_due_date' => 'required|date',
            ]);

        $activity = new Activity();

       

        $activity->team_id = $request->team;
        $activity->name = $request->activity;
        $activity->first_due_date = $request->first_due_date;
        $activity->created_by = auth()->user()->id;
        if($request->has('cron_day') && $request->has('cron_month') && $request->cron_month){

            $day = implode(',',$request->cron_day);
            $month = implode(',',$request->cron_month);
            $cron_expression = '30 10 '.$day.' '.$month.' *';
            $activity->cron_expression = $cron_expression;
            $activity->cron_string = $request->cron_string;
        }
        try {
            $activity->save();
            $activity->assignedUsers()->attach($request->assign_to);

            if($request->has('reminder_date')){

               
               
                $reminder_dates = $request->reminder_date;
                // $reminder_dates = implode(',',$reminder_dates);

                $currentMonth = Carbon::now()->format('m');
                $currentYear = Carbon::now()->format('Y');

              
               
                
                foreach ($reminder_dates as $key => $value) {

                    
                $reminder_date = $currentYear . '-' . $currentMonth . '-' . $value;
                  
                    $reminder = new Reminder();
                    $reminder->activity_id = $activity->id;
                    $reminder->reminder_date = $reminder_date;
                    $reminder->save();
                }
            }

            $activity->notify(new NewActivityAssigned($activity));

            $this->alert('Success','Activity created successfully','success');
            
            return redirect()->back();
        } catch (\Throwable $th) {
            $msg = $th->getMessage();
            $this->alert('Error',$msg,'danger');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
                'team' => 'required|int',
                'activity' => 'required',
                'first_due_date' => 'required|date',
            ]);

        $activity = Activity::find($request->activityId);
        $activity->team_id = $request->team;
        $activity->name = $request->activity;
        $activity->first_due_date = $request->first_due_date;
        $activity->created_by = auth()->user()->id;
        if($request->has('cron_day') && $request->has('cron_month') && $request->cron_month){

            $day = implode(',',$request->cron_day);
            $month = implode(',',$request->cron_month);
            $cron_expression = '30 10 '.$day.' '.$month.' *';
            $activity->cron_expression = $cron_expression;
            $activity->cron_string = $request->cron_string;
        }
        try {
            $activity->save();
            $activity->assignedUsers()->sync($request->assign_to);

            if($request->has('reminder_date')){
                $activity->reminders()->delete();
                $reminder_dates = $request->reminder_date;
                $reminder_dates = explode(',',$reminder_dates);
                foreach ($reminder_dates as $key => $value) {
                    $reminder = new Reminder();
                    $reminder->activity_id = $activity->id;
                    $reminder->reminder_date = $value;
                    $reminder->save();
                }
            }

            $this->alert('Success','Activity updated successfully','success');
            return redirect()->back();
        } catch (\Throwable $th) {
            $msg = $th->getMessage();
            $this->alert('Error',$msg,'danger');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        if($activity->delete()){
            $this->alert('Success','Activity deleted successfully','success');
            return redirect()->route('activity-index');
        }else {
            $this->alert('Error','Something went wrong','danger');
            return redirect()->back();
        }
    }


    public function statusupdate(Request $request, Activity $activity)
    {
        
        $activity->status = ($activity->status == 'pending') ? 'completed' : 'pending';
        
        $activity->save();

        return response()->json(['message' => 'Activity status updated successfully'], 200);
    }

    public function pending(Request $request)
    {
        $activities = Activity::where('status', 'pending')->get();

        $teams = Team::all();
        $users = User::all();
        return view('admin.activity.index',compact('activities','teams','users'));
      
    }

    public function completed(Request $request)
    {
        $activities = Activity::where('status', 'completed')->get();

        $teams = Team::all();
        $users = User::all();
        return view('admin.activity.index',compact('activities','teams','users'));
       
    }


 }
