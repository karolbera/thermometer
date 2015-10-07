<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;

class Temperature extends Eloquent
{

    protected $fillable = array('year', 'month', 'day', 'hour', 'minute', 'temp');

    public static function getAll() {

        $temperatures = \DB::collection('temperatures')->get();
        return $temperatures;

    }

    public static function all($columns = array('*'))
    {
        $result = array();

        $values = \DB::collection('temperatures')->get($columns);

//        echo '<pre>';
//        print_r($values);
//        echo '</pre>';

        foreach($values as $temp) {
            $result['temperatures'][] = (float) $temp['temp'];
            $result['time'][] = $temp['minute'];
        }
        return $result;
    }

}
