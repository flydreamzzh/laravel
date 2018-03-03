<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Lft Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lft', 'Lft:') !!}
    {!! Form::number('lft', null, ['class' => 'form-control']) !!}
</div>

<!-- Rgt Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rgt', 'Rgt:') !!}
    {!! Form::number('rgt', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('authRoles.index') !!}" class="btn btn-default">Cancel</a>
</div>