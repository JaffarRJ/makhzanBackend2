<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
class EmployeeImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Employee([
            'first_name' => $row[0],
            'last_name' => $row[1],
            'user_name' => $row[2],
            'email' => $row[3],
            'password' => Hash::make($row[4]),
            'employee_id' => $row[5],
            'join_date' => Date::excelToDateTimeObject($row[6]),
            'phone' => $row[7],
            'company' => $row[8],
            'department' => $row[9],
            'designation' => $row[10],
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
