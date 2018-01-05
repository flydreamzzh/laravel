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
                    $("#treeTable").fancytree("getTree").reload({url: "{{ route('menus.table') }}"});
                    layer.closeAll();
                    layer.msg(response.message, {icon: 1});
                } else {
                    layer.msg(response.message, {icon: 2});
                }
            }).fail(function (data) {
                var message = '';
                $.each(data.responseJSON, function (key, value) {
                    if (value instanceof Array) {
                        message += value.join('<br>') + "<br>";
                    } else {
                        message += value + "<br>";
                    }
                });
                layer.msg(message, {icon: 5});
            });
            return false;
        });
    })
</script>