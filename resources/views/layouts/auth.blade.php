<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.css')}}">
    <title>Document</title>
</head>

<body class="bg-white">
    @csrf
    <div class="flex content-center flex-wrap  justify-center h-screen ">
        <div class="flex content-center justify-center flex-wrap  border rounded-lg" style="width:540px;height:650px">
            <div class="w-full mx-2">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>