<!-- Name Field -->
<div class="layui-form-item">
    {!! Form::label('name', '名称', ['class' => 'layui-form-label']) !!}
    <div class="layui-input-block">
        {{ Form::text('name', null, ['required', 'lay-verify' => 'required', 'placeholder' => '请输入权限名称', 'class' => 'layui-input']) }}
    </div>
</div>

<!-- Route Field -->
<div class="layui-form-item">
    {!! Form::label('route_name', '路由', ['class' => 'layui-form-label']) !!}
    <div class="layui-input-block">
        {{ Form::text('route_name', null, ['required', 'lay-verify' => 'required', 'placeholder' => '请输入路由，如：menus.index', 'class' => 'layui-input']) }}
    </div>
</div>

<!-- Description Field -->
<div class="layui-form-item">
    {!! Form::label('description', '描述', ['class' => 'layui-form-label']) !!}
    <div class="layui-input-block">
        {{ Form::textarea('description', null, ['rows' => 3, 'placeholder' => '请简单描述此权限（可不填）', 'class' => 'layui-textarea']) }}
    </div>
</div>

<!-- Status Field -->
<div class="layui-form-item">
    {!! Form::label('status', '状态', ['class' => 'layui-form-label']) !!}
    <div class="layui-input-block">
    {!! Form::checkbox('status', 0, true, ['lay-skin' => "switch", 'lay-filter' => 'setStatus', 'lay-text' => "启用|禁用", ]) !!}
    {!! Form::hidden('status_close', 1, ['id' => "switch_status"]) !!}
    </div>
</div>

<!-- Menu Id Field -->
{!! Form::hidden('menu_id', $menu_id) !!}

<!-- Submit Field -->
<div class="layui-form-item">
    <div class="layui-input-block">
        {{ Form::submit('立即提交', ['lay-submit', 'lay-filter' => 'submit', 'class' => 'layui-btn']) }}
        {{ Form::reset('重置', ['class' => 'layui-btn layui-btn-primary']) }}
    </div>
</div>

<script>
    layui.use('form', function(){
        var form = layui.form;
        //监听性别操作
        form.on('switch(setStatus)', function(obj){
            $("#switch_status").attr('name', obj.elem.checked ? 'status_close' : 'status');
        });
    });
</script>