@extends('frontend.layouts.app')

@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @include('frontend.inc.customer_side_nav')
                </div>
                <div class="col-lg-9">
                    <!-- Page title -->
                    <div class="page-title">
                        <div class="row align-items-center">
                            <div class="col-md-6 col-12">
                                <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                    {{__('Dashboard')}}
                                </h2>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="float-md-right">
                                    <ul class="breadcrumb">
                                        <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                        <li class="active"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- dashboard content -->
                    <div class="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="dashboard-widget text-center green-widget mt-4 c-pointer">
                                    <a href="javascript:;" class="d-block">
                                        <i class="fa fa-shopping-cart"></i>
                                        @if(Session::has('cart'))
                                            <span class="d-block title">{{ count(Session::get('cart'))}} {{__('Product(s)')}}</span>
                                        @else
                                            <span class="d-block title">0 {{__('Product')}}</span>
                                        @endif
                                        <span class="d-block sub-title">{{__('in your cart')}}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dashboard-widget text-center red-widget mt-4 c-pointer">
                                    <a href="javascript:;" class="d-block">
                                        <i class="fa fa-heart"></i>
                                        <span class="d-block title">{{ count(Auth::user()->wishlists)}} {{__('Product(s)')}}</span>
                                        <span class="d-block sub-title">{{__('in your wishlist')}}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dashboard-widget text-center yellow-widget mt-4 c-pointer">
                                    <a href="javascript:;" class="d-block">
                                        <i class="fa fa-building"></i>
                                        @php
                                            $orders = \App\Order::where('user_id', Auth::user()->id)->get();
                                            $total = 0;
                                            foreach ($orders as $key => $order) {
                                                $total += count($order->orderDetails);
                                            }
                                        @endphp
                                        <span class="d-block title">{{ $total }} {{__('Product(s)')}}</span>
                                        <span class="d-block sub-title">{{__('you ordered')}}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-box bg-white mt-4">
                                    <div class="form-box-title px-3 py-2 clearfix ">
                                        {{__('Saved Shipping Info')}}
                                        <div class="float-right">
                                            <a href="{{ route('profile') }}" class="btn btn-link btn-sm">{{__('Edit')}}</a>
                                        </div>
                                    </div>
                                    <div class="form-box-content p-3">
                                        <table>
                                            <tr>
                                                <td>{{__('Address')}}:</td>
                                                <td class="p-2">{{ Auth::user()->address }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Country')}}:</td>
                                                <td class="p-2">
                                                    @if (Auth::user()->country != null)
                                                        {{ \App\Country::where('code', Auth::user()->country)->first()->name }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{__('City')}}:</td>
                                                <td class="p-2">{{ Auth::user()->city }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Postal Code')}}:</td>
                                                <td class="p-2">{{ Auth::user()->postal_code }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Phone')}}:</td>
                                                <td class="p-2">{{ Auth::user()->phone }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-box bg-white mt-4">
                                    <div class="form-box-title px-3 py-2 clearfix ">
                                        {{__('Purchased Package')}}
                                    </div>
                                    @php
                                        $customer_package = \App\CustomerPackage::find(Auth::user()->customer_package_id);
                                    @endphp
                                    <div class="form-box-content p-3">
                                        @if($customer_package != null)
                                            <div class="form-box-content p-2 category-widget text-center">
                                                <center><img alt="Package Logo" src="{{ asset($customer_package->logo) }}" style="height:100px; width:90px;"></center>
                                                <left> <strong><p>{{__('Product Upload')}}: {{ $customer_package->product_upload }} {{__('Times')}}</p></strong></left>
                                                <strong><p>{{__('Product Upload Remaining')}}: {{ Auth::user()->remaining_uploads }} {{__('Times')}}</p></strong>
                                                <strong><p><div class="name mb-0">{{__('Current Package')}}: {{ $customer_package->name }} <span class="ml-2"><i class="fa fa-check-circle" style="color:green"></i></span></div></p></strong>
                                            </div>
                                        @else
                                            <div class="form-box-content p-2 category-widget text-center">
                                                <center><strong><p>{{__('Package Removed')}}</p></strong></center>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
