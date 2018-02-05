<table class="table table-responsive" id="authRoles-table">
    <thead>
        <tr>
            <th>Name</th>
        <th>Description</th>
        <th>Lft</th>
        <th>Rgt</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($authRoles as $authRole)
        <tr>
            <td>{!! $authRole->name !!}</td>
            <td>{!! $authRole->description !!}</td>
            <td>{!! $authRole->lft !!}</td>
            <td>{!! $authRole->rgt !!}</td>
            <td>
                {!! Form::open(['route' => ['authRoles.destroy', $authRole->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('authRoles.show', [$authRole->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('authRoles.edit', [$authRole->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>