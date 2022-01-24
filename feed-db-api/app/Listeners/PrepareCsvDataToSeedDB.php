<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Storage;

class PrepareCsvDataToSeedDB
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */

    public function handle($event)
    {
        //$csvData = Storage::get($event->csvData);
        //Storage::put('private/uploads/db_feeder/csv', $csvData, 'temp');
    }
}
