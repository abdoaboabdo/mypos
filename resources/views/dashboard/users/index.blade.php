@extends('layouts.dashboard.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.users')

            </h1>
            <ol class="breadcrumb">
                <li class=" breadcrumb-item"><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li class="active breadcrumb-item">@lang('site.users')</li>
            </ol>
        </section>
        <section class="content"><div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('site.users') <small>{{$users->total()}}</small></h3>

                        <form action="{{route('dashboard.users.index')}}" method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{request()->search}}">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                                    @if (auth()->user()->hasPermission('create_users'))
                                        <a href="{{route('dashboard.users.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @else
                                        <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                       @if ($users->count() > 0)
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.first_name')</th>
                                    <th>@lang('site.last_name')</th>
                                    <th>@lang('site.email')</th>
                                    <th>@lang('site.image')</th>
                                    <th>@lang('site.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $index=>$user)
                                        <tr>
                                            <td>{{$index + 1}}</td>
                                            <td>{{$user->first_name}}</td>
                                            <td>{{$user->last_name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td><img src="{{$user->image_path}}" class="img-thumbnail" style="width: 100px" alt=""></td>
                                            <td>
                                                @if (auth()->user()->hasPermission('update_users'))
                                                    <a href="{{route('dashboard.users.edit',$user->id)}}" class="btn btn-info btn-sm">@lang('site.edit')</a>
                                                @else
                                                    <a href="#" class="btn btn-info btn-sm disabled" >@lang('site.edit')</a>
                                                @endif
                                                @if (auth()->user()->hasPermission('delete_users'))
                                                    <form action="{{route('dashboard.users.destroy',$user->id)}}" method="post" style="display: inline-block">
                                                        @csrf
                                                        {{--                                                    {{csrf_token()}}--}}
                                                        {{method_field('delete')}}
                                                        <button class="btn btn-danger delete btn-sm">@lang('site.delete')</button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-danger btn-sm disabled">@lang('site.delete')</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                           {{$users->appends(request()->query())->links()}}
                           @else
                           <h2>@lang('site.no_data_found')</h2>
                       @endif
                    </div>

                </div>

            </div>

        </section>
    </div>
@endsection
