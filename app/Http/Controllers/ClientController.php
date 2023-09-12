<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients =  Client::orderBy('name')->get();
        return view('admin.clients.index',compact('clients'));
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
        $client = new Client();
        $client->name = $request->name;
        try{
            $client->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Team created successfully',
                'data' => $client
            ], 201);
        }
        catch(\Exception $e){
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
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $client = Client::find($request->id);
        $client->name = $request->name;
        try{
            $client->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Client updated successfully',
                'data' => $client
            ], 201);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Client update failed',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        try{
            $client->delete();
            $this->alert('Success', 'Client deleted successfully','success');
        }
        catch(\Exception $e){
            $this->alert('Error', 'Client deletion failed','error');
        }

        return redirect()->route('clients-index');
    }
}
