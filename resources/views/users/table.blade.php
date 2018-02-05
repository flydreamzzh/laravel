<!-- 用户表格 -->
<table class="layui-hide" id="usersTable" lay-filter="usersTable"></table>
@section('userJS')
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看</a>
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script type="text/javascript">
        layui.use('table', function () {
            var table = layui.table;
            table.render({
                elem: '#usersTable',
                url: '{{ route("users.table") }}',
                cols: [[
                    {checkbox: true, fixed: true},
                    {field: 'name', title: '名称', width: 150, fixed: true},
                    {field: 'email', title: '邮箱'},
                    {fixed: 'right', width: 160, align: 'center', toolbar: '#barDemo'}
                ]],
                id: 'users',
                limit: 15,
                limits:[15,30,50,100],
                page: true,
                height: 'full'
            });

            //监听工具条
            table.on('tool(usersTable)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    , layEvent = obj.event; //获得 lay-event 对应的值
                if (layEvent === 'detail') {
                    $.get(data.show_url, function (response) {
                        layer.open({
                            type: 1,
                            title: data.name,
                            area: ['700px', 'auto'],
                            maxmin: true,
                            content: response
                        });
                    })
                } else if (layEvent === 'del') {
                    layer.confirm('真的删除行么', function (index) {
                        obj.del(); //删除对应行（tr）的DOM结构
                        layer.close(index);
                        //向服务端发送删除指令
                    });
                } else if (layEvent === 'edit') {
                    $.get(data.edit_url, function (response) {
                        window.menuObj = obj;
                        layer.open({
                            type: 1,
                            id: 'update',
                            title: data.name,
                            area: ['800px', 'auto'],
                            maxmin: true,
                            content: response
                        });
                    })
                }
            });
        });
    </script>
@endsection