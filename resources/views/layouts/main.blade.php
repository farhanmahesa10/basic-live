<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.css')}}">
    <style>
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity .5s ease;
    }

    .fade-enter-from,
    .fade-leave-to {
        opacity: 0;
    }
    </style>
    <title>Documents</title>
</head>

<body class="bg-white">
    <div id="app">
        <!-- <navbar-component></navbar-component> -->
        <!-- <main-component></main-component> -->
        <router-view></router-view>
    </div>
</body>
<script src="{{asset('/js/app.js')}}"></script>

</html>