<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreCsvFileContentsInChunks implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $fileData;
    private $empService;
    private $queueData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $fileData, array $queueData, $empService)
    {
        $this->fileData = $fileData;
        $this->queueData = $queueData;
        $this->empService = $empService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fleData = $this->fileData;

        $uploadService = $fleData['uploadService'];

        $fileName = pathinfo($fleData['originalName'], PATHINFO_FILENAME);

        $pathName = "feeders/csv/$fileName/";

        $chunkedArray = $this->convertFileToArrayChunks($fleData);

        $uploadService
            ->storeFileContentsInChunks($chunkedArray, $pathName, 'csv');

        ConvertCsvDataToDBRecords::dispatch($pathName, $this->queueData, $this->empService);
    }

    public function convertFileToArrayChunks($fileData)
    {
        $file = base64_decode($fileData['csvFile']);

        $fileArray = explode("\n", $file);

        unset($fileArray[0]);

        $fileArray = array_map(function ($row) {
            return $row.PHP_EOL;
        }, $fileArray);

        $rows = count($fileArray);

        $chunksAmount = ceil($rows / 5);

        $chunkedArray = array_chunk($fileArray, $chunksAmount);

        return $chunkedArray;
    }
}
