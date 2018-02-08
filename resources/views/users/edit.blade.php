{!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch', 'class' => 'layui-form', 'style' => 'padding: 10px 30px 10px 10px']) !!}

@include('users.fields')

{!! Form::close() !!}

<script type="text/javascript">
    layui.use(['form', 'table'], function() {
        var form = layui.form, table = layui.table;
        form.render();
        form.on('submit(submit)', function(data){
            $.post(data.form.action, data.field, function (response) {
                if (response.success) {
                    window.userObj.update(response.data);
                    layer.closeAll();
                    layer.msg(response.message, {icon: 1});
                } else {
                    layer.msg(response.message, {icon: 2});
                }
            }).fail(function (data) {
                layer.msg(data.responseJSON.message, {icon: 5});
            });
            return false;
        });
    })
</script>