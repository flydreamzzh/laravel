@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/menu/menu.css') }}">
    <div class="menu">
        <div class="menu-list">
            <div class="menu-head">
                <fieldset class="layui-elem-field layui-field-title" style="border-top:1px solid white">
                    <legend style="color: white">节点管理</legend>
                </fieldset>
            </div>
            <div class="menu-table">
                <table class="layui-table" style="height: 800px" lay-data="{height: '380', page:true, id:'idTest'}" lay-filter="demo">
                    <thead>
                    <tr>
                        <th lay-data="{checkbox: true, LAY_CHECKED: false, fixed: true}"></th>
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
            <div class="menu-operation">

            </div>
        </div>
        <div class="menu-tree">
            <ul id="demo1"></ul>
        </div>
        <div class="menu-info">
            <table class="layui-table">
                <thead>
                <tr>
                    <th colspan="2" scope="col"><strong>节点信息</strong></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th width="30%">服务器计算机名</th>
                    <td>http://127.0.0.1/</td>
                </tr>
                <tr>
                    <td>服务器IP地址</td>
                    <td>192.168.1.1</td>
                </tr>
                <tr>
                    <td>服务器域名</td>
                    <td>www.erdangjiade.com</td>
                </tr>
                <tr>
                    <td>服务器端口 </td>
                    <td>80</td>
                </tr>
                <tr>
                    <td>服务器IIS版本 </td>
                    <td>Microsoft-IIS/6.0</td>
                </tr>
                <tr>
                    <td>本文件所在文件夹 </td>
                    <td>D:\WebSite\HanXiPuTai.com\XinYiCMS.Web\</td>
                </tr>
                <tr>
                    <td>服务器操作系统 </td>
                    <td>Microsoft Windows NT 5.2.3790 Service Pack 2</td>
                </tr>
                <tr>
                    <td>系统所在文件夹 </td>
                    <td>C:\WINDOWS\system32</td>
                </tr>
                <tr>
                    <td>服务器脚本超时时间 </td>
                    <td>30000秒</td>
                </tr>
                <tr>
                    <td>服务器的语言种类 </td>
                    <td>Chinese (People's Republic of China)</td>
                </tr>
                <tr>
                    <td>.NET Framework 版本 </td>
                    <td>2.050727.3655</td>
                </tr>
                <tr>
                    <td>服务器当前时间 </td>
                    <td>2017-01-01 12:06:23</td>
                </tr>
                <tr>
                    <td>服务器IE版本 </td>
                    <td>6.0000</td>
                </tr>

                </tbody>
            </table>
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

        layui.use(['tree', 'layer'], function(){
            var layer = layui.layer
                ,$ = layui.jquery;

            layui.tree({
                elem: '#demo1' //指定元素
                ,target: '_blank' //是否新选项卡打开（比如节点返回href才有效）
                ,click: function(item){ //点击节点回调
                    layer.msg('当前节名称：'+ item.name + '<br>全部参数：'+ JSON.stringify(item));
                    console.log(item);
                }
                ,nodes: [ //节点
                    {
                        name: '常用文件夹'
                        ,id: 1
                        ,alias: 'changyong'
                        ,children: [
                        {
                            name: '所有未读（设置跳转）'
                            ,id: 11
                            ,href: 'http://www.layui.com/'
                            ,alias: 'weidu'
                        }, {
                            name: '置顶邮件'
                            ,id: 12
                        }, {
                            name: '标签邮件'
                            ,id: 13
                        }
                    ]
                    }, {
                        name: '我的邮箱'
                        ,id: 2
                        ,spread: true
                        ,children: [
                            {
                                name: 'QQ邮箱'
                                ,id: 21
                                ,spread: true
                                ,children: [
                                {
                                    name: '收件箱'
                                    ,id: 211
                                    ,children: [
                                    {
                                        name: '所有未读'
                                        ,id: 2111
                                    }, {
                                        name: '置顶邮件'
                                        ,id: 2112
                                    }, {
                                        name: '标签邮件'
                                        ,id: 2113
                                    }
                                ]
                                }, {
                                    name: '已发出的邮件'
                                    ,id: 212
                                }, {
                                    name: '垃圾邮件'
                                    ,id: 213
                                }
                            ]
                            }, {
                                name: '阿里云邮'
                                ,id: 22
                                ,children: [
                                    {
                                        name: '收件箱'
                                        ,id: 221
                                    }, {
                                        name: '已发出的邮件'
                                        ,id: 222
                                    }, {
                                        name: '垃圾邮件'
                                        ,id: 223
                                    }
                                ]
                            }
                        ]
                    }
                    ,{
                        name: '收藏夹'
                        ,id: 3
                        ,alias: 'changyong'
                        ,children: [
                            {
                                name: '爱情动作片'
                                ,id: 31
                                ,alias: 'love'
                            }, {
                                name: '技术栈'
                                ,id: 12
                                ,children: [
                                    {
                                        name: '前端'
                                        ,id: 121
                                    }
                                    ,{
                                        name: '全端'
                                        ,id: 122
                                    }
                                ]
                            }
                        ]
                    }
                ]
            });


            //生成一个模拟树
            var createTree = function(node, start){
                node = node || function(){
                    var arr = [];
                    for(var i = 1; i < 10; i++){
                        arr.push({
                            name: i.toString().replace(/(\d)/, '$1$1$1$1$1$1$1$1$1')
                        });
                    }
                    return arr;
                }();
                start = start || 1;
                layui.each(node, function(index, item){
                    if(start < 10 && index < 9){
                        var child = [
                            {
                                name: (1 + index + start).toString().replace(/(\d)/, '$1$1$1$1$1$1$1$1$1')
                            }
                        ];
                        node[index].children = child;
                        createTree(child, index + start + 1);
                    }
                });
                return node;
            };

            layui.tree({
                elem: '#demo2' //指定元素
                ,nodes: createTree()
            });

        });

    </script>
@endsection
