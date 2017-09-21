<table class="layui-table">
    <tbody>
    <tr>
        <th width="20%">名称</th>
        <td>{!! $menu->name !!}</td>
    </tr>
    <tr>
        <th>描述</th>
        <td>{!! $menu->description !!}</td>
    </tr>
    <tr>
        <td>路由</td>
        <td>{!! $menu->url !!}</td>
    </tr>
    <tr>
        <td>图标</td>
        <td>{!! $menu->icon !!}</td>
    </tr>
    <tr>
        <td>左值</td>
        <td>{!! $menu->lft !!}</td>
    </tr>
    <tr>
        <td>右值</td>
        <td>{!! $menu->rgt !!}</td>
    </tr>
    <tr>
        <td>创建时间</td>
        <td>{!! $menu->created_at !!}</td>
    </tr>
    <tr>
        <td>更新时间</td>
        <td>{!! $menu->updated_at !!}</td>
    </tr>
    </tbody>
</table>
