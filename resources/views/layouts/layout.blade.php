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
    <link rel="stylesheet" href="css/navbar/normalize.css">
    <link rel="stylesheet" href="css/navbar/component.css">
    <link rel="stylesheet" href="css/navbar/navbar.css">
    <script src="js/navbar/modernizr.custom.js"></script>
</head>
<body>
<!-- 左菜单栏 -->
<ul id="gn-menu" class="gn-menu-main">
    <li class="gn-trigger">
        <a class="gn-icon gn-icon-menu"><span>Menu</span></a>
        <nav class="gn-menu-wrapper">
            <div class="gn-scroller">
                <ul class="gn-menu">
                    <li class="gn-search-item">
                        <input placeholder="Search" type="search" class="gn-search">
                        <a class="gn-icon gn-icon-search"><span>Search</span></a>
                    </li>
                    <li>
                        <a class="gn-icon gn-icon-download">Downloads</a>
                        <ul class="gn-submenu">
                            <li><a class="gn-icon gn-icon-illustrator">Vector Illustrations</a></li>
                            <li><a class="gn-icon gn-icon-photoshop">Photoshop files</a></li>
                        </ul>
                    </li>
                    <li><a class="gn-icon gn-icon-cog">Settings</a></li>
                    <li><a class="gn-icon gn-icon-help">Help</a></li>
                    <li>
                        <a class="gn-icon gn-icon-archive">Archives</a>
                        <ul class="gn-submenu">
                            <li><a class="gn-icon gn-icon-article">Articles</a></li>
                            <li><a class="gn-icon gn-icon-pictures">Images</a></li>
                            <li><a class="gn-icon gn-icon-videos">Videos</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /gn-scroller -->
        </nav>
    </li>
    <li><a>主页</a></li>
    <li><a>更多</a></li>
    <li class="pull-right"><a class="glyphicon glyphicon-user" href="aa.com"></a></li>
</ul>

<!-- 内容信息 -->
<div class="content" id="app">
    @yield('content')
</div>


<script src="{{ mix('js/app.js') }}"></script>
<script src="js/navbar/classie.js"></script>
<script src="js/navbar/gnmenu.js"></script>
<script>
    new gnMenu( document.getElementById( 'gn-menu' ) );
</script>
</body>
</html>