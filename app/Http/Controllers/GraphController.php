<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use \Illuminate\Support\Facades\Config;

class GraphController extends Controller
{
    private $public_path;

    public function __construct()
    {
        $this->public_path = public_path();
        $this->floorLvl1 = Config::get('config.floorLvl1');
        $this->ceilingLvl1 = Config::get('config.ceilingLvl1');
        $this->ceilingLvl2 = Config::get('config.ceilingLvl2');
        $this->amountOfChecks = Config::get('config.amountOfChecks');
    }

    /*
     * creates images graphs out of rrd database
     * and present them on the template
     */
    public function index()
    {
        $this->createGraph($this->public_path . "/login-hour.gif", "-1h", "Hourly temperatures", "1200");
        $this->createGraph($this->public_path . "/login-day.gif", "-1d", "Daily temperatures", "1200");
        $this->createGraph($this->public_path . "/login-week.gif", "-1w", "Weekly temperatures", "1200");
        $this->createGraph($this->public_path . "/login-month.gif", "-1m", "Monthly temperatures", "1200");

        $this->createGraph($this->public_path . "/login-hour_small.gif", "-1h", "Hourly temperatures", "250");
        $this->createGraph($this->public_path . "/login-day_small.gif", "-1d", "Daily temperatures", "250");
        $this->createGraph($this->public_path . "/login-week_small.gif", "-1w", "Weekly temperatures", "250");
        $this->createGraph($this->public_path . "/login-month_small.gif", "-1m", "Monthly temperatures", "250");

        $temp['current'] = app('App\Console\Commands\StoreTemperatureCommand')->getTemperature();

        $temp['h'] = $this->getInfo("1m", "-1h");
        $temp['d'] = $this->getInfo("1m", "-24h");
        $temp['w'] = $this->getInfo("1m", "-7d");
        $temp['m'] = $this->getInfo("1m", "-30d");

        return view('graph', array('temp' => $temp));
    }

    /*
     * wrapper on rrd_graph function
     */
    function createGraph($output, $start, $title, $width)
    {
        $options = array(
            "--width=$width",
            "--slope-mode",
            "--start", $start,
            "--title=$title",
            "--lower=0",
            "DEF:temp=$this->public_path/temperatures.rrd:temp:AVERAGE",
            "AREA:temp#FFCC00:Temperature",
            "COMMENT:\\n",
            "GPRINT:temp:MIN:Min\: %6.2lf %S",
            "GPRINT:temp:AVERAGE:Avg\: %6.2lf %S",
            "GPRINT:temp:MAX:Max\: %6.2lf %S\\n",
        );

        $ret = rrd_graph($output, $options);
        if (! $ret) {
            echo "<b>Graph error: </b>".rrd_error()."\n";
        }
    }

    /*
     * creates rrd DB
     */
    public function createRRDfile()
    {
        $options = array(
            "--step", "60",      // Use a step-size of 1 minute
            "--start", "now",     // this rrd starts now
            "DS:temp:GAUGE:120:12:32",
            "RRA:AVERAGE:0.5:1:288",
            "RRA:AVERAGE:0.5:12:168",
            "RRA:AVERAGE:0.5:228:365",
        );

        $ret = rrd_create($this->public_path . "/temperatures.rrd", $options);
        if (!$ret) {
            echo "<b>Creation error: </b>" . rrd_error() . "\n";
        }
    }


    public function getInfo($resolution = "1m", $time = "-1h")
    {
        // Consider now that you want to fetch the 15 minute average data for the last hour. You might try
        // rrdtool fetch subdata.rrd AVERAGE -r 15m -s -1h

        $result = rrd_fetch( $this->public_path . "/temperatures.rrd",
                            array( "AVERAGE", "-r", $resolution, "-s", $time) );

//        echo '<hr/><pre>';
//        print_r($result);
//        echo '</pre><hr/>';

        array_pop($result['data']['temp']);
        $result['data']['temp'] = $this->array_delete($result['data']['temp'], "NAN");
//        print_r($result['data']['temp']);
//        print_r($result['data']['temp']);


        if(!empty($result['data']['temp'])) {
            $result = array(
                'min' => round( min($result['data']['temp']), 2),
                'avg' => round( array_sum($result['data']['temp']) / count($result['data']['temp']), 2),
                'max' => round( max($result['data']['temp']), 2),
            );
        } else {
            $result = array();
        }

        return $result;
    }

    function array_delete($array, $element)
    {
        return array_diff($array, [$element]);
    }

}
