<?php

namespace App\Events;

use App\Services\Employee\EmployeeDBFeedService;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CsvDataSeederUploaded
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $fileData;
    public $queueData;
    public $empService;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        array $fileData,
        array $queueData,
        EmployeeDBFeedService $empService
    ) {
        $this->empService = $empService;
        $this->fileData = $fileData;
        $this->queueData = $queueData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
