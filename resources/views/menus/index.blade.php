@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('vendor/plugins/fancytree/skin-win8/ui.fancytree.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menu/menu.css') }}">
    <div class="menu">
        <table id="treeTable">
            <thead>
                <tr>
                    <th>名称</th>
                    <th>路由</th>
                    <th>描述</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection
@section('js')
    //JS for menuTable
    <script type="text/javascript" src="{{ asset('vendor/plugins/fancytree/extensions/jquery.fancytree.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/plugins/fancytree/extensions/jquery.fancytree.table.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/plugins/fancytree/extensions/jquery.fancytree.themeroller.js') }}"></script>
    <script type="text/javascript">
        $("#treeTable").fancytree({
            extensions: ["table"],
            checkbox: true,
            source: {
                url: "{{ route('menus.table') }}"
            },
            activate: function(event, data) {
            },
            renderColumns: function(event, data) {
                var node = data.node, $tdList = $(node.tr).find(">td");
                node.expanded = true;
                $tdList.eq(1).text(node.data.url);
                $tdList.eq(2).text(node.data.description ? node.data.description : '');
            }
        });
    </script>
@endsection
