<table class="table table-responsive" id="menus-table">
    <thead>
        <th>Name</th>
        <th>Description</th>
        <th>Url</th>
        <th>Icon</th>
        <th>Lft</th>
        <th>Rgt</th>
        <th colspan="3">Action</th>
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
            <td>
                {!! Form::open(['route' => ['menus.destroy', $menu->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('menus.show', [$menu->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('menus.edit', [$menu->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>