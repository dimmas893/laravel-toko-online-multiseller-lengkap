@foreach (\App\HomeCategory::where('status', 1)->get() as $key => $homeCategory)
    <section class="mb-4">
        <div class="container">
            <div class="px-2 py-4 p-md-4 bg-white shadow-sm">
                <div class="section-title-1 clearfix">
                    <h3 class="heading-5 strong-700 mb-0 float-lg-left">
                        <span class="mr-4">{{ __($homeCategory->category->name) }}</span>
                    </h3>
                    <ul class="inline-links float-lg-right nav mt-3 mb-2 m-lg-0">
                        @foreach (json_decode($homeCategory->subsubcategories) as $key => $subsubcategory)
                            @if (\App\SubSubCategory::find($subsubcategory) != null)
                                <li class="@php if($key == 0) echo 'active'; @endphp">
                                    <a href="#subsubcat-{{ $subsubcategory }}" data-toggle="tab" class="d-block @php if($key == 0) echo 'active'; @endphp">{{ __(\App\SubSubCategory::find($subsubcategory)->name) }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="tab-content">
                    @foreach (json_decode($homeCategory->subsubcategories) as $key => $subsubcategory)
                        @if (\App\SubSubCategory::find($subsubcategory) != null)
                        <div class="tab-pane fade @php if($key == 0) echo 'show active'; @endphp" id="subsubcat-{{ $subsubcategory }}">
                            <div class="row gutters-5 sm-no-gutters">
                                @foreach (filter_products(\App\Product::where('published', 1)->where('subsubcategory_id', $subsubcategory))->limit(6)->get() as $key => $product)
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="product-box-2 bg-white alt-box my-2">
                                            <div class="position-relative overflow-hidden">
                                                <a href="{{ route('product', $product->slug) }}" class="d-block product-image h-100 text-center">
                                                    <img class="img-fit lazyload" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($product->thumbnail_img) }}" alt="{{ __($product->name) }}">
                                                </a>
                                                <div class="product-btns clearfix">
                                                    <button class="btn add-wishlist" title="Add to Wishlist" onclick="addToWishList({{ $product->id }})" tabindex="0">
                                                        <i class="la la-heart-o"></i>
                                                    </button>
                                                    <button class="btn add-compare" title="Add to Compare" onclick="addToCompare({{ $product->id }})" tabindex="0">
                                                        <i class="la la-refresh"></i>
                                                    </button>
                                                    <button class="btn quick-view" title="Quick view" onclick="showAddToCartModal({{ $product->id }})" tabindex="0">
                                                        <i class="la la-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="p-md-3 p-2">
                                                <div class="price-box">
                                                    @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                        <del class="old-product-price strong-400">{{ home_base_price($product->id) }}</del>
                                                    @endif
                                                    <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>
                                                </div>
                                                <div class="star-rating star-rating-sm mt-1">
                                                    {{ renderStarRating($product->rating) }}
                                                </div>
                                                <h2 class="product-title p-0">
                                                    <a href="{{ route('product', $product->slug) }}" class=" text-truncate">{{ __($product->name) }}</a>
                                                </h2>
                                                @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                                                    <div class="club-point mt-2 bg-soft-base-1 border-light-base-1 border">
                                                        {{ __('Club Point') }}:
                                                        <span class="strong-700 float-right">{{ $product->earn_point }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endforeach
