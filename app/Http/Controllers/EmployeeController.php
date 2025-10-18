<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;


/**
 * @OA\Response(
 *     response=422,
 *     description="Validation error",
 *     @OA\JsonContent(
 *         type="object",
 *         @OA\Property(property="message", type="string", example="The given data was invalid."),
 *         @OA\Property(
 *             property="errors",
 *             type="object",
 *             example={
 *                 "name": {"The name field is required."},
 *                 "email": {"The email must be a valid email address."}
 *             }
 *         )
 *     )
 * )
 */
class EmployeeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/employees",
     *     summary="Get all employees",
     *     tags={"Employees"},
     *     @OA\Response(
     *         response=200,
     *         description="List of employees",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Employee")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Employee::all());
    }

    /**
     * @OA\Post(
     *     path="/api/employees",
     *     summary="Create a new employee",
     *     tags={"Employees"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","phone"},
     *             @OA\Property(property="name", type="string", example="Lujine"),
     *             @OA\Property(property="email", type="string", format="email", example="lujine@gmail.com"),
     *             @OA\Property(property="phone", type="string", example="+9626118158"),
     *             @OA\Property(property="position", type="string", example="Developer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Employee created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Employee")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         ref="#/components/responses/422"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employees,email',
            'phone' => 'required|string|max:20|unique:employees,phone',
            'position' => 'nullable|string|max:100',
        ]);

        $employee = Employee::create($validated);
        return response()->json($employee, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/employees/{id}",
     *     summary="Get an employee by ID",
     *     tags={"Employees"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Employee ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Employee found",
     *         @OA\JsonContent(ref="#/components/schemas/Employee")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Employee not found"
     *     )
     * )
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }

    /**
     * @OA\Put(
     *     path="/api/employees/{id}",
     *     summary="Update an existing employee",
     *     tags={"Employees"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Employee ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","phone"},
     *             @OA\Property(property="name", type="string", example="Lujine Khasawneh"),
     *             @OA\Property(property="email", type="string", format="email", example="lujine@gmail.com"),
     *             @OA\Property(property="phone", type="string", example="+9626118158"),
     *             @OA\Property(property="position", type="string", example="php laravel")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Employee updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Employee")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Employee not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         ref="#/components/responses/422"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('employees')->ignore($employee->id)],
            'phone' => ['required', 'string', 'max:20', Rule::unique('employees')->ignore($employee->id)],
            'position' => 'nullable|string|max:100',
        ]);

        $employee->update($validated);
        return response()->json($employee);
    }

    /**
     * @OA\Delete(
     *     path="/api/employees/{id}",
     *     summary="Delete an employee",
     *     tags={"Employees"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Employee ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Employee deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Employee not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        Employee::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
