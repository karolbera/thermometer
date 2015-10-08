<?php

namespace App\Http\Controllers;

use App\Temperature;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

#jPgraph
use Graph;
Use UniversalTheme;
use LinePlot;

class displayGraph extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        /*
        $data = Temperature::all(['temp', 'hour', 'minute']);
        $datay1 = $data['temperatures'];

        // Setup the graph
        $graph = new Graph(1600, 1200);
        $graph->SetScale("textlin");

        $theme_class=new UniversalTheme;

        $graph->SetTheme($theme_class);
        $graph->img->SetAntiAliasing(false);
        $graph->title->Set('Temperatures');
        $graph->SetBox(false);

        $graph->img->SetAntiAliasing();

        $graph->yaxis->HideZeroLabel();
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false,false);

        $graph->xgrid->Show();
        $graph->xgrid->SetLineStyle("solid");
        $graph->xaxis->SetTickLabels($data['time']);
        $graph->xgrid->SetColor('#E3E3E3');

        // Create the first line
        $p1 = new LinePlot($datay1);
        $graph->Add($p1);
        $p1->SetColor("#6495ED");
        $p1->SetLegend('Line 1');

        $graph->legend->SetFrameWeight(1);

        // Output line
        $graph->Stroke();
        */

        $storage = public_path();
        /*
         * creates rrd DB
         */
//        $options = array(
//            "--step", "60",      // Use a step-size of 1 minute
//            "--start", "now",     // this rrd starts now
//            "DS:temp:GAUGE:120:12:32",
//            "RRA:AVERAGE:0.5:1:288",
//            "RRA:AVERAGE:0.5:12:168",
//            "RRA:AVERAGE:0.5:228:365",
//        );
//
//        $ret = rrd_create( $storage . "/temperatures.rrd", $options);
//        if (! $ret) {
//            echo "<b>Creation error: </b>".rrd_error()."\n";
//        }


        /*
         * updates rrd with data
         */
//        $now = time();

        // Simulate last 180 days of login, with a step of 5 minutes
//        for ($t = $now - (3600 * 24 * 180); $t <= $now; $t += 300)
//        {
//            $temp = rand(12, 32);
//            $ret = rrd_update($storage . "/temperatures.rrd", array("$t:$temp"));
//        }

//        array(
//            "920804700:12345",
//            "920805000:12357"
//        )



        /*
         * graphing
         */
        $this->create_graph($storage . "/login-hour.gif", "-1h", "Hourly temperatures");
        $this->create_graph($storage . "/login-day.gif", "-1d", "Daily temperatures");
        $this->create_graph($storage . "/login-week.gif", "-1w", "Weekly temperatures");
        $this->create_graph($storage . "/login-month.gif", "-1m", "Monthly temperatures");
//        $this->create_graph($storage . "/login-year.gif", "-1y", "Yearly temperatures");

        $path = app_path();

        return view('graph', ['storage' => $storage]);

    }

    function create_graph($output, $start, $title)
    {

        $storage = public_path();

        $options = array(
            "--width=1200",
            "--slope-mode",
            "--start", $start,
            "--title=$title",
            "--vertical-label=Temperature",
            "--lower=0",
            "DEF:temp=$storage/temperatures.rrd:temp:AVERAGE",
            "AREA:temp#00FF00:Temperature",
            "COMMENT:\\n",
        );

        $ret = rrd_graph($output, $options);
        if (! $ret) {
            echo "<b>Graph error: </b>".rrd_error()."\n";
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sendSMS()
    {
        // root@10.2.1.214
        // echo "Test SMS alert" | gammu sendsms text +48660451682
    }

}
