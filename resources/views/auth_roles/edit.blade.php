@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Auth Role
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($authRole, ['route' => ['authRoles.update', $authRole->id], 'method' => 'patch']) !!}

                        @include('auth_roles.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection