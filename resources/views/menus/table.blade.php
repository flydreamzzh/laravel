<table class="layui-table" style="height: 800px"
       lay-data="{height: '380', limits:[15,30,50,100], limit: 15, page:true, id:'idTest', url:'{{ route("menus.table") }}'}"
       lay-filter="menusTable">
    <thead>
    <tr>
        <th lay-data="{field:'name', width:150, fixed: true}">名称</th>
        <th lay-data="{field:'description', width:200, sort: true}">描述</th>
        <th lay-data="{field:'url', width:100, sort: true}">路由</th>
        <th lay-data="{field:'lft', width:80, sort: true}">左值</th>
        <th lay-data="{field:'rgt', width:80, sort: true}">右值</th>
        <th lay-data="{fixed: 'right', width:160, align:'center', toolbar: '#barDemo'}"></th>
    </tr>
    </thead>
</table>
<div type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-primary layui-btn-mini" lay-event="detail">查看</a>
    <a class="layui-btn layui-btn-mini" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-mini" lay-event="del">删除</a>
</div>
@section('table_js')
    <script type="text/javascript">
        layui.use('table', function () {
            var table = layui.table;
            //监听工具条
            table.on('tool(menusTable)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    , layEvent = obj.event; //获得 lay-event 对应的值
                if (layEvent === 'detail') {
                    layer.open({
                        type: 2,
                        area: ['700px', '450px'],
                        fixed: false, //不固定
                        maxmin: true,
                        content: [data.show_url, 'no']
                    });
                    console.log(obj);
                } else if (layEvent === 'del') {
                    layer.confirm('真的删除行么', function (index) {
                        obj.del(); //删除对应行（tr）的DOM结构
                        layer.close(index);
                        //向服务端发送删除指令
                    });
                } else if (layEvent === 'edit') {
                    layer.open({
                        type: 2,
                        area: ['700px', '450px'],
                        fixed: false, //不固定
                        maxmin: true,
                        content: data.edit_url
                    })

                }
            });
        });
    </script>
@endsection