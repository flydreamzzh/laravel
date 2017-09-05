@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('layui/css/layui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menu/menu.css') }}">
    <div class="menu">
        <div class="menu-list">
            <div class="menu-operation">

            </div>
            <div class="menu-table">
                <table class="layui-table" style="height: 800px" lay-data="{height: '580', page:true, id:'idTest'}" lay-filter="demo">
                    <thead>
                    <tr>
                        <th lay-data="{checkbox: true, LAY_CHECKED: false}"></th>
                        <th lay-data="{field:'name', width:100}">名称</th>
                        <th lay-data="{field:'name', width:100}">名称</th>
                        <th lay-data="{field:'description', width:250, sort: true}">描述</th>
                        <th lay-data="{field:'url', width:200, sort: true}">路由</th>
                        <th lay-data="{field:'lft', width:80, sort: true}">左值</th>
                        <th lay-data="{field:'rgt', width:80, sort: true}">右值</th>
                        <th lay-data="{fixed: 'right', width:160, align:'center', toolbar: '#barDemo'}"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($menus as $menu)
                        <tr>
                            <td>{!! $menu->name !!}</td>
                            <td>{!! $menu->description !!}</td>
                            <td>{!! $menu->url !!}</td>
                            <td>{!! $menu->icon !!}</td>
                            <td>{!! $menu->lft !!}</td>
                            <td>{!! $menu->rgt !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="menu-tree">

        </div>
        <div class="menu-info">

        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript" src="{{ asset('layui/layui.js') }}"></script>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-primary layui-btn-mini" lay-event="detail">查看</a>
        <a class="layui-btn layui-btn-mini" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-mini" lay-event="del">删除</a>
    </script>
    <script type="text/javascript">
        layui.use('table', function(){
            var table = layui.table;
            table.init('demo', {
                height: 315 //设置高度
                //支持所有基础参数
            });

            //监听工具条
            table.on('tool(demo)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'detail'){
                    layer.msg('查看操作');
                } else if(layEvent === 'del'){
                    layer.confirm('真的删除行么', function(index){
                        obj.del(); //删除对应行（tr）的DOM结构
                        layer.close(index);
                        //向服务端发送删除指令
                    });
                } else if(layEvent === 'edit'){
                    layer.msg('编辑操作');
                }
            });
        });

    </script>
@endsection
