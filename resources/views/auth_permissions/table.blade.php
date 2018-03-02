@php($menus = (new \App\Models\Menu())->tree_lastNodes())

<div class="layui-collapse" lay-filter="test">
    <form class="layui-form layui-form-pane" action="">
    @foreach($menus as $menu)
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">
                {{ $menu->name }}
                <div class="pull-right">
                    <input type="button" class="layui-btn layui-btn-primary layui-btn-xs" value="编辑" onclick="editPermission('{{ $menu->id }}', '{{ $menu->name }}')">
                </div>
            </h2>
            <div class="layui-form-item">
                <input type="checkbox" name="like1[write]" lay-skin="primary" title="写作" checked="">
                <input type="checkbox" name="like1[read]" lay-skin="primary" title="阅读">
                <input type="checkbox" name="like1[game]" lay-skin="primary" title="游戏" disabled="">
                <input type="checkbox" name="like1[1]" lay-skin="primary" title="写作" checked="">
                <input type="checkbox" name="like1[2]" lay-skin="primary" title="阅读">
                <input type="checkbox" name="like1[3]" lay-skin="primary" title="游戏" disabled="">
            </div>
        </div>
    @endforeach
    </form>
</div>
<script type="text/javascript">
    layui.use(['form'], function() {
        var form = layui.form;
        form.render();
    })

    function editPermission(menu_id, title) {
        $.get("{{ route("authPermissions.menuPermissions") }}", {}, function (response) {
            layui.use([],function () {
                var  layer = layui.layer;
                layer.open({
                    type: 1,
                    title: "权限管理：" + title,
                    area: ['800px', '500px'],
                    maxmin: true,
                    content: response
                });
            })
        })

    }

</script>