<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Team;
USE App\Models\User;
use Illuminate\Http\Request;
use App\Models\Reminder;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewActivityAssigned;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->type == '1' ){
            $activities = Activity::with(['team','assignedUsers','reminders'])->get();
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
                foreach ($request->reminder_date as $key => $value) {
                    $reminder = new Reminder();
                    $reminder->activity_id = $activity->id;
                    $reminder->reminder_date = $value;
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
                foreach ($request->reminder_date as $key => $value) {
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
