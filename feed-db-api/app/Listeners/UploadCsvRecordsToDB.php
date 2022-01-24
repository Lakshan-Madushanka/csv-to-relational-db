<?php

namespace App\Listeners;

use App\Jobs\StoreCsvFileContentsInChunks;

class UploadCsvRecordsToDB
{
    private $batch;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     *
     * @return void
     */
    public function handle($event)
    {
        $fileData = $event->fileData;

        $file = base64_encode($event->fileData['csvFile']);

        $fileData['csvFile'] = $file;

        StoreCsvFileContentsInChunks::dispatch($fileData, $event->queueData, $event->empService);
    }
}
