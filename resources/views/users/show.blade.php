<table class="layui-table">
    <tbody>
    <tr>
        <th width="20%">名称</th>
        <td>{!! $user->name !!}</td>
    </tr>
    <tr>
        <th>邮箱</th>
        <td>{!! $user->email !!}</td>
    </tr>
    <tr>
        <td>创建时间</td>
        <td>{!! $user->created_at !!}</td>
    </tr>
    <tr>
        <td>更新时间</td>
        <td>{!! $user->updated_at !!}</td>
    </tr>
    </tbody>
</table>