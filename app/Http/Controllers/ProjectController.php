<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }
   public function index()
    {
        return response()->json(Project::all());
    }
    public function store(Request $request)
    {
        $validation=$request->validate([
            'employee_id'=>'required|exists:employees,id',
            'title'=>'required|string|max:255',
            'description'=>'nullable|string'
        ]);
        $project = Project::create($validation);
        return response()->json($project, 201);
    }
    public function update(Request $request ,$id){
        $project = Project::findOrFail($id);
         $validation = $request->validate([
        'employee_id' => 'sometimes|exists:employees,id',
        'title' => 'sometimes|string|max:255',
        'description' => 'nullable|string'
    ]);
        $project->update($validation);
        return response()->json($project);
    }
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully']);
    }
}
