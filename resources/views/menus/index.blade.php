@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('vendor/plugins/fancytree/skin-win8/ui.fancytree.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menu/menu.css') }}">
    <div class="menu">
        <div class="menu-toolbar">
            <div class="menu-search pull-left">
                <input type="text" placeholder="查找······" autocomplete="off" id="searchMenu">
            </div>
            <div class="menu-func pull-right">
                <button class="btn btn-sm btn-dark" onclick="addMenu()"><i class="fa fa-plus"></i> 新增</button>
            </div>
        </div>
        <table id="treeTable">
            <colgroup>
                <col width="250px">
                <col width="200px">
                <col>
                <col width="60px">
            </colgroup>
            <thead>
                <tr>
                    <th>名称</th>
                    <th>路由</th>
                    <th>描述</th>
                    <th style="text-align: center;">功能</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center"></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
@section('js')
    //JS for menuTable
    <script type="text/javascript" src="{{ asset('vendor/plugins/fancytree/extensions/jquery.fancytree.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/plugins/fancytree/extensions/jquery.fancytree.table.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/plugins/fancytree/extensions/jquery.fancytree.themeroller.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/plugins/fancytree/extensions/jquery.fancytree.filter.js') }}"></script>
    <script type="text/javascript">
        $("#treeTable").fancytree({
            extensions: ["table", "filter"],
//            checkbox: true,
            source: {
                url: "{{ route('menus.table') }}"
            },
            activate: function(event, data) {
            },
            filter: {
                autoApply: true,   // Re-apply last filter if lazy data is loaded
                autoExpand: false, // Expand all branches that contain matches while filtered
                counter: false,     // Show a badge with number of matching child nodes near parent icons
                fuzzy: false,      // Match single characters in order, e.g. 'fb' will match 'FooBar'
                hideExpandedCounter: true,  // Hide counter badge if parent is expanded
                hideExpanders: false,       // Hide expanders if all child nodes are hidden by filter
                highlight: true,   // Highlight matches by wrapping inside <mark> tags
                leavesOnly: true, // Match end nodes only
                nodata: false,      // Display a 'no data' status node if result is empty
                mode: "hide"       // Grayout unmatched nodes (pass "hide" to remove unmatched node instead)
            },
            renderColumns: function(event, data) {
                var node = data.node, $tdList = $(node.tr).find(">td");
                node.expanded = true;
                $tdList.eq(1).text(node.data.url);
                $tdList.eq(2).text(node.data.description ? node.data.description : '');
                $tdList.eq(3).html('<a href="javascript:void(0)" class="updateMenu"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;' +
                    '<a href="javascript:void(0)" class="deleteMenu"><i class="glyphicons glyphicons-bin"></i></a>');
            }
        });

        $("#treeTable").delegate(".updateMenu", "click", function(e){
            var node = $.ui.fancytree.getNode(e),
                $input = $(e.target);
            e.stopPropagation();  // prevent fancytree activate for this row
            $.get(node.data.edit_url, function (response) {
                layui.use(['layer'], function () {
                    layer.open({
                        type: 1,
                        title: node.data.name,
                        area: ['700px', 'auto'],
                        maxmin: true,
                        content: response
                    });
                })

            })
        }).delegate(".deleteMenu", "click", function(e){
            var node = $.ui.fancytree.getNode(e),
                $input = $(e.target);
            e.stopPropagation();  // prevent fancytree activate for this row
            layui.use(['layer'], function () {
                layer.confirm('确定移除此菜单？', {
                    btn: ['确定', '取消'], //可以无限个按钮
                    yes: function(index, layero){
                        $.post(node.data.delete_url, {_method: 'delete'}, function (response) {
                            if (response.success) {
                                layer.msg(response.message, {icon: 1});
                            } else {
                                layer.msg(response.message, {icon: 2});
                            }
                            $("#treeTable").fancytree("getTree").reload({url: "{{ route('menus.table') }}"});
                        }).fail(function (response) {
                            var message = response.responseJSON.message;
                            layer.msg(message, {icon: 5});
                            $("#treeTable").fancytree("getTree").reload({url: "{{ route('menus.table') }}"});
                        });
                        return false;
                    }
                });
            })
        });
        
        $("#searchMenu").keyup(function (e) {
            var match = $(this).val(), tree = $.ui.fancytree.getTree(),filterFunc = tree.filterNodes;

            if(e && e.which === $.ui.keyCode.ESCAPE || $.trim(match) === ""){
                tree.clearFilter();
                return;
            }
            filterFunc.call(tree, match, {})
        }).focus()
        
        function addMenu() {
            $.get("{{ route('menus.create') }}", function (response) {
                layui.use(['layer'], function () {
                    layer.open({
                        type: 1,
                        title: '新增菜单',
                        zIndex: 1200,
                        area: ['700px', 'auto'],
                        maxmin: true,
                        content: response
                    });
                })
            })
        }
        

    </script>
@endsection
