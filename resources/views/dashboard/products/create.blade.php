@extends('layouts.dashboard.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.products')

            </h1>
            <ol class="breadcrumb">
                <li class=" breadcrumb-item"><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li class=" breadcrumb-item"><a href="{{route('dashboard.products.index')}}">@lang('site.products')</a></li>
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
                    <form role="form" action="{{route('dashboard.products.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{method_field('post')}}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="categories">@lang('site.categories')</label>
                                <select name="category_id" id="categories" class="form-control">
                                    <option value="">@lang('site.all_categories')</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{old('category_id')== $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @foreach (config('translatable.locales') as $locale)

                                <div class="form-group">
                                    <label for="{{$locale}}name">@lang('site.'.$locale.'.name')</label>
                                    <input type="text" name="{{$locale}}[name]" class="form-control" id="{{$locale}}name" value="{{old($locale.'.name')}}" >
                                </div>

                                <div class="form-group">
                                    <label for="{{$locale}}description">@lang('site.'.$locale.'.description')</label>
                                    <textarea name="{{$locale}}[description]" class="form-control ckeditor" id="{{$locale}}description"  >{{old($locale.'.description')}}</textarea>
                                </div>


                            @endforeach
                            <div class="form-group">
                                <label for="image">@lang('site.image')</label>
                                <input type="file" name="image" class="form-control image" id="image"  >
                            </div>
                            <div class="form-group">
                                <img src="{{asset('uploads/product_images/default.png')}}" class="img-thumbnail image-preview" width="100px" alt="" >
                            </div>

                            <div class="form-group">
                                <label for="purchase_price">@lang('site.purchase_price')</label>
                                <input type="text" name="purchase_price" class="form-control" step="0.01" id="purchase_price" value="{{old('purchase_price')}}" >
                            </div>
                            <div class="form-group">
                                <label for="sale_price">@lang('site.sale_price')</label>
                                <input type="text" name="sale_price" class="form-control " step="0.01" id="sale_price" value="{{old('sale_price')}}" >
                            </div>
                            <div class="form-group">
                                <label for="stock">@lang('site.stock')</label>
                                <input type="text" name="stock" class="form-control " id="stock" value="{{old('stock')}}">
                            </div>
                        </div>

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
