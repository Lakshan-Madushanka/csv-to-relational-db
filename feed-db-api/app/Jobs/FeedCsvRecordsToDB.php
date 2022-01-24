<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class FeedCsvRecordsToDB implements ShouldQueue
{
    use Dispatchable;
    use Batchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $tries = 3;

    private $records;
    private $pathName;
    private $empService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $records)
    {
        $this->records = $records;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::transaction(function (){
            DB::table('employees')->insert($this->records);
        });
    }

    public function onQueue()
    {
        return 'csv_feeder';
    }
}
