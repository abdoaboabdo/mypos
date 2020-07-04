@extends('layouts.dashboard.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.categories')

            </h1>
            <ol class="breadcrumb">
                <li class=" breadcrumb-item"><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li class=" breadcrumb-item"><a href="{{route('dashboard.categories.index')}}">@lang('site.categories')</a></li>
                <li class="active breadcrumb-item">@lang('site.add')</li>
            </ol>
        </section>
        <section class="content"><div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('site.add')</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    @include('partials._errors')
                    <form role="form" action="{{route('dashboard.categories.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{method_field('post')}}

                        @foreach (config('translatable.locales') as $locale)
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">@lang('site.'.$locale.'.name')</label>
                                    <input type="text" name="{{$locale}}[name]" class="form-control" id="name" value="{{old($locale.'.name')}}" >
                                </div>

                            </div>
                        @endforeach
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="@lang('site.add')">
                        </div>
                    </form>

                </div>

            </div>

        </section>
    </div>
@endsection
