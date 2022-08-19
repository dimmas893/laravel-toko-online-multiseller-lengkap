@extends('frontend.layouts.app')

@section('content')
    @php
        $status = $order->orderDetails->first()->delivery_status;
    @endphp
    <div id="page-content">
        <section class="slice-xs sct-color-2 border-bottom">
            <div class="container container-sm">
                <div class="row cols-delimited justify-content-center">
                    <div class="col">
                        <div class="icon-block icon-block--style-1-v5 text-center ">
                            <div class="block-icon c-gray-light mb-0">
                                <i class="la la-shopping-cart"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">1. {{__('My Cart')}}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="icon-block icon-block--style-1-v5 text-center ">
                            <div class="block-icon mb-0 c-gray-light">
                                <i class="la la-map-o"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">2. {{__('Shipping info')}}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="icon-block icon-block--style-1-v5 text-center ">
                            <div class="block-icon mb-0 c-gray-light">
                                <i class="la la-truck"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">3. {{__('Delivery info')}}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="icon-block icon-block--style-1-v5 text-center ">
                            <div class="block-icon mb-0 c-gray-light">
                                <i class="la la-credit-card"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">4. {{__('Payment')}}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="icon-block icon-block--style-1-v5 text-center active">
                            <div class="block-icon mb-0">
                                <i class="la la-check-circle"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">5. {{__('Confirmation')}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center py-4 border-bottom mb-4">
                                    <i class="la la-check-circle la-3x text-success mb-3"></i>
                                    <h1 class="h3 mb-3">{{__('Thank You for Your Order!')}}</h1>
                                    <h2 class="h5 strong-700">{{__('Order Code:')}} {{ $order->code }}</h2>
                                    @if ($order->user_id != null)
                                        <p class="text-muted text-italic">{{ __('A copy or your order summary has been sent to') }} {{ $order->user->email }}</p>
                                    @endif
                                </div>
                                <div class="mb-4">
                                    <h5 class="strong-600 mb-3 border-bottom pb-2">{{__('Order Summary')}}</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="details-table table">
                                                <tr>
                                                    <td class="w-50 strong-600">{{__('Order Code')}}:</td>
                                                    <td>{{ $order->code }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 strong-600">{{__('Name')}}:</td>
                                                    <td>{{ json_decode($order->shipping_address)->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 strong-600">{{__('Email')}}:</td>
                                                    @if ($order->user_id != null)
                                                        <td>{{ $order->user->email }}</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td class="w-50 strong-600">{{__('Shipping address')}}:</td>
                                                    <td>{{ json_decode($order->shipping_address)->address }}, {{ json_decode($order->shipping_address)->city }}, {{ json_decode($order->shipping_address)->country }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="details-table table">
                                                <tr>
                                                    <td class="w-50 strong-600">{{__('Order date')}}:</td>
                                                    <td>{{ date('d-m-Y H:m A', $order->date) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 strong-600">{{__('Order status')}}:</td>
                                                    <td>{{ ucfirst(str_replace('_', ' ', $status)) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 strong-600">{{__('Total order amount')}}:</td>
                                                    <td>{{ single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax')) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 strong-600">{{__('Shipping')}}:</td>
                                                    <td>{{__('Flat shipping rate')}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 strong-600">{{__('Payment method')}}:</td>
                                                    <td>{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="strong-600 mb-3 border-bottom pb-2">{{__('Order Details')}}</h5>
                                    <div>
                                        <table class="details-table table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th width="30%">{{__('Product')}}</th>
                                                    <th>{{__('Variation')}}</th>
                                                    <th>{{__('Quantity')}}</th>
                                                    <th>{{__('Delivery Type')}}</th>
                                                    <th class="text-right">{{__('Price')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->orderDetails as $key => $orderDetail)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>
                                                            @if ($orderDetail->product != null)
                                                                <a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank">
                                                                    {{ $orderDetail->product->name }}
                                                                </a>
                                                            @else
                                                                <strong>{{ __('Product Unavailable') }}</strong>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $orderDetail->variation }}
                                                        </td>
                                                        <td>
                                                            {{ $orderDetail->quantity }}
                                                        </td>
                                                        <td>
                                                            @if ($orderDetail->shipping_type != null && $orderDetail->shipping_type == 'home_delivery')
                                                                {{ __('Home Delivery') }}
                                                            @elseif ($orderDetail->shipping_type == 'pickup_point')
                                                                @if ($orderDetail->pickup_point != null)
                                                                    {{ $orderDetail->pickup_point->name }} ({{ __('Pickip Point') }})
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-right">{{ single_price($orderDetail->price) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-5 col-md-6 ml-auto">
                                            <table class="table details-table">
                                                <tbody>
                                                    <tr>
                                                        <th>{{__('Subtotal')}}</th>
                                                        <td class="text-right">
                                                            <span class="strong-600">{{ single_price($order->orderDetails->sum('price')) }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{__('Shipping')}}</th>
                                                        <td class="text-right">
                                                            <span class="text-italic">{{ single_price($order->orderDetails->sum('shipping_cost')) }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{__('Tax')}}</th>
                                                        <td class="text-right">
                                                            <span class="text-italic">{{ single_price($order->orderDetails->sum('tax')) }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{__('Coupon Discount')}}</th>
                                                        <td class="text-right">
                                                            <span class="text-italic">{{ single_price($order->coupon_discount) }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><span class="strong-600">{{__('Total')}}</span></th>
                                                        <td class="text-right">
                                                            <strong><span>{{ single_price($order->grand_total) }}</span></strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
