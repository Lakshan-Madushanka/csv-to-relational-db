<?php

namespace App\Http\Controllers\Api\DBFeed;

use App\Events\CsvDataSeederUploaded;
use App\Http\Controllers\Controller;
use App\Services\Employee\EmployeeDBFeedService;
use App\Services\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CsvFeederController extends Controller
{
    private $uploadServce;
    private $empService;
    private $batch;

    public function __construct(
        FileUpload $uploadServce,
        EmployeeDBFeedService $empService
    ) {
        $this->empService = $empService;
        $this->uploadServce = $uploadServce;
        $this->batch = Bus::batch([]);
    }

    public function insert(Request $request)
    {
        $inputs = $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $file = $request->file;

        $queueName = uniqid();

       Event::dispatch(new CsvDataSeederUploaded(
            [
                'csvFile'       => $file->get(),
                'uploadService' => $this->uploadServce,
                'originalName'  => $file->getClientOriginalName(),
                'disk'          => 'public',
            ],
            [
                'queue' => 'default',
                'queueName' => $queueName,
            ],
            $this->empService,
        ));

        return response()->json(['id' => $queueName]);
    }

    public function getProgressDetails(Request $request)
    {
        $request->validate(['key' => 'string']);

        $details = [];

        $tempDetails = DB::table('job_batches')
            ->where('name', $request->key)
            ->first();

        if ($tempDetails) {
            $details = Bus::findBatch($tempDetails->id);
        }

        return response()->json($details);
    }
}
