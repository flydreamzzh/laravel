<!-- Url Field -->
<div class="layui-form-item">
    {{ Form::label('url', '上级', ['class' => 'layui-form-label']) }}
    <div class="layui-input-block" id="__react-content">
        {{ Form::hidden('parent', 4, ['id' => "treeSelectValue"]) }}
    </div>
</div>

<!-- Name Field -->
<div class="layui-form-item">
    {{ Form::label('name', '名称', ['class' => 'layui-form-label']) }}
    <div class="layui-input-block">
        {{ Form::text('name', null, ['required', 'lay-verify' => 'required', 'placeholder' => '请输入节点名称', 'class' => 'layui-input']) }}
    </div>
</div>

<!-- Description Field -->
<div class="layui-form-item">
    {{ Form::label('description', '描述', ['class' => 'layui-form-label']) }}
    <div class="layui-input-block">
        {{ Form::textarea('description', null, ['rows' => 4, 'placeholder' => '请简单描述节点内容', 'class' => 'layui-textarea']) }}
    </div>
</div>

<!-- Url Field -->
<div class="layui-form-item">
    {{ Form::label('url', '路由', ['class' => 'layui-form-label']) }}
    <div class="layui-input-block">
        {{ Form::text('url', null, ['required', 'lay-verify' => 'required', 'placeholder' => '请输入节点路由', 'class' => 'layui-input']) }}
    </div>
</div>

<!-- Icon Field -->
<div class="layui-form-item">
    {{ Form::label('icon', '图标', ['class' => 'layui-form-label']) }}
    <div class="layui-input-block">
        {{ Form::text('icon', null, ['class' => 'layui-input']) }}
    </div>
</div>

<!-- treeSelect插件请求数据路由-->
<input type="hidden" id="treeSelectUrl" value="{{ route('menus.table') }}">

{{--<!-- Lft Field -->--}}
{{--<div class="layui-form-item">--}}
    {{--{{ Form::label('lft', '左值', ['class' => 'layui-form-label']) }}--}}
    {{--<div class="layui-input-block">--}}
        {{--{{ Form::number('lft', null, ['class' => 'layui-input']) }}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<!-- Rgt Field -->--}}
{{--<div class="layui-form-item">--}}
    {{--{{ Form::label('rgt', '右值', ['class' => 'layui-form-label']) }}--}}
    {{--<div class="layui-input-block">--}}
        {{--{{ Form::number('rgt', null, ['class' => 'layui-input']) }}--}}
    {{--</div>--}}
{{--</div>--}}

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