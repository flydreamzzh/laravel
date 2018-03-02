@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Auth Permission
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('auth_permissions.show_fields')
                    <a href="{!! route('authPermissions.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
