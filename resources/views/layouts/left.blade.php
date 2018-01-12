<?php
use App\Models\Menu;
$menus = (new \App\Models\Menu())->tree_list();
?>
<!-- sidebar menu -->
<ul class="nav sidebar-menu">

    <?php /** @var Menu $menu */ ?>
    @foreach($menus as $menu)
        @if($menu->type)
            <li class="sidebar-label pt20">{{ $menu->name }}</li>
        @else
            @if(! $menu->tree_children)
                <li>
                    <a href="{{ $menu->url }}">
                        <span class="{{ $menu->icon }}"></span>
                        <span class="sidebar-title">{{ $menu->name }}</span>
                    </a>
                </li>
            @else
                <li>
                    <a class="accordion-toggle" href="#">
                        <span class="{{ $menu->icon }}"></span>
                        <span class="sidebar-title">{{ $menu->name }}</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav">
                        @foreach($menu->tree_children as $children)
                            @if(! $children->tree_children)
                                <li>
                                    <a href="{{ $children->url }}">
                                        <span class="{{ $children->icon }}"></span> {{ $children->name }}
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="accordion-toggle" href="#">
                                        <span class="{{ $children->icon }}"></span> {{ $children->name }}
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="nav sub-nav">
                                        @foreach($children->tree_children as $child)
                                            <li>
                                                <a href="{{ $child->url }}"><span class="{{ $child->icon }}"></span> {{ $child->name }}</a>
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