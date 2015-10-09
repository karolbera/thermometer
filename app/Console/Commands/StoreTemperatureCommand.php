<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Illuminate\Support\Facades\Config;
use \Log;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class StoreTemperatureCommand extends Command
{
    const TOO_HIGH = 'too high';
    const TOO_LOW = 'too low';
    const OK = 'ok';

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

        $monolog = new Logger('log');
        $monolog->pushHandler(new StreamHandler(storage_path('logs/temperatures.log')), Logger::WARNING);

        try{
            $storage = public_path();
            $now = time();
            $temp = round((float)exec('cat /var/run/papouch-tmu/temperature'), 2);
            rrd_update($storage . "/temperatures.rrd", array("$now:$temp"));

            if($temp > Config::get('config.ceilingLvl2')) { // >25
                $monolog->critical(self::TOO_HIGH);
            } elseif ($temp > Config::get('config.ceilingLvl1')) { // >22
                $monolog->warning(self::TOO_HIGH);
            } elseif ($temp < Config::get('config.floorLvl1')) { // <16
                $monolog->warning(self::TOO_LOW);
            } else {
                $monolog->notice(self::OK);
            }

            $errorsCounter = 0;
            foreach($this->readLastLogLines(5) as $line) {
                if(strpos($line, self::OK) === FALSE) {
                    $errorsCounter++;
                }
            }

            if($errorsCounter >= 5) {
                Log::info('Sending SMS');
            }

            $message = 'Temperature ' . $temp . ' stored at ' . date("d-m-Y H:i");
            $this->comment($message);
        }
        catch(Exception $e){
            $this->comment($e->getMessage());
        }
    }

    public function readLastLogLines($numberOfLines)
    {
        exec("tail -$numberOfLines " . storage_path('logs/temperatures.log'), $lines);
        return $lines;
    }
}
