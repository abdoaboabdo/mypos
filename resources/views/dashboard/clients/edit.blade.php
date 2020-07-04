@extends('layouts.dashboard.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.clients')

            </h1>
            <ol class="breadcrumb">
                <li class=" breadcrumb-item"><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li class=" breadcrumb-item"><a href="{{route('dashboard.clients.index')}}">@lang('site.clients')</a></li>
                <li class="active breadcrumb-item">@lang('site.edit')</li>
            </ol>
        </section>
        <section class="content"><div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('site.edit')</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    @include('partials._errors')
                    <form role="form" action="{{route('dashboard.clients.update',$client->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{method_field('put')}}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">@lang('site.name')</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{$client->name}}" >
                            </div>

                            @for($i=0;$i<2;$i++)
                                <div class="form-group">
                                    <label for="phone">@lang('site.phone')</label>
                                    <input type="text" name="phone[]" class="form-control" id="phone"  value="{{$client->phone[$i] ?? ''}}">
                                </div>
                            @endfor
                            <div class="form-group">
                                <label for="address">@lang('site.address')</label>
                                <textarea name="address" class="form-control" id="address" value="" >{{$client->address}}</textarea>
                            </div>


                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="@lang('site.edit')">
                        </div>
                    </form>

                </div>

            </div>

        </section>
    </div>
@endsection
