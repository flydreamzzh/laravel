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
    <link href="{{ asset('layui/css/layui.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login/style.css') }}" rel="stylesheet">
</head>
<body>

<div id="particles">
    <div id="app">
        <div class="login row">
            <div class="login-head">
            <strong>账号登录</strong>
            </div>
            <div class="login-form">
                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="input-icon">
                        <span class="glyphicon glyphicon-user"></span>
                        <div>
                            <input id="email" type="email"  placeholder="邮箱/手机号" name="email" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>
                    <div class="input-icon">
                        <span class="glyphicon glyphicon-lock"></span>
                        <div>
                            <input id="password" type="password"  placeholder="请输入密码" name="password" required>
                        </div>
                    </div>
                    <div class="checkbox" style="margin-top: -10px">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 记住我
                        </label>
                        <a class="pull-right" href="{{ route('password.request') }}">
                            忘记密码
                        </a>
                    </div>
                    <div class="form-button">
                        <input type="submit" class="btn btn-sm btn-danger" value="登录">
                    </div>
                </form>
            </div>
        </div>
        <div class="bg-gray"></div>
    </div>
</div>
    <script type='text/javascript' src= {{asset('js/app.js')}} ></script>
    <script type='text/javascript' src= {{asset('js/login/jquery.particleground.min.js')}} ></script>
    <script type='text/javascript' src= {{asset('layui/layui.js')}} ></script>
    <script type='text/javascript' src= {{asset('js/login/login.js')}} ></script>
<script>
    layui.use(['layer'], function(){
        var layer = layui.layer
            ,form = layui.form;
        @if ($errors->has('email'))
        layer.tips("{{ $errors->first('email') }}", '#email', {
            tips: [3, '#3595CC'],
            time: 4000
        });
        @endif

        @if ($errors->has('password'))
        layer.tips("{{ $errors->first('password') }}", '#password', {
            tips: [3, '#78BA32'],
            time: 4000
        });
        @endif
    });
</script>
</body>
</html>
