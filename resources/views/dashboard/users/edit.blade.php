@extends('layouts.dashboard.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.users')

            </h1>
            <ol class="breadcrumb">
                <li class=" breadcrumb-item"><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li class=" breadcrumb-item"><a href="{{route('dashboard.users.index')}}">@lang('site.users')</a></li>
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
                    <form role="form" action="{{route('dashboard.users.update',$user->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{method_field('put')}}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="first_name">@lang('site.first_name')</label>
                                <input type="text" name="first_name" class="form-control" id="first_name" value="{{$user->first_name}}" >
                            </div>
                            <div class="form-group">
                                <label for="last_name">@lang('site.last_name')</label>
                                <input type="text" name="last_name" class="form-control" id="last_name" value="{{$user->last_name}}" >
                            </div>
                            <div class="form-group">
                                <label for="email">@lang('site.email')</label>
                                <input type="email" name="email" class="form-control" id="email" value="{{$user->email}}" >
                            </div>
                            <div class="form-group">
                                <label for="image">@lang('site.image')</label>
                                <input type="file" name="image" class="form-control image" id="image"  >
                            </div>
                            <div class="form-group">
                                <img src="{{$user->image_path}}" class="img-thumbnail image-preview" width="100px" alt="" >
                            </div>
                            <div class="form-group">
                                <label for="permissions">@lang('site.permissions')</label>

                                <div class="nav-tabs-custom">
                                    @php
                                        $models=['users','categories','products','clients','orders'];
                                        $maps=['create','read','update','delete']
                                    @endphp
                                    <ul class="nav nav-tabs">
                                        @foreach($models as $i=>$model)
                                            <li class="{{$i == 0 ? 'active' : ''}}"><a href="#{{$model}}" data-toggle="tab">@lang('site.'.$model)</a></li>
                                        @endforeach
                                    </ul>

                                    <div class="tab-content">
                                        @foreach($models as $i=>$model)
                                            <div class="tab-pane {{$i == 0 ? 'active' : ''}}" id="{{$model}}">
                                                @foreach($maps as $map)
                                                    <label for="{{$map}}_{{$model}}"><input type="checkbox" name="permissions[]" value="{{$map}}_{{$model}}" id="{{$map}}_{{$model}}" {{$user->hasPermission($map.'_'.$model) ? 'checked' : ''}}>@lang('site.'.$map)</label>
                                                @endforeach
                                            </div>
                                        @endforeach

                                    </div>

                                </div>

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
