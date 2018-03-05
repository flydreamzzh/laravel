<?php
    $menus = (new \App\Models\Menu())->tree_lastNodes();
    $permissionsCur = \App\Models\AuthRolePermission::select('permission_id')->where('role_id', $role->id)->get()->toArray();
    $permissionIds = array_column($permissionsCur, 'permission_id');
?>

<div class="layui-header" style="height: 40px">
    <div class="pull-left" style="height: auto;width: 200px">
        <input type="text" name="title" lay-verify="title" autocomplete="off" style="height: 30px" placeholder="请输入菜单名称" class="layui-input">
    </div>
    <div class="layui-btn-group pull-right">
        <button class="layui-btn layui-btn-sm layui-btn-primary" id="selectAll_P">全选</button>
        <button class="layui-btn layui-btn-sm layui-btn-primary" id="unselectAll_P">全否</button>
        <button class="layui-btn layui-btn-sm layui-btn-primary" id="menuCollapse" value=1 >全部折叠</button>
    </div>
</div>
<div class="layui-collapse" id="permissionPanel">
    <form class="layui-form layui-form-pane" action="">
    @foreach($menus as $menu)
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">
                {{ $menu->name }}
            </h2>
            <div class="pull-right pr10" style="position: relative;margin-top: -32px">
                <div class="layui-btn-group">
                    <input type="button" class="layui-btn layui-btn-xs layui-btn-primary select_all_p" value="全选">
                    <input type="button" class="layui-btn layui-btn-xs layui-btn-primary unselect_all_p" value="全否">
                </div>
                <input type="button" class="layui-btn layui-btn-xs" value="编辑" onclick="editPermission('{{ $menu->id }}', '{{ $menu->name }}')">
            </div>
            <div class="layui-colla-content layui-show">

                @php($permissions = \App\Models\AuthPermission::where('menu_id', $menu->id)->get())

                @if(count($permissions))
                    @foreach($permissions as $permission)
                        <input type="checkbox" name="permissions[]" lay-skin="primary" title="{{ $permission->name }}" {{ in_array($permission->id, $permissionIds) ? 'checked' : '' }}>
                    @endforeach
                @else
                    <p>暂无权限</p>
                @endif

            </div>
        </div>
    @endforeach
    </form>
</div>

<script type="text/javascript">
    layui.use(['form', 'element'], function() {
        var form = layui.form, element = layui.element;
        element.render();
        form.render();
    });

    $("#selectAll_P").click(function () {
        layui.use(['form'], function() {
            $("#permissionPanel form input[type=checkbox]").prop('checked', true);
            var form = layui.form, element = layui.element;
            form.render('checkbox');
        });
    });

    $("#unselectAll_P").click(function () {
        layui.use(['form'], function() {
            $("#permissionPanel form input[type=checkbox]").prop('checked', false);
            var form = layui.form;
            form.render('checkbox');
        });
    });

    $(".select_all_p").click(function () {
        $(this).parent().parent().parent().find('.layui-colla-content input[type=checkbox]').prop('checked', true);
        layui.use(['form'], function() {
            var form = layui.form;
            form.render('checkbox');
        });
    });

    $(".unselect_all_p").click(function () {
        $(this).parent().parent().parent().find('.layui-colla-content input[type=checkbox]').prop('checked', false);
        layui.use(['form'], function() {
            var form = layui.form;
            form.render('checkbox');
        });
    });

    $("#menuCollapse").click(function () {
        if ($(this).val() == 0) {
            $(this).val(1);
            $(this).text('全部折叠');
            $("#permissionPanel .layui-colla-content").addClass("layui-show");
        } else {
            $(this).val(0);
            $(this).text('全部展开');
            $(".layui-colla-content").removeClass("layui-show");
        }
        layui.use(['element'], function() {
            var element = layui.element;
            element.render();
        });
    });

    function editPermission(menu_id, title) {
        $.get("{{ route("authPermissions.menuPermissions") }}", {menu: menu_id}, function (response) {
            layui.use([],function () {
                var  layer = layui.layer;
                layer.open({
                    type: 1,
                    title: "权限管理：" + title,
                    area: ['800px', '500px'],
                    maxmin: true,
                    content: response
                });
            })
        })

    }
</script>