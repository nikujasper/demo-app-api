<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\RabbitMQController;

class RedisGet extends Command
{
    protected $signature = 'redis:get{key}';
    protected $description = 'Get data from Redis';


    public function handle()
    {

        $key = $this->argument('key');
        $data = Redis::get($key);

        $this->info("Data for key '{$key}': {$data}");
    }
}
