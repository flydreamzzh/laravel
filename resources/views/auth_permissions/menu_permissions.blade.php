<div class="layui-card-header p6">
    <div class="pull-left" style="height: auto;width: 200px">
        {{--<input type="text" class="layui-input" style="height: 30px">--}}
    <input type="text" name="title" lay-verify="title" autocomplete="off" style="height: 30px" placeholder="请输入标题" class="layui-input">
    </div>
    <button class="pull-right btn btn-sm btn-dark" onclick="addPermission()"><i class="fa fa-plus"></i> 新增</button>
</div>
<table class="layui-hide" id="permissions" lay-filter="usersTable"></table>
<div class="pl5" style="width: 100%;height: auto;margin-bottom: 0;">
    <input type="button" disabled class="btn btn-sm btn-success" value="启用">
    <input type="button" disabled class="btn btn-sm btn-default" value="禁用">
    <input type="button" disabled class="btn btn-sm btn-danger" value="删除">
</div>

<script type="text/html" id="switchTpl">
    <!-- 这里的 checked 的状态只是演示 -->
    <input type="checkbox" name="sex" value="@{{ d.status }}" lay-skin="switch" lay-text="启用|禁用" lay-filter="sexDemo" @{{ d.status == 0 ? 'checked' : false }} >
</script>

<script type="text/javascript">
    layui.use('table', function () {
        var table = layui.table;
        table.render({
            elem: '#permissions',
            url: '{{ route("authPermissions.permissions") }}',
            cols: [[
                {type: 'checkbox'},
                {field:'name', title:'名称'},
                {field:'route', title:'路由'},
                {field:'description', title:'描述'},
                {field:'status', title:'状态', width:85, templet: '#switchTpl', unresize: true}
            ]],
            id: 'users',
            limit: 15,
            limits:[15,30,50,100],
            page: true,
            height: '400px'
        });
//        //监听性别操作
//        form.on('switch(sexDemo)', function(obj){
//            layer.tips(this.value + ' ' + this.name + '：'+ obj.elem.checked, obj.othis);
//        });
    });

</script>