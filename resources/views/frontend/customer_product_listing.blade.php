@extends('frontend.layouts.app')

@if(isset($subsubcategory_id))
    @php
        $meta_title = \App\SubSubCategory::find($subsubcategory_id)->meta_title;
        $meta_description = \App\SubSubCategory::find($subsubcategory_id)->meta_description;
    @endphp
@elseif (isset($subcategory_id))
    @php
        $meta_title = \App\SubCategory::find($subcategory_id)->meta_title;
        $meta_description = \App\SubCategory::find($subcategory_id)->meta_description;
    @endphp
@elseif (isset($category_id))
    @php
        $meta_title = \App\Category::find($category_id)->meta_title;
        $meta_description = \App\Category::find($category_id)->meta_description;
    @endphp
@elseif (isset($brand_id))
    @php
        $meta_title = \App\Brand::find($brand_id)->meta_title;
        $meta_description = \App\Brand::find($brand_id)->meta_description;
    @endphp
@else
    @php
        $meta_title = env('APP_NAME');
        $meta_description = \App\SeoSetting::first()->description;
    @endphp
@endif

@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $meta_title }}">
    <meta itemprop="description" content="{{ $meta_description }}">

    <!-- Twitter Card data -->
    <meta name="twitter:title" content="{{ $meta_title }}">
    <meta name="twitter:description" content="{{ $meta_description }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:description" content="{{ $meta_description }}" />
@endsection

@section('content')

    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col">
                    <ul class="breadcrumb">
                        <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                        <li><a href="{{ route('customer.products') }}">{{__('All Categories')}}</a></li>
                        @if(isset($category_id))
                            <li class="active"><a href="{{ route('customer_products.category', \App\Category::find($category_id)->slug) }}">{{ \App\Category::find($category_id)->name }}</a></li>
                        @endif
                        @if(isset($subcategory_id))
                            <li ><a href="{{ route('products.category', \App\SubCategory::find($subcategory_id)->category->slug) }}">{{ \App\SubCategory::find($subcategory_id)->category->name }}</a></li>
                            <li class="active"><a href="{{ route('customer_products.subcategory', \App\SubCategory::find($subcategory_id)->slug) }}">{{ \App\SubCategory::find($subcategory_id)->name }}</a></li>
                        @endif
                        @if(isset($subsubcategory_id))
                            <li ><a href="{{ route('customer_products.category', \App\SubSubCategory::find($subsubcategory_id)->subcategory->category->slug) }}">{{ \App\SubSubCategory::find($subsubcategory_id)->subcategory->category->name }}</a></li>
                            <li ><a href="{{ route('customer_products.subcategory', \App\SubsubCategory::find($subsubcategory_id)->subcategory->slug) }}">{{ \App\SubsubCategory::find($subsubcategory_id)->subcategory->name }}</a></li>
                            <li class="active"><a href="{{ route('customer_products.subsubcategory', \App\SubSubCategory::find($subsubcategory_id)->slug) }}">{{ \App\SubSubCategory::find($subsubcategory_id)->name }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <section class="gry-bg py-4">
        <div class="container sm-px-0">
            <form class="" id="search-form" action="" method="GET">
                <div class="row">
                <div class="col-xl-3 side-filter d-xl-block">
                    <div class="filter-overlay filter-close"></div>
                    <div class="filter-wrapper c-scrollbar">
                        <div class="filter-title d-flex d-xl-none justify-content-between pb-3 align-items-center">
                            <h3 class="h6">Filters</h3>
                            <button type="button" class="close filter-close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="bg-white sidebar-box mb-3">
                            <div class="box-title text-center">
                                {{__('Categories')}}
                            </div>
                            <div class="box-content">
                                <div class="category-filter">
                                    <ul>
                                        @if(!isset($category_id) && !isset($subcategory_id) && !isset($subsubcategory_id))
                                            @foreach(\App\Category::all() as $category)
                                                <li class=""><a href="{{ route('customer_products.category', $category->slug) }}">{{ __($category->name) }} ({{ count($category->classified_products) }})</a></li>
                                            @endforeach
                                        @endif
                                        @if(isset($category_id))
                                            <li class="active"><a href="{{ route('customer.products') }}">{{__('All Categories')}}</a></li>
                                            <li class="active"><a href="{{ route('customer_products.category', \App\Category::find($category_id)->slug) }}">{{ __(\App\Category::find($category_id)->name) }}</a></li>
                                            @foreach (\App\Category::find($category_id)->subcategories as $key2 => $subcategory)
                                                <li class="child"><a href="{{ route('customer_products.subcategory', $subcategory->slug) }}">{{ __($subcategory->name) }} ({{ count($subcategory->classified_products) }})</a></li>
                                            @endforeach
                                        @endif
                                        @if(isset($subcategory_id))
                                            <li class="active"><a href="{{ route('customer.products') }}">{{__('All Categories')}}</a></li>
                                            <li class="active"><a href="{{ route('customer_products.category', \App\SubCategory::find($subcategory_id)->category->slug) }}">{{ __(\App\SubCategory::find($subcategory_id)->category->name) }}</a></li>
                                            <li class="active"><a href="{{ route('customer_products.subcategory', \App\SubCategory::find($subcategory_id)->slug) }}">{{ __(\App\SubCategory::find($subcategory_id)->name) }}</a></li>
                                            @foreach (\App\SubCategory::find($subcategory_id)->subsubcategories as $key3 => $subsubcategory)
                                                <li class="child"><a href="{{ route('customer_products.subsubcategory', $subsubcategory->slug) }}">{{ __($subsubcategory->name) }} ({{ count($subsubcategory->classified_products) }})</a></li>
                                            @endforeach
                                        @endif
                                        @if(isset($subsubcategory_id))
                                            <li class="active"><a href="{{ route('customer.products') }}">{{__('All Categories')}}</a></li>
                                            <li class="active"><a href="{{ route('customer_products.category', \App\SubsubCategory::find($subsubcategory_id)->subcategory->category->slug) }}">{{ __(\App\SubSubCategory::find($subsubcategory_id)->subcategory->category->name) }}</a></li>
                                            <li class="active"><a href="{{ route('customer_products.subcategory', \App\SubsubCategory::find($subsubcategory_id)->subcategory->slug) }}">{{ __(\App\SubsubCategory::find($subsubcategory_id)->subcategory->name) }}</a></li>
                                            <li class="current"><a href="{{ route('customer_products.subsubcategory', \App\SubsubCategory::find($subsubcategory_id)->slug) }}">{{ __(\App\SubsubCategory::find($subsubcategory_id)->name) }} ({{ count(\App\SubsubCategory::find($subsubcategory_id)->classified_products) }})</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <!-- <div class="bg-white"> -->
                        @isset($category_id)
                            <input type="hidden" name="category" value="{{ \App\Category::find($category_id)->slug }}">
                        @endisset
                        @isset($subcategory_id)
                            <input type="hidden" name="subcategory" value="{{ \App\SubCategory::find($subcategory_id)->slug }}">
                        @endisset
                        @isset($subsubcategory_id)
                            <input type="hidden" name="subsubcategory" value="{{ \App\SubSubCategory::find($subsubcategory_id)->slug }}">
                        @endisset
                        <div class="sort-by-bar row no-gutters bg-white mb-3 px-3 pt-2">
                            <div class="col-xl-4 d-flex d-xl-block justify-content-between align-items-end ">
                                <div class="sort-by-box flex-grow-1">
                                    <div class="form-group">
                                        <label>{{__('Search')}}</label>
                                        <div class="search-widget">
                                            <input class="form-control input-lg" type="text" name="q" placeholder="{{__('Search products')}}" @isset($query) value="{{ $query }}" @endisset>
                                            <button type="submit" class="btn-inner">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-xl-none ml-3 form-group">
                                    <button type="button" class="btn p-1 btn-sm" id="side-filter">
                                        <i class="la la-filter la-2x"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-xl-7 offset-xl-1">
                                <div class="row no-gutters">
                                    <div class="col-4">
                                        <div class="sort-by-box px-1">
                                            <div class="form-group">
                                                <label>{{__('Sort by')}}</label>
                                                <select class="form-control sortSelect" data-minimum-results-for-search="Infinity" name="sort_by" onchange="filter()">
                                                    <option value="1" @isset($sort_by) @if ($sort_by == '1') selected @endif @endisset>{{__('Newest')}}</option>
                                                    <option value="2" @isset($sort_by) @if ($sort_by == '2') selected @endif @endisset>{{__('Oldest')}}</option>
                                                    <option value="3" @isset($sort_by) @if ($sort_by == '3') selected @endif @endisset>{{__('Price low to high')}}</option>
                                                    <option value="4" @isset($sort_by) @if ($sort_by == '4') selected @endif @endisset>{{__('Price high to low')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="sort-by-box px-1">
                                            <div class="form-group">
                                                <label>{{__('Condition')}}</label>
                                                <select class="form-control sortSelect" data-minimum-results-for-search="Infinity" name="condition" onchange="filter()">
                                                    <option value="">{{__('All Type')}}</option>
                                                    <option value="new" @isset($condition) @if ($condition == 'new') selected @endif @endisset>{{__('New')}}</option>
                                                    <option value="used" @isset($condition) @if ($condition == 'used') selected @endif @endisset>{{__('Used')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="sort-by-box px-1">
                                            <div class="form-group">
                                                <label>{{__('Brands')}}</label>
                                                <select class="form-control sortSelect" data-placeholder="{{__('All Brands')}}" name="brand" onchange="filter()">
                                                    <option value="">{{__('All Brands')}}</option>
                                                    @foreach (\App\Brand::all() as $brand)
                                                        <option value="{{ $brand->slug }}" @isset($brand_id) @if ($brand_id == $brand->id) selected @endif @endisset>{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class=""> -->
                        <div class="products-box-bar p-3 bg-white">
                            <div class="row sm-no-gutters gutters-5">
                                @foreach ($customer_products as $key => $product)
                                    <div class="col-xxl-3 col-xl-4 col-lg-3 col-md-4 col-6">
                                        <div class="product-box-2 bg-white alt-box my-md-2">
                                            <div class="position-relative overflow-hidden">
                                                <a href="{{ route('customer.product', $product->slug) }}" class="d-block product-image h-100 text-center" tabindex="0">
                                                    <img class="img-fit lazyload" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($product->thumbnail_img) }}" alt="{{ __($product->name) }}">
                                                </a>
                                            </div>
                                            <div class="p-md-3 p-2">
                                                <div class="price-box">
                                                    <span class="product-price strong-600">{{ single_price($product->unit_price) }}</span>
                                                </div>
                                                <h2 class="product-title p-0">
                                                    <a href="{{ route('customer.product', $product->slug) }}" class=" text-truncate">{{ __($product->name) }}</a>
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="products-pagination bg-white p-3">
                            <nav aria-label="Center aligned pagination">
                                <ul class="pagination justify-content-center">
                                    {{ $customer_products->links() }}
                                </ul>
                            </nav>
                        </div>

                    <!-- </div> -->
                </div>
            </div>
            </form>
        </div>
    </section>

@endsection

@section('script')
    <script type="text/javascript">
        function filter(){
            $('#search-form').submit();
        }
    </script>
@endsection
