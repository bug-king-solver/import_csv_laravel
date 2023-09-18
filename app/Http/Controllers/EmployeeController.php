<?php

namespace App\Http\Controllers;

use App\Jobs\EmployeeCSVData;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\HeadingRowImport;

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

    private function validateExcelFileStructure(UploadedFile $file): string
    {
        $headings = (new HeadingRowImport)->toArray($file);
        $columnHeaders = isset($headings[0][0]) ?
            array_filter($headings[0][0], fn($heading) => is_string($heading)) : [];
        return match(true)
        {
            count($headings) > 1 => __('There are more than 1 sheets in file, Please remove the other sheets except the first one!'),
            !count($columnHeaders) => __('There are no headers in the first row.'),
            default => ''
        };
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function import(Request $request)
    {
        $validationError = $this->validateExcelFileStructure($request->file);
        if(!empty($validationError)) {
            return response()->json(["error", $validationError]);
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

