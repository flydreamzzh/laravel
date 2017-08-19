<head>
    <link rel="stylesheet" href="css/navbar/normalize.css">
    <link rel="stylesheet" href="css/navbar/component.css">
    <link rel="stylesheet" href="css/navbar/navbar.css">
    <script src="js/navbar/modernizr.custom.js"></script>
</head>

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
                    <li><a  href="menus" class="gn-icon gn-icon-cog">节点管理</a></li>
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

    @if (Auth::guest())
    <li class="pull-right"><a href="{{ route('login') }}">Login</a></li>
    <li class="pull-right"><a href="{{ route('register') }}">Register</a></li>
    @else
    <li class="pull-right dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            {{ Auth::user()->name }} <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </li>
    @endif
</ul>
<script src="js/navbar/classie.js"></script>
<script src="js/navbar/gnmenu.js"></script>
<script>
    new gnMenu( document.getElementById( 'gn-menu' ) );
</script>