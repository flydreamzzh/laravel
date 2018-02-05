<!-- Name Field -->
<div class="layui-form-item">
    {{ Form::label('name', '名称', ['class' => 'layui-form-label']) }}
    <div class="layui-input-block">
        {{ Form::text('name', null, ['required', 'lay-verify' => 'required', 'placeholder' => '请输入用户名称', 'class' => 'layui-input']) }}
    </div>
</div>

<!-- Email Field -->
<div class="layui-form-item">
    {{ Form::label('email', '邮箱', ['class' => 'layui-form-label']) }}
    <div class="layui-input-block">
        {{ Form::text('email', null, ['required', 'lay-verify' => 'required', 'placeholder' => '请输入用户邮箱', 'class' => 'layui-input']) }}
    </div>
</div>

{{--<!-- Submit Field -->--}}
<div class="layui-form-item">
    <div class="layui-input-block">
        {{ Form::submit('立即提交', ['lay-submit', 'lay-filter' => 'submit', 'class' => 'layui-btn']) }}
        {{ Form::reset('重置', ['class' => 'layui-btn layui-btn-primary']) }}
    </div>
</div>