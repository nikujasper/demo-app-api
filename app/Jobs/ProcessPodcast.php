<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\Api\InspectionController; //import the controller
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;


class ProcessPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $data;
    public function __construct($req)
    {
        $this->data = $req;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $inspectionController = new InspectionController();
        $inspectionController->test($this->data);
    }

    // public function failed(Exception $e)
    // {
    //     Log::channel('customlog')->info($e);
    // }
}
