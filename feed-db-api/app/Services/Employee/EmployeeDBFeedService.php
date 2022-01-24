<?php

namespace App\Services\Employee;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmployeeDBFeedService
{
    public function transformData($csvFile)
    {
        $csvArray = explode("\n", $csvFile);

        $data = array_map('str_getcsv', $csvArray);

        $headers = Employee::columns;

        $lastHeader = array_pop($headers);

        $allRecords = [];

        foreach ($data as $key => $record) {
            if (is_null($record[0]) || $record[0] == '') {
                continue;
            }

            $mainValues = array_slice($record, 0, 9);

            $mainValues[1] = Carbon::createFromFormat('Y.m', $mainValues[1])->toDateString();

            $mainValues = $this->convertEmptyValuesToNull($mainValues);

            $mainRecord = array_combine($headers, $mainValues);

            $subValues = array_filter(array_slice($record, 9));

            if ($subValues) {
                $subRecords = $this->prepareSubRecords($subValues, $lastHeader);

                $mainRecord = array_merge($mainRecord, $subRecords);
            }
            array_push($allRecords, $mainRecord);
        }

        return $allRecords;
    }

    public function convertEmptyValuesToNull(array $mainValues)
    {
        $array = array_map(
            function ($value) {
                if ($value == '') {
                    return $value = null;
                }
                return $value;
            },
            $mainValues
        );

        return $array;
    }

    private function prepareSubRecords(array $subValues, $header)
    {
        $length = count($subValues);
        $subArray = [];
        for ($i = 0; $i < $length; $i++) {
            $subArray[$i] = ['series_title_'.$i => $subValues[$i]];
        }
        $subRecords = [$header => json_encode($subArray)];

        return $subRecords;
    }

    public function removeExistRecords(array $records)
    {
        $references = $this->getEmployeesReferences()->toArray();

        return array_filter($records, function ($record) use($references){
            return !in_array($record['series_reference'], $references);
        });
    }

    public function getEmployeesReferences()
    {
       return DB::table('employees')->pluck('series_reference');
    }

}
