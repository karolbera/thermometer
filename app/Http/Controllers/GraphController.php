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
        $this->createGraph($this->public_path . "/login-hour.gif", "-1h", "Hourly temperatures");
        $this->createGraph($this->public_path . "/login-day.gif", "-1d", "Daily temperatures");
        $this->createGraph($this->public_path . "/login-week.gif", "-1w", "Weekly temperatures");
        $this->createGraph($this->public_path . "/login-month.gif", "-1m", "Monthly temperatures");

        return view('graph');
    }

    /*
     * wrapper on rrd_graph function
     */
    function createGraph($output, $start, $title)
    {
        $options = array(
            "--width=1200",
            "--slope-mode",
            "--start", $start,
            "--title=$title",
            "--vertical-label=Temperature",
            "--lower=0",
            "DEF:temp=$this->public_path/temperatures.rrd:temp:AVERAGE",
            "AREA:temp#00FF00:Temperature",
            "COMMENT:\\n",
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

}
