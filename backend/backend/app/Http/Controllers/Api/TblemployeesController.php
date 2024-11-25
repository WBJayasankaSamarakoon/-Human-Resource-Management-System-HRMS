<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tblemployee;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TblemployeesController extends Controller
{
    // Display a listing of employees
    public function index(): JsonResponse
    {
        $employees = Tblemployee::all();
        return response()->json($employees, 200);
    }

    // Store a newly created employee
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'NameWithInitials' => 'required|string|max:255',
            'EPFNumber' => 'required|string|max:100',

            'Phone' => 'required|string|max:20',

            'CurrentAddress' => 'required|string',

            'PermanentAddress' => 'required|string',

            'PersonalEmail' => 'required|email|max:255',
            'CompanyEmail' => 'required|email|max:255',

            'DateOfJoining' => 'required|date',

            'Status' => 'required|in:Active,Inactive,Suspended,Left',

            'Salutation' => 'required|in:Mr,Ms,Mrs',

            'Designation' => 'required|string|max:100',
            'Branch' => 'required|string|max:100',

            'Company' => 'required|string|max:100',

            'ReportsTo' => 'required|string|max:100',

            'EmploymentType' => 'required|in:Intern,Full-time,Part-time,Contract',

            'EmergencyContactName' => 'required|string|max:255',

            'EmergencyPhone' => 'required|string|max:20',

            'Relation' => 'required|string|max:100',

            'DefaultShift' => 'required|string|max:100',
            'EmpId' => 'required|string|max:50',
        ]);

        $employee = Tblemployee::create($request->all());
        return response()->json($employee, 201);
    }

    // Display the specified employee
    public function show($id): JsonResponse
    {
        $employee = Tblemployee::find($id);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        return response()->json($employee, 200);
    }

    // Update the specified employee
    public function update(Request $request, $id): JsonResponse
    {
        $employee = Tblemployee::find($id);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        $request->validate([
           'NameWithInitials' => 'required|string|max:255',
            'EPFNumber' => 'required|string|max:100',

            'Phone' => 'required|string|max:20',

            'CurrentAddress' => 'required|string',

            'PermanentAddress' => 'required|string',

            'PersonalEmail' => 'required|email|max:255',
            'CompanyEmail' => 'required|email|max:255',

            'DateOfJoining' => 'required|date',

            'Status' => 'required|in:Active,Inactive,Suspended,Left',

            'Salutation' => 'required|in:Mr,Ms,Mrs',

            'Designation' => 'required|string|max:100',
            'Branch' => 'required|string|max:100',

            'Company' => 'required|string|max:100',

            'ReportsTo' => 'required|string|max:100',

            'EmploymentType' => 'required|in:Intern,Full-time,Part-time,Contract',

            'EmergencyContactName' => 'required|string|max:255',

            'EmergencyPhone' => 'required|string|max:20',

            'Relation' => 'required|string|max:100',

            'DefaultShift' => 'required|string|max:100',
            'EmpId' => 'required|string|max:50',
        ]);

        $employee->update($request->all());
        return response()->json($employee, 200);
    }

    // Remove the specified employee
    public function destroy($id): JsonResponse
    {
        $employee = Tblemployee::find($id);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        $employee->delete();
        return response()->json(['message' => 'Employee deleted successfully'], 200);
    }
}
