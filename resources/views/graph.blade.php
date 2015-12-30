<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="10" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel</title>

    <link rel="stylesheet" href="{!! URL::asset('css/style.css'); !!}">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,900" rel="stylesheet" type="text/css">

    <style>


    </style>
</head>
<body>
<div class="container">
    <div class="content">

        <h1>{!! $temp['current'] !!} &deg;C</h1>

        {{--<h2>Hourly</h2>--}}
        {{--<p>--}}
            {{--Min: {!! $temp['h']['min'] !!} &deg;C <br/>--}}
            {{--Max: {!! $temp['h']['max'] !!} &deg;C <br/>--}}
            {{--Avg: {!! $temp['h']['avg'] !!} &deg;C--}}
        {{--</p>--}}

        {{--<h2>Daily</h2>--}}
        {{--<p>--}}
            {{--Min: {!! $temp['d']['min'] !!} &deg;C <br/>--}}
            {{--Max: {!! $temp['d']['max'] !!} &deg;C <br/>--}}
            {{--Avg: {!! $temp['d']['avg'] !!} &deg;C--}}
        {{--</p>--}}

        {{--<h2>Weekly</h2>--}}
        {{--<p>--}}
            {{--Min: {!! $temp['w']['min'] !!} &deg;C <br/>--}}
            {{--Max: {!! $temp['w']['max'] !!} &deg;C <br/>--}}
            {{--Avg: {!! $temp['w']['avg'] !!} &deg;C--}}
        {{--</p>--}}

        {{--<h2>Monthly</h2>--}}
        {{--<p>--}}
            {{--Min: {!! $temp['m']['min'] !!} &deg;C <br/>--}}
            {{--Max: {!! $temp['m']['max'] !!} &deg;C <br/>--}}
            {{--Avg: {!! $temp['m']['avg'] !!} &deg;C--}}
        {{--</p>--}}


        {{--<h2>Daily average {!! $temp['avgDay'] !!} &deg;C</h2>--}}
        {{--<h2>Weekly average {!! $temp['avgWeek'] !!} &deg;C</h2>--}}
        {{--<h2>Monthly average {!! $temp['avgMonth'] !!} &deg;C</h2>--}}

        <div class="desktop">
            <div class="temperature">
                {!! HTML::image('login-hour.gif', 'a picture') !!} <br/>
            </div>

            <div class="temperature">
                {!! HTML::image('login-day.gif', 'a picture') !!} <br/>
            </div>

            <div class="temperature">
                {!! HTML::image('login-week.gif', 'a picture') !!}<br/>
            </div>

            <div class="temperature">
                {!! HTML::image('login-month.gif', 'a picture') !!}<br/>
                {{--{!! HTML::image('login-year.gif', 'a picture') !!}<br/>--}}
            </div>
        </div>


        <div class="mobile">
            <div class="temperature">
                {!! HTML::image('login-hour_small.gif', 'a picture') !!} <br/>
            </div>

            <div class="temperature">
                {!! HTML::image('login-day_small.gif', 'a picture') !!} <br/>
            </div>

            <div class="temperature">
                {!! HTML::image('login-week_small.gif', 'a picture') !!}<br/>
            </div>

            <div class="temperature">
                {!! HTML::image('login-month_small.gif', 'a picture') !!}<br/>
                {{--{!! HTML::image('login-year.gif', 'a picture') !!}<br/>--}}
            </div>
        </div>

    </div>
</div>
</body>
</html>
