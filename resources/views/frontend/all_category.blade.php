@extends('frontend.layouts.app')

@section('content')

<div class="all-category-wrap py-4 gry-bg">
    <div class="sticky-top">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="bg-white all-category-menu">
                        <ul class="clearfix no-scrollbar">
                            @if(count($categories) > 12)
                                @for ($i = 0; $i < 11; $i++)
                                    <li class="@php if($i == 0) echo 'active' @endphp">
                                        <a href="#{{ $i }}" class="row no-gutters align-items-center">
                                            <div class="col-md-3">
                                                <img loading="lazy"  class="cat-image" src="{{ asset($categories[$i]->icon) }}">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="cat-name">{{ $categories[$i]->name }}</div>
                                            </div>
                                        </a>
                                    </li>
                                @endfor
                                <li class="">
                                    <a href="#more" class="row no-gutters align-items-center">
                                        <div class="col-md-3">
                                            <i class="fa fa-ellipsis-h cat-icon"></i>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="cat-name">{{__('More Categories')}}</div>
                                        </div>
                                    </a>
                                </li>
                            @else
                                @foreach ($categories as $key => $category)
                                    <li class="@php if($key == 0) echo 'active' @endphp">
                                        <a href="#{{ $key }}" class="row no-gutters align-items-center">
                                            <div class="col-md-3">
                                                <img loading="lazy"  class="cat-image" src="{{ asset($category->icon) }}">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="cat-name">{{ __($category->name) }}</div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div class="container">
            @foreach ($categories as $key => $category)
                @if(count($categories)>12 && $key == 11)
                <div class="mb-3 bg-white">
                    <div class="sub-category-menu active" id="more">
                        <h3 class="category-name border-bottom pb-2"><a href="{{ route('products.category', $category->slug) }}">{{ __($category->name) }}</a></h3>
                        <div class="row">
                            @foreach ($category->subcategories as $key => $subcategory)
                            <div class="col-lg-4 col-6">
                                <h6 class="mb-3"><a href="{{ route('products.subcategory', $subcategory->slug) }}">{{ __($subcategory->name) }}</a></h6>
                                <ul class="mb-3">
                                    @foreach ($subcategory->subsubcategories as $key => $subsubcategory)
                                    <li class="w-100"><a href="{{ route('products.subsubcategory', $subsubcategory->slug) }}" >{{ __($subsubcategory->name) }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <div class="mb-3 bg-white">
                    <div class="sub-category-menu @php if($key < 12) echo 'active'; @endphp" id="{{ $key }}">
                        <h3 class="category-name border-bottom pb-2"><a href="{{ route('products.category', $category->slug) }}" >{{ __($category->name) }}</a></h3>
                        <div class="row">
                            @foreach ($category->subcategories as $key => $subcategory)
                            <div class="col-lg-4 col-6">
                                <h6 class="mb-3"><a href="{{ route('products.subcategory', $subcategory->slug) }}">{{ __($subcategory->name) }}</a></h6>
                                <ul class="mb-3">
                                    @foreach ($subcategory->subsubcategories as $key => $subsubcategory)
                                    <li class="w-100"><a href="{{ route('products.subsubcategory', $subsubcategory->slug) }}" >{{ __($subsubcategory->name) }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

@endsection
