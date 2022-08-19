@extends('frontend.layouts.app')

@section('content')

    @if($flash_deal->status == 1 && strtotime(date('d-m-Y')) <= $flash_deal->end_date)
    <div style="background-color:{{ $flash_deal->background_color }}">
        <section class="text-center">
            <img src="{{ asset($flash_deal->banner) }}" alt="{{ $flash_deal->title }}" class="img-fit w-100">
        </section>
        <section class="pb-4">
            <div class="container">
                <div class="text-center my-4 text-{{ $flash_deal->text_color }}">
                    <h1 class="h3">{{ $flash_deal->title }}</h1>
                    <div class="countdown countdown-sm countdown--style-1" data-countdown-date="{{ date('m/d/Y', $flash_deal->end_date) }}" data-countdown-label="show"></div>
                </div>
                <div class="gutters-5 row">
                    @foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product)
                        @php
                            $product = \App\Product::find($flash_deal_product->product_id);
                        @endphp
                        @if ($product->published != 0)
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="product-card-2 card card-product shop-cards shop-tech mb-2">
                                    <div class="card-body p-0">

                                        <div class="card-image">
                                            <a href="{{ route('product', $product->slug) }}" class="d-block text-center" >
                                                <img class="img-fit lazyload" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($product->flash_deal_img) }}" alt="{{ __($product->name) }}">
                                            </a>
                                        </div>

                                        <div class="p-3">
                                            <div class="price-box">
                                                @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                    <del class="old-product-price strong-400">{{ home_base_price($product->id) }}</del>
                                                @endif
                                                <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>
                                            </div>
                                            <h2 class="product-title p-0 mt-2">
                                                <a href="{{ route('product', $product->slug) }}" class="text-truncate">{{ __($product->name) }}</a>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    @else
        <div style="background-color:{{ $flash_deal->background_color }}">
            <section class="text-center pt-3">
                <div class="container ">
                    <img src="{{ asset($flash_deal->banner) }}" alt="{{ $flash_deal->title }}" class="img-fit">
                </div>
            </section>
            <section class="pb-4">
                <div class="container">
                    <div class="text-center text-{{ $flash_deal->text_color }}">
                        <h1 class="h3 my-4">{{ $flash_deal->title }}</h1>
                        <p class="h4">{{ __('This offer has been expired.') }}</p>
                    </div>
                </div>
            </section>
        </div>
    @endif
@endsection
