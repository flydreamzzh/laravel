<div class="layui-form-item">
    {{ Form::label('role_id', '角色', ['class' => 'layui-form-label']) }}
    <div class="layui-input-block" id="__react-content">
        <!-- 插件内容 -->
    </div>
    {{ Form::hidden('role_id', null, ['placeholder' => '请选择角色……','id' => "treeSelectValue"]) }}
</div>

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

<!-- treeSelect插件请求数据路由-->
<input type="hidden" id="treeSelectUrl" value="{{ route('authRoles.lists') }}">

{{--<!-- Submit Field -->--}}
<div class="layui-form-item">
    <div class="layui-input-block">
        {{ Form::submit('立即提交', ['lay-submit', 'lay-filter' => 'submit', 'class' => 'layui-btn']) }}
        {{ Form::reset('重置', ['class' => 'layui-btn layui-btn-primary']) }}
    </div>
</div>

<style type="text/css">
    .treeSelect span {
        height: 38px;
        line-height: 37px;
    }
    .treeSelect .rc-tree-select-selection__clear {
        top: 0;
        font-size: 18px;
    }
</style>

<script type="text/javascript" src="{{ mix('js/menu/tree-select.js') }}"></script>