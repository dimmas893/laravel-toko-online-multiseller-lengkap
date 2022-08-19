@if (\App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
    @php
        $array = array();
        foreach (\App\Seller::where('verification_status', 1)->get() as $key => $seller) {
            if($seller->user != null && $seller->user->shop != null){
                $total_sale = 0;
                foreach ($seller->user->products as $key => $product) {
                    $total_sale += $product->num_of_sale;
                }
                $array[$seller->id] = $total_sale;
            }
        }
        asort($array);
    @endphp
    @if(!empty($array))
        <section class="mb-5">
        <div class="container">
            <div class="px-2 py-4 p-md-4 bg-white shadow-sm">
                <div class="section-title-1 clearfix">
                    <h3 class="heading-5 strong-700 mb-0 float-left">
                        <span class="mr-4">{{__('Best Sellers')}}</span>
                    </h3>
                    <ul class="inline-links float-right">
                        <li><a  class="active">{{__('Top 20')}}</a></li>
                    </ul>
                </div>
                <div class="caorusel-box arrow-round gutters-5">
                    <div class="slick-carousel" data-slick-items="3" data-slick-lg-items="3"  data-slick-md-items="2" data-slick-sm-items="2" data-slick-xs-items="1" data-slick-rows="2">
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($array as $key => $value)
                            @if ($count < 20)
                                @php
                                    $count ++;
                                    $seller = \App\Seller::find($key);
                                    $total = 0;
                                    $rating = 0;
                                    foreach ($seller->user->products as $key => $seller_product) {
                                        $total += $seller_product->reviews->count();
                                        $rating += $seller_product->reviews->sum('rating');
                                    }
                                @endphp
                                <div class="caorusel-card my-1">
                                    <div class="row no-gutters box-3 align-items-center border">
                                        <div class="col-4">
                                            <a href="{{ route('shop.visit', $seller->user->shop->slug) }}" class="d-block product-image p-3">
                                                <img
                                                    src="{{ asset('frontend/images/placeholder.jpg') }}"
                                                    data-src="@if ($seller->user->shop->logo !== null) {{ asset($seller->user->shop->logo) }} @else {{ asset('frontend/images/placeholder.jpg') }} @endif"
                                                    alt="{{ $seller->user->shop->name }}"
                                                    class="img-fluid lazyload"
                                                >
                                            </a>
                                        </div>
                                        <div class="col-8 border-left">
                                            <div class="p-3">
                                                <h2 class="product-title mb-0 p-0 text-truncate">
                                                    <a href="{{ route('shop.visit', $seller->user->shop->slug) }}">{{ __($seller->user->shop->name) }}</a>
                                                </h2>
                                                <div class="star-rating star-rating-sm mb-2">
                                                    @if ($total > 0)
                                                        {{ renderStarRating($rating/$total) }}
                                                    @else
                                                        {{ renderStarRating(0) }}
                                                    @endif
                                                </div>
                                                <div class="">
                                                    <a href="{{ route('shop.visit', $seller->user->shop->slug) }}" class="icon-anim">
                                                        {{ __('Visit Store') }} <i class="la la-angle-right text-sm"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
@endif
