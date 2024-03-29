<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class GetTemperatureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temperature:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        if($_ENV['APP_MOCK'] == "true") {
            $temperature = rand(22, 23);
        } else {
            $temperature = exec('cat /var/run/papouch-tmu/temperature');
            $temperature = round($temperature, 2);
        }
        $this->comment($temperature);
    }
}
