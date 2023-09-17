<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithValidation;

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

    public function rules(): array
    {
        return [
            'employee_id' => ['required', 'unique:employees,employee_id'],
            'name_prefix' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'middle_initial' => ['nullable', 'string'],
            'last_name' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:employees,email'],
            'date_of_birth' => ['required', 'date'],
            'time_of_birth' => ['required', 'date_format:h:i:s A'],
            'age_in_years' => ['required', 'numeric'],
            'date_of_joining' => ['required', 'date'],
            'age_in_company_years' => ['required', 'numeric'],
            'phone_no' => ['required', 'string'],
            'place_name' => ['required', 'string'],
            'county' => ['required', 'string'],
            'city' => ['required', 'string'],
            'zip' => ['required', 'string'],
            'region' => ['required', 'string'],
            'user_name' => ['required', 'string'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'employee_id.required' => 'The employee ID field is required.',
            'employee_id.unique' => 'This employee ID is already in use.',
            'name_prefix.required' => 'The name prefix field is required.',
            'name_prefix.string' => 'Please enter a valid name prefix.',
            'first_name.required' => 'The first name field is required.',
            'first_name.string' => 'Please enter a valid first name.',
            'middle_initial.string' => 'Please enter a valid middle initial.',
            'last_name.required' => 'The last name field is required.',
            'last_name.string' => 'Please enter a valid last name.',
            'gender.required' => 'The gender field is required.',
            'gender.string' => 'Please enter a valid gender.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already in use.',
            'date_of_birth.required' => 'The date of birth field is required.',
            'date_of_birth.date' => 'Please enter a valid date format for date of birth.',
            'time_of_birth.required' => 'The time of birth field is required.',
            'time_of_birth.date_format' => 'Please enter a valid time format for time of birth.',
            'age_in_years.required' => 'The age in years field is required.',
            'age_in_years.numeric' => 'Please enter a valid numeric value for age in years.',
            'date_of_joining.required' => 'The date of joining field is required.',
            'date_of_joining.date' => 'Please enter a valid date format for date of joining.',
            'age_in_company_years.required' => 'The age in company years field is required.',
            'age_in_company_years.numeric' => 'Please enter a valid numeric value for age in company years.',
            'phone_no.required' => 'The phone number field is required.',
            'phone_no.string' => 'Please enter a valid phone number.',
            'place_name.required' => 'The place name field is required.',
            'place_name.string' => 'Please enter a valid place name.',
            'county.required' => 'The county field is required.',
            'county.string' => 'Please enter a valid county.',
            'city.required' => 'The city field is required.',
            'city.string' => 'Please enter a valid city.',
            'zip.required' => 'The zip code field is required.',
            'zip.string' => 'Please enter a valid zip code.',
            'region.required' => 'The region field is required.',
            'region.string' => 'Please enter a valid region.',
            'user_name.required' => 'The user name field is required.',
            'user_name.string' => 'Please enter a valid user name.',
        ];
    }
}
