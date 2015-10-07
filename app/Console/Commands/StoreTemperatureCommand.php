<?php

namespace App\Console\Commands;

use App\Temperature;
use Illuminate\Console\Command;

class StoreTemperatureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temperature:store';

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
        try{
            $temperatureValue = exec('cat /var/run/papouch-tmu/temperature');
            $temperature = new Temperature();
            $temperature->create( array(
                    'year' => date("Y"),
                    'month' => date("m"),
                    'day' => date("d"),
                    'hour' => date("H"),
                    'minute' => date("i"),
                    'temp' => round($temperatureValue, 2)
            ));
            $this->comment('Temperature ' . $temperatureValue . ' stored at ' . date("d-m-Y H:i"));
        }
        catch(Exception $e){
            $this->comment($e->getMessage());
        }
    }
}
