{!! Form::model($authPermission, ['route' => ['authPermissions.update', $authPermission->id], 'method' => 'patch', 'class' => 'layui-form', 'style' => 'padding: 10px 30px 10px 10px']) !!}

@include('auth_permissions.fields')

{!! Form::close() !!}


<script type="text/javascript">
    layui.use(['form', 'table'], function() {
        var form = layui.form, table = layui.table;
        form.render();
        form.on('submit(submit)', function(data){
            $.post(data.form.action, data.field, function (response) {
                if (response.success) {
                    layer.close(layer.index);
                    table.reload('permissions');
                    layer.msg(response.message, {icon: 1});
                } else {
                    layer.msg(response.message, {icon: 2});
                }
            }).fail(function (response) {
                var message = response.responseJSON.message;
                layer.msg(message, {icon: 5});
            });
            return false;
        });
    })
</script>