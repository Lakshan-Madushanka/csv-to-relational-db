<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

class ConvertCsvDataToDBRecords implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 3;

    private $records;
    private $pathName;
    private $queueData;
    private $empService;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct(string $pathName, array $queueData, $empService)
    {
        $this->empService = $empService;
        $this->pathName = $pathName;
        $this->queueData = $queueData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $queueName = $this->queueData['queueName'];
        $queue = $this->queueData['queue'];

        $bus = Bus::batch([])->name($queueName)->dispatch();

        $chunkPaths = Storage::disk('public')->files($this->pathName);

        foreach ($chunkPaths as $chunkPath) {
            $chunkData = Storage::disk('public')->get($chunkPath);

            $data = $this->empService->transformData($chunkData);

            $data = $this->empService->removeExistRecords($data);

            $bus->add(new FeedCsvRecordsToDB($data));
        }
    }
}
