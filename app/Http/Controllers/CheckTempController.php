<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CheckTempController extends Controller
{

    private $errors;

    public function __construct()
    {
        $this->errors = app('App\Console\Commands\StoreTemperatureCommand')->checkLogsForErrors();
    }

    public function tooHot()
    {
        if ($this->errors['too_hot'] >= 5
            && $this->errors['too_cool'] == 0) {
            echo 'too hot';
        } else {
            echo 'OK';
        }
    }

    public function tooCool()
    {
        if ($this->errors['too_cool'] >= 5
            && $this->errors['too_hot'] == 0) {
            echo 'too cool';
        } else {
            echo 'OK';
        }
    }

    public function thermometer()
    {
        if ($this->errors['thermometer_not_working'] >= 5
            && $this->errors['too_hot'] == 0
            && $this->errors['too_cool'] == 0) {
            echo 'can\'t access thermometer';
        } else {
            echo 'OK';
        }
    }

}
