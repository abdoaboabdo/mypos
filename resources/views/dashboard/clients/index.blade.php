@extends('layouts.dashboard.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.clients')

            </h1>
            <ol class="breadcrumb">
                <li class=" breadcrumb-item"><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li class="active breadcrumb-item">@lang('site.clients')</li>
            </ol>
        </section>
        <section class="content"><div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('site.clients') <small>{{$clients->total()}}</small></h3>

                        <form action="{{route('dashboard.clients.index')}}" method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{request()->search}}">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                                    @if (auth()->user()->hasPermission('create_clients'))
                                        <a href="{{route('dashboard.clients.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @else
                                        <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                       @if ($clients->count() > 0)
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.name')</th>
                                    <th>@lang('site.phone')</th>
                                    <th>@lang('site.address')</th>
                                    <th>@lang('site.add_order')</th>
                                    <th>@lang('site.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($clients as $index=>$client)
                                        <tr>
                                            <td>{{$index + 1}}</td>
                                            <td>{{$client->name}}</td>
                                            <td>{{is_array($client->phone)?implode($client->phone,'-'):$client->phone}}</td>
                                            <td>{{$client->address}}</td>
                                            <td>
                                                @if (auth()->user()->hasPermission('update_orders'))
                                                    <a href="{{route('dashboard.clients.orders.create',$client->id)}}" class="btn btn-primary btn-sm">@lang('site.add_order')</a>
                                                @else
                                                    <a href="#" class="btn btn-primary btn-sm disabled">@lang('site.add_order')</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if (auth()->user()->hasPermission('update_clients'))
                                                    <a href="{{route('dashboard.clients.edit',$client->id)}}" class="btn btn-info btn-sm">@lang('site.edit')</a>
                                                @else
                                                    <a href="#" class="btn btn-info btn-sm disabled" >@lang('site.edit')</a>
                                                @endif
                                                @if (auth()->user()->hasPermission('delete_clients'))
                                                    <form action="{{route('dashboard.clients.destroy',$client->id)}}" method="post" style="display: inline-block">
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
                           {{$clients->appends(request()->query())->links()}}
                           @else
                           <h2>@lang('site.no_data_found')</h2>
                       @endif
                    </div>

                </div>

            </div>

        </section>
    </div>
@endsection
