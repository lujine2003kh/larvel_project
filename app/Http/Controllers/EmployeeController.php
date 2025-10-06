<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Validation\Rule;


class EmployeeController extends Controller
{
    public function index()
    {
        return response()->json(Employee::all());
    }

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

    public function destroy($id)
    {
        Employee::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
    
    public function show($id)
    {
    $employee = Employee::findOrFail($id);
    return response()->json($employee);
    }
}
