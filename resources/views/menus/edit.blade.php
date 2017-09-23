@include('adminlte-templates::common.errors')

{!! Form::model($menu, ['route' => ['menus.update', $menu->id], 'method' => 'patch', 'class' => 'layui-form', 'style' => 'padding: 10px 30px 10px 10px']) !!}

@include('menus.fields')

{!! Form::close() !!}

<script type="text/javascript">
    layui.use(['form', 'table'], function() {
        var form = layui.form, table = layui.table;
        form.render();
        form.on('submit(submit)', function(data){
            $.post(data.form.action, data.field, function (response) {
                if (response.success) {
                    window.menuObj.update(response.data);
                    layer.closeAll();
                    layer.msg(response.message, {icon: 1});
                } else {
                    layer.msg(response.message, {icon: 2});
                }
            })
            return false;
        });
    })
</script>