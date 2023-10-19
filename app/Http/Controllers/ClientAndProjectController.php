<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;

class ClientAndProjectController extends Controller
{
    public function index(){
        $clients = Client::all();
        return view('admin.client-and-project.index',compact('clients'));
    }

    public function storeClient(Request $request){
        $client = new Client();
        $client->name = $request->name;
        try {
            $client->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Client created successfully',
                'data' => $client
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Client creation failed',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function updateClient(Request $request){
        $id = $request->client_id;
        $client = Client::find($id);
        $client->name = $request->name;
        try {
            $client->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Client updated successfully',
                'data' => $client
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Client updation failed',
                'data' => $e->getMessage()
            ], 500);
        }

    }

    public function destroyClient(Client $client){
        try {
            $client->delete();
            $this->alert('Success','Client deleted successfully!','success');
            return redirect()->route('clients-and-projects-index');
        } catch (\Exception $e) {
            $this->alert('Failed','Failed','danger');
            return redirect()->route('clients-and-projects-index');
        }
    }

    public function storeProject(Request $request) {
        $project = new Project();
        $project->name = $request->name;
        $project->client_id = $request->client_id;
        try {
            $project->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Project created successfully',
                'data' => $project
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project creation failed',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function updateProject(Request $request){
        $id = $request->project_id;
        $project = Project::find($id);
        $project->name = $request->name;
        $project->client_id = $request->client_id;
        try {
            $project->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Project updated successfully',
                'data' => $project
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project updation failed',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function destroyProject(Project $project){
        try {
            $project->delete();
            $this->alert('Success','Project deleted successfully!','success');
            return redirect()->route('clients-and-projects-index');
        } catch (\Exception $e) {
            $this->alert('Failed','Failed','danger');
            return redirect()->route('clients-and-projects-index');
        }
    }
}
