<div class="layui-card-header p6">
    <div class="pull-left" style="height: auto;width: 200px">
    <input type="text" name="title" lay-verify="title" autocomplete="off" style="height: 30px" placeholder="请输入标题" class="layui-input">
    </div>
    <button class="pull-right btn btn-sm btn-dark" onclick="addPermission()"><i class="fa fa-plus"></i> 新增</button>
</div>
<table class="layui-hide" id="permissions" lay-filter="permissions"></table>
<div class="pl5" id="permission_btns" style="position:absolute; bottom: 0;width: 100%;height: 40px;">
    <input type="button" disabled class="btn btn-sm btn-success" value="启用">
    <input type="button" disabled class="btn btn-sm btn-default" value="禁用">
    <input type="button" disabled class="btn btn-sm btn-danger" value="删除">
</div>

<input type="hidden" id="pMenu" value="{{ $menu_id }}">

<script type="text/html" id="permission">
    <!-- 这里的 checked 的状态只是演示 -->
    <a href="javascript:void(0)" class="text-info" onclick="updatePermission('@{{ d.edit_url }}')">@{{ d.name }}</a>
</script>


<script type="text/html" id="switchTpl">
    <!-- 这里的 checked 的状态只是演示 -->
    <input disabled type="checkbox" name="sex" value="@{{ d.status }}" lay-skin="switch" lay-text="启用|禁用" @{{ d.status == 0 ? 'checked' : false }} >
</script>

<script type="text/javascript">
    layui.use('table', function () {
        var table = layui.table;
        table.render({
            elem: '#permissions',
            url: '{{ route("authPermissions.permissions", ['menu_id' => $menu_id]) }}',
            cols: [[
                {type: 'checkbox'},
                {field:'name', title:'名称', width:120, templet: '#permission'},
                {field:'route', title:'路由', width:120},
                {field:'description', title:'描述'},
                {field:'status', title:'状态', width:95, templet: '#switchTpl', unresize: true}
            ]],
            id: 'permissions',
            limit: 15,
            limits:[15,30,50,100],
            page: true,
            height: '360px'
        });

        table.on('checkbox(permissions)', function(obj){
            var checkStatus = table.checkStatus('permissions')
                , data = checkStatus.data;
            if (data.length) {
                $("#permission_btns input[type=button]").prop('disabled', false);
            } else {
                $("#permission_btns input[type=button]").prop('disabled', true);
            }
        });
    });

    function updatePermission(url) {
        var menu_id = $("#pMenu").val();
        $.get(url, {menu: menu_id}, function (response) {
            layui.use([], function () {
                var layer = layui.layer;
                layer.open({
                    type: 1,
                    title: "更新权限",
                    area: ['600px', 'auto'],
                    maxmin: true,
                    content: response
                });
            })
        })

    }
    
    function addPermission() {
        var menu_id = $("#pMenu").val();
        $.get("{{ route('authPermissions.create') }}", {menu: menu_id}, function (response) {
            layui.use([], function () {
                var layer = layui.layer;
                layer.open({
                    type: 1,
                    title: "创建权限",
                    area: ['600px', 'auto'],
                    maxmin: true,
                    content: response
                });
            })
        })
    }

</script>