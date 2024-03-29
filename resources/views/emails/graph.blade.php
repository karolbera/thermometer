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

        <img src="{{ $message->embed(public_path() . '/login-day.gif') }}" /> <br/>
        <img src="{{ $message->embed(public_path() . '/login-week.gif') }}" /> <br/>

    </div>
</div>
</body>
</html>
