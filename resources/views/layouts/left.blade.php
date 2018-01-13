<?php
use App\Models\Menu;
$menus = (new \App\Models\Menu())->tree_list();
$currentRoute = Route::current()->getName();
$menuUl = [];
?>
<!-- sidebar menu -->
<ul class="nav sidebar-menu">

    <?php /** @var Menu $menu */ ?>
    @foreach($menus as $menu)
        @if($menu->type)
            <li class="sidebar-label pt20">{{ $menu->name }}</li>
        @else
            @if(! $menu->tree_children)
                <li class="{{ $currentRoute == $menu->url ? 'active' : '' }}">
                    <a href="{{ route($menu->url) }}">
                        <span class="{{ $menu->icon }}"></span>
                        <span class="sidebar-title">{{ $menu->name }}</span>
                    </a>
                </li>
            @else
                <li>
                    <a class="accordion-toggle" href="#" id="{{ $menu->id }}">
                        <span class="{{ $menu->icon }}"></span>
                        <span class="sidebar-title">{{ $menu->name }}</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav">
                        @foreach($menu->tree_children as $children)
                            @if(! $children->tree_children)
                                <li class="{{ $currentRoute == $children->url ? 'active' : '' }}">
                                    @php($currentRoute == $children->url ? $menuUl[] = $menu->id : '')
                                    <a href="{{ route($children->url) }}">
                                        <span class="{{ $children->icon }}"></span> {{ $children->name }}
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="accordion-toggle" href="#" id="{{ $children->id }}">
                                        <span class="{{ $children->icon }}"></span> {{ $children->name }}
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="nav sub-nav">
                                        @foreach($children->tree_children as $child)
                                            <li class="{{ $currentRoute == $child->url ? 'active' : '' }}">
                                                @php($currentRoute == $child->url ? $menuUl[] = $children->id : '')
                                                <a href="{{ route($child->url) }}"><span class="{{ $child->icon }}"></span> {{ $child->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endif
        @endif
    @endforeach

</ul>
<script type="text/javascript">
    @foreach($menuUl as $id)
        $("#{{ $id }}").addClass('menu-open');
    @endforeach
</script>