<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Team;
USE App\Models\User;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Activity::orderBy('status')->get();
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
                'second_due_date' => 'required|date',
            ]);

        $activity = new Activity();
        $activity->team_id = $request->team;
        $activity->name = $request->activity;
        $activity->first_due_date = $request->first_due_date;
        $activity->second_due_date = $request->second_due_date;
        $activity->created_by = auth()->user()->id;
        if($request->has('cron_day') && $request->has('cron_month') && $request->cron_month){

            $day = implode(',',$request->cron_day);
            $month = implode(',',$request->cron_month);
            $cron_expression = '30 10 '.$day.' '.$month.' *';
            // $cron_expression = '30 10 '.$request->cron_day.' '.$month.' *';
            $activity->cron_expression = $cron_expression;
            $activity->cron_string = $request->cron_string;
        }
        try {
            try{

                $activity->save();
                $activity->assignedUsers()->attach($request->assign_to);
            }catch(\Throwable $th){
                $msg = $th->getMessage();
                $this->alert('Error',$msg,'danger');
                return redirect()->back();
            }
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
    public function update(Request $request, Activity $activity)
    {
        //
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


 }
