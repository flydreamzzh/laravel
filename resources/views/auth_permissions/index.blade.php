@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('vendor/plugins/fancytree/skin-win8/ui.fancytree.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/user.css') }}">
    <div class="user">
        <div class="col-lg-2 col-md-3 role-list">
            @include('auth_permissions.lists')
        </div>
        <div class="col-lg-10 col-md-9 user-list">
            <div class="col-md-12 role-info">
                从一个业务服务系统的首端至末端的业务流程，这种服务流的监控是企业所迫切需要的。因为一旦系统出现性能慢的情况，就很难定位到底是哪里慢。
                从一个业务服务系统的首端至末端的业务流程，这种服务流的监控是企业所迫切需要的。因为一旦系统出现性能慢的情况，就很难定位到底是哪里慢。
                从一个业务服务系统的首端至末端的业务流程，这种服务流的监控是企业所迫切需要的。因为一旦系统出现性能慢的情况，就很难定位到底是哪里慢。
            </div>
            <div class="col-md-12 p10">
                @include('auth_permissions.table')
            </div>
        </div>
    </div>
@endsection

@section('js')
    @yield('roleJS')
    @yield('userJS')
@endsection
