<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ config('app_name') }}</title>
    </head>
    <body>
        <p>به منظور بازیابی کلمه عبور خود از لینک زیر استفاده کنید</p>

        <div>
            <a target="_blank" href="{{route('password.reset.token',['token'=>($token)])}}">بازیابی کلمه عبور (کلیک کنید)</a>
        </div>
        {{ config('app_name') }}
    </body>
</html>