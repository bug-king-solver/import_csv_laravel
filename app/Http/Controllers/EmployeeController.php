<?php

namespace App\Http\Controllers;

use App\Jobs\EmployeeCSVData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;

class EmployeeController extends Controller
{

    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    public function show($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        return response()->json($employee);
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        $employee->delete();
        return response()->json(['message' => 'Employee deleted'], 200);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,txt',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Store the uploaded file in a temporary location
        $file = $request->file('file');
        $filePath = $file->store('temp');
        // Dispatch a job to process the CSV file in the background
        EmployeeCSVData::dispatch($filePath);

        // Respond with a success message
        return response()->json(['message' => 'CSV file queued for import']);
    
    }
}

