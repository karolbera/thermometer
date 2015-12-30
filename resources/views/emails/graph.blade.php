<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="10" >
    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            margin-top: 20px;
            text-align: center;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 26px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">

        {{--<h2>current: <b>{{ $temp }} &deg;C </b></h2>--}}
        {{--{!! HTML::image('login-hour.gif', 'a picture') !!} <br/>--}}
        {!! HTML::image('login-day.gif', 'a picture') !!} <br/>
        {!! HTML::image('login-week.gif', 'a picture') !!} <br/>
        {{--{!! HTML::image('login-month.gif', 'a picture') !!}<br/>--}}
        {{--{!! HTML::image('login-year.gif', 'a picture') !!}<br/>--}}

    </div>
</div>
</body>
</html>
