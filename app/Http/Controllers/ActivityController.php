<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Team;
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
        $activities = Activity::all();
        $teams = Team::all();
        return view('admin.activity.index',compact('activities','teams'));
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
            $cron_expression = '0 0 '.$request->cron_day.' '.$request->cron_month.' *';
            $activity->cron_expression = $cron_expression;
            $activity->cron_string = $request->cron_string;
        }
        try {
            $activity->save();
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
        //
    }
}
