@extends('frontend.layouts.app')

@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @include('frontend.inc.seller_side_nav')
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        {{__('Shop Settings')}}
                                        <a href="{{ route('shop.visit', $shop->slug) }}" class="btn btn-link btn-sm" target="_blank">({{__('Visit Shop')}})<i class="la la-external-link"></i>)</a>
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li class="active"><a href="{{ route('shops.index') }}">{{__('Shop Settings')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="" action="{{ route('shops.update', $shop->id) }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PATCH">
                            @csrf
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Basic info')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Shop Name')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" placeholder="{{__('Shop Name')}}" name="name" value="{{ $shop->name }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-2">
                                            <label>{{__('Pickup Points')}} <span class="required-star"></span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control mb-3 selectpicker" data-placeholder="Select Pickup Point" id="pick_up_point" name="pick_up_point_id[]" multiple>
                                                @foreach (\App\PickupPoint::all() as $pick_up_point)
                                                    @if (Auth::user()->shop->pick_up_point_id != null)
                                                        <option value="{{ $pick_up_point->id }}" @if (in_array($pick_up_point->id, json_decode(Auth::user()->shop->pick_up_point_id))) selected @endif>{{ $pick_up_point->name }}</option>
                                                    @else
                                                        <option value="{{ $pick_up_point->id }}">{{ $pick_up_point->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Logo')}} <small>(120x120)</small></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="file" name="logo" id="file-2" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                            <label for="file-2" class="mw-100 mb-3">
                                                <span></span>
                                                <strong>
                                                    <i class="fa fa-upload"></i>
                                                    {{__('Choose image')}}
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Address')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" placeholder="{{__('Address')}}" name="address" value="{{ $shop->address }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Meta Title')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" placeholder="{{__('Meta Title')}}" name="meta_title" value="{{ $shop->meta_title }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Meta Description')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <textarea name="meta_description" rows="6" class="form-control mb-3" required>{{ $shop->meta_description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-styled btn-base-1">{{__('Save')}}</button>
                            </div>
                        </form>

                        <form class="" action="{{ route('shops.update', $shop->id) }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PATCH">
                            @csrf
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Slider Settings')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div id="shop-slider-images">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('Slider Images')}} <small>(1400x400)</small></label>
                                            </div>
                                            <div class="offset-2 offset-md-0 col-10 col-md-10">
                                                <div class="row">
                                                    @if ($shop->sliders != null)
                                                        @foreach (json_decode($shop->sliders) as $key => $sliders)
                                                            <div class="col-md-6">
                                                                <div class="img-upload-preview">
                                                                    <img loading="lazy"  src="{{ asset($sliders) }}" alt="" class="img-fluid">
                                                                    <input type="hidden" name="previous_sliders[]" value="{{ $sliders }}">
                                                                    <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <input type="file" name="sliders[]" id="slide-0" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" multiple accept="image/*" />
                                                <label for="slide-0" class="mw-100 mb-3">
                                                    <span></span>
                                                    <strong>
                                                        <i class="fa fa-upload"></i>
                                                        {{__('Choose image')}}
                                                    </strong>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-info mb-3" onclick="add_more_slider_image()">{{ __('Add More') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-styled btn-base-1">{{__('Save')}}</button>
                            </div>
                        </form>

                        <form class="" action="{{ route('shops.update', $shop->id) }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PATCH">
                            @csrf
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Social Media Link')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label ><i class="line-height-1_8 size-24 mr-2 fa fa-facebook bg-facebook c-white text-center"></i>{{__('Facebook')}} </label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" placeholder="{{__('Facebook')}}" name="facebook" value="{{ $shop->facebook }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label><i class="line-height-1_8 size-24 mr-2 fa fa-twitter bg-twitter c-white text-center"></i>{{__('Twitter')}} </label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" placeholder="{{__('Twitter')}}" name="twitter" value="{{ $shop->twitter }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label><i class="line-height-1_8 size-24 mr-2 fa fa-google bg-google c-white text-center"></i>{{__('Google')}} </label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" placeholder="{{__('Google')}}" name="google" value="{{ $shop->google }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label><i class="line-height-1_8 size-24 mr-2 fa fa-youtube bg-youtube c-white text-center"></i>{{__('Youtube')}} </label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" placeholder="{{__('Youtube')}}" name="youtube" value="{{ $shop->youtube }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-styled btn-base-1">{{__('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>
        var slide_id = 1;
        function add_more_slider_image(){
            var shopSliderAdd =  '<div class="row">';
            shopSliderAdd +=  '<div class="col-2">';
            shopSliderAdd +=  '<button type="button" onclick="delete_this_row(this)" class="btn btn-link btn-icon text-danger"><i class="fa fa-trash-o"></i></button>';
            shopSliderAdd +=  '</div>';
            shopSliderAdd +=  '<div class="col-10">';
            shopSliderAdd +=  '<input type="file" name="sliders[]" id="slide-'+slide_id+'" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" multiple accept="image/*" />';
            shopSliderAdd +=  '<label for="slide-'+slide_id+'" class="mw-100 mb-3">';
            shopSliderAdd +=  '<span></span>';
            shopSliderAdd +=  '<strong>';
            shopSliderAdd +=  '<i class="fa fa-upload"></i>';
            shopSliderAdd +=  "{{__('Choose image')}}";
            shopSliderAdd +=  '</strong>';
            shopSliderAdd +=  '</label>';
            shopSliderAdd +=  '</div>';
            shopSliderAdd +=  '</div>';
            $('#shop-slider-images').append(shopSliderAdd);

            slide_id++;
            imageInputInitialize();
        }
        function delete_this_row(em){
            $(em).closest('.row').remove();
        }


        $(document).ready(function(){
            $('.remove-files').on('click', function(){
                $(this).parents(".col-md-6").remove();
            });
        });
    </script>
@endsection
