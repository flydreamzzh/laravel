<link rel="stylesheet" href="{{ asset('vendor/plugins/fancytree/skin-win8/ui.fancytree.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/user/role.css') }}">

<div class="role-search">
    <input type="text" placeholder="查找······" autocomplete="off" id="searchMenu">
</div>
<div id="treeTable"></div>

@section('roleJS')
    //JS for menuTable
    <script type="text/javascript" src="{{ asset('vendor/plugins/fancytree/extensions/jquery.fancytree.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/plugins/fancytree/extensions/jquery.fancytree.themeroller.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/plugins/fancytree/extensions/jquery.fancytree.filter.js') }}"></script>
    <script type="text/javascript">
        $("#treeTable").fancytree({
            extensions: ["filter"],
            source: {
                url: "{{ route('authRoles.table', ['is_permission' => true]) }}"
            },
            renderNode:function(event, data) {
                if (data.node.data.id == "{{ $role->id }}") {
                    data.node.setActive(true);
                }
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
            icon: false,
        }).on("fancytreeactivate", function(event, data){
            $.get("{{ route('authPermissions.allPermissions') }}", {role_id: data.node.data.id}, function (response) {
                $("#allPermissions").html(response);
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

    </script>
@endsection
