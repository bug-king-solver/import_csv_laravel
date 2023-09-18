<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Carbon\Carbon;

class EmployeeImport implements ToModel, WithHeadingRow
{

    public function __construct()
    {
        HeadingRowFormatter::default('none');
    }
    /**
    * @param array $row
    */
    public function model(array $row)
    {
        return new Employee([
            'employee_id' => $row['Emp ID'],
            'name_prefix' => $row['Name Prefix'],
            'first_name' => $row['First Name'],
            'middle_initial' => $row['Middle Initial'],
            'last_name' => $row['Last Name'],
            'gender' => $row['Gender'],
            'email' => $row['E Mail'],
            'date_of_birth' => Carbon::createFromFormat('m/d/Y', $row['Date of Birth']),
            'time_of_birth' => Carbon::createFromFormat('h:i:s A', $row['Time of Birth']),
            'age_in_years' => (float)$row['Age in Yrs.'],
            'date_of_joining' => Carbon::createFromFormat('m/d/Y', $row['Date of Joining']),
            'age_in_company_years' => (float)$row['Age in Company (Years)'],
            'phone_no' => $row['Phone No. '],
            'place_name' => $row['Place Name'],
            'county' => $row['County'],
            'city' => $row['City'],
            'zip' => $row['Zip'],
            'region' => $row['Region'],
            'user_name' => $row['User Name'],
        ]);
    }
}
