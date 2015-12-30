<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Illuminate\Support\Facades\Config;
use \Log;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\App;

class StoreTemperatureCommand extends Command
{
    const TOO_HIGH = 'too hot';
    const TOO_LOW = 'too cool';
    const READ_ERROR = 'cannot read thermometer data';
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
        $this->public_path = public_path();
        $this->floorLvl1 = Config::get('config.floorLvl1');
        $this->ceilingLvl1 = Config::get('config.ceilingLvl1');
        $this->ceilingLvl2 = Config::get('config.ceilingLvl2');
        $this->amountOfChecks = Config::get('config.amountOfChecks');
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

            $temp = $this->getTemperature();
            if( !is_numeric($temp) ) {
                $monolog->critical(self::READ_ERROR);
                $message = 'Cannot read temperature. Is USB thermometer OK?';
            } else {
                $temp = round((float)$this->getTemperature(), 2);
                rrd_update($storage . "/temperatures.rrd", array("$now:$temp"));
                $message = 'Temperature ' . $temp . ' stored at ' . date("d-m-Y H:i");
            }

            $this->writeToLogs($temp, $monolog);
            $this->checkLogsForErrors();

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

    /**
     * @param $temp
     * @param $monolog
     */
    public function writeToLogs($temp, $monolog)
    {
        if(is_numeric($temp)) {
            $this->writeTempToLogs($temp, $monolog);
            return true;
        } else {
            return false;
        }

    }

    /**
     * @return string
     */
    public function getTemperature()
    {

        if($_ENV['APP_MOCK']) {
            $temp = rand(22, 23);
            $temp = $temp . "." . rand(1, 100);
            $temp = (float)$temp;
        } else {
            $temp = exec('cat /var/run/papouch-tmu/temperature');
        }

        return $temp;
    }

    public function checkLogsForErrors()
    {
        $errors = array();
        $errors['counter'] = 0;
        $errors['too_hot'] = 0;
        $errors['too_cool'] = 0;
        $errors['thermometer_not_working'] = 0;

        foreach ($this->readLastLogLines($this->amountOfChecks) as $line) {
            if (strpos($line, self::OK) === FALSE) {
                $errors['counter']++;
            }
            if (strpos($line, self::TOO_HIGH) !== FALSE) {
                $errors['too_hot']++;
            }
            if (strpos($line, self::TOO_LOW) !== FALSE) {
                $errors['too_cool']++;
            }
            if (strpos($line, self::READ_ERROR) !== FALSE) {
                $errors['thermometer_not_working']++;
            }
        }

        if ($errors['counter'] >= $this->amountOfChecks
            && $errors['too_hot'] >= $this->amountOfChecks) {
            /** todo
             * implement sending sms
             */
            Log::info('Sending SMS - too hot');
        }
        if ($errors['counter'] >= $this->amountOfChecks
            && $errors['too_cool'] >= $this->amountOfChecks) {
            /** todo
             * implement sending sms
             */
            Log::info('Sending SMS - too cool');
        }
        if ($errors['counter'] >= $this->amountOfChecks
            && $errors['thermometer_not_working'] >= $this->amountOfChecks) {
            /** todo
             * implement sending sms
             */
            Log::info('Sending SMS - thermometer error');
        }

        return $errors;
    }

    /**
     * @param $temp
     * @param $monolog
     */
    public function writeTempToLogs($temp, $monolog)
    {
        if ($temp > Config::get('config.ceilingLvl2')) { // >25
            $monolog->critical(self::TOO_HIGH);
        } elseif ($temp > Config::get('config.ceilingLvl2')) { // >25
            $monolog->critical(self::TOO_HIGH);
        } elseif ($temp > Config::get('config.ceilingLvl1')) { // >22
            $monolog->warning(self::TOO_HIGH);
        } elseif ($temp < Config::get('config.floorLvl1')) { // <16
            $monolog->warning(self::TOO_LOW);
        } else {
            $monolog->notice(self::OK);
        }
    }
}
