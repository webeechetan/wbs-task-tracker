<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\User;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $teams = Team::all();
        return view("admin.teams.index", compact("users","teams"));
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
            'name' => 'required|string|max:255',
            'team_lead' => 'required|integer',
        ]);

        $team = new Team();
        $team->name = $request->name;
        $team->lead_id = $request->team_lead;
        try {
            $team->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Team created successfully',
                'data' => $team
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Team creation failed',
                'data' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $team = Team::find($request->team_id);
        $team->name = $request->name;
        $team->lead_id = $request->team_lead;
        try {
            $team->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Team updated successfully',
                'data' => $team
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Team update failed',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    { 
        try {
            $team->delete();
            $this->alert('Success', 'Team deleted successfully','success');
        } catch (\Exception $e) {
            $this->alert('Error', 'Team deletion failed','error');
        }
        return redirect()->route('teams-index');
    }

  
}
