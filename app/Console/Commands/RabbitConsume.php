<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\RabbitMQController;

class RabbitConsume extends Command
{
    protected $signature = 'rabbit:consume';
    protected $description = 'Get data from Redis';


    public function handle()
    {
        $a = new RabbitMQController();
        $a->consumeMessage();
    }
}
