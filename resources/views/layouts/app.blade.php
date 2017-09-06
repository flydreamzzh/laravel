<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('layui/css/layui.css') }}"  media="all">

</head>
<body>
<!-- 左菜单栏 -->
@include('layouts.navbar')

<!-- 内容信息 -->
<div class="content" id="app">
    @yield('content')
</div>
<footer>
    © 2017 layui.com MIT license
</footer>
@yield('js')

<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>