<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Config;

class CheckTempController extends Controller
{

    private $amountOfChecks;
    private $errors;

    public function __construct()
    {
        $this->amountOfChecks = Config::get('config.amountOfChecks');
        $this->errors = app('App\Console\Commands\StoreTemperatureCommand')->checkLogsForErrors();
    }

    public function tooHot()
    {
        if ($this->errors['too_hot'] >= $this->amountOfChecks
            && $this->errors['too_cool'] == 0) {
            echo 'too hot';
        } else {
            echo 'OK';
        }
    }

    public function current()
    {
        $temp = app('App\Console\Commands\StoreTemperatureCommand')->getTemperature();
        echo $temp . ' &deg;C';
    }

    public function tooCool()
    {
        if ($this->errors['too_cool'] >= $this->amountOfChecks
            && $this->errors['too_hot'] == 0) {
            echo 'too cool';
        } else {
            echo 'OK';
        }
    }

    public function thermometer()
    {
        if ($this->errors['thermometer_not_working'] >= $this->amountOfChecks
            && $this->errors['too_hot'] == 0
            && $this->errors['too_cool'] == 0) {
            echo 'can\'t access thermometer';
        } else {
            echo 'OK';
        }
    }

}
