<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class EmployeesImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    public function model(array $row)
    {
        return new Employee([
            'name'     => $row['name'],
            'position' => $row['position'],
        ]);
    }

    public function batchSize(): int
    {
        return 1000; 
    }

    public function chunkSize(): int
    {
        return 1000; 
    }
}
