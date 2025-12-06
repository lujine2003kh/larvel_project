<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/projects/{id}",
 *     summary="Get a single project with full employee info",
 *     tags={"Projects"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Project ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Project found",
 *         @OA\JsonContent(ref="#/components/schemas/ProjectWithEmployee")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Project not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Project not found")
 *         )
 *     )
 * )
 */

 public function show($id)
{
    $project = Project::with('employee')->findOrFail($id);

    return response()->json([
        'id' => $project->id,
        'title' => $project->title,
        'description' => $project->description,
        'employee' => [
            'id' => $project->employee->id,
            'name' => $project->employee->name,
            'email' => $project->employee->email,
            'phone' => $project->employee->phone,
        ],
    ]);
}

/**
 * @OA\Get(
 *     path="/api/projects",
 *     summary="Get all projects",
 *     tags={"Projects"},
 *     @OA\Response(
 *         response=200,
 *         description="List of projects",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Project")
 *         )
 *     )
 * )
 */

   public function index()
    {
        return response()->json(Project::all());
    }

/**
 * @OA\Post(
 *     path="/api/projects",
 *     summary="Create a new project",
 *     tags={"Projects"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"employee_id","title"},
 *             @OA\Property(property="employee_id", type="integer", example=1),
 *             @OA\Property(property="title", type="string", example="Mobile App"),
 *             @OA\Property(property="description", type="string", example="App features")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Project created successfully",
 *         @OA\JsonContent(ref="#/components/schemas/Project")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(ref="#/components/responses/422")
 *     )
 * )
 */
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

/**
 * @OA\Put(
 *     path="/api/projects/{id}",
 *     summary="Update an existing project",
 *     tags={"Projects"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Project ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="employee_id", type="integer", example=1),
 *             @OA\Property(property="title", type="string", example="Updated Mobile App"),
 *             @OA\Property(property="description", type="string", example="New features")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Project updated successfully",
 *         @OA\JsonContent(ref="#/components/schemas/Project")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         ref="#/components/responses/422"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Project not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Project not found")
 *         )
 *     )
 * )
 */
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

/**
 * @OA\Delete(
 *     path="/api/projects/{id}",
 *     summary="Delete a project",
 *     tags={"Projects"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Project ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Project deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Project deleted successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Project not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Project not found")
 *         )
 *     )
 * )
 */

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully']);
    }
}
