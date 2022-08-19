@extends('frontend.layouts.app')

@section('content')

    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col">
                    <ul class="breadcrumb">
                        <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                        <li class="active"><a href="{{ route('compare') }}">{{__('Compare')}}</a></li>
                    </ul>
                </div>
                <div class="col">
                    <div class="text-right">
                        <a href="{{ route('compare.reset') }}" style="text-decoration: none;" class="btn btn-link btn-base-5 btn-sm">{{__('Reset Compare List')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="gry-bg py-4">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card mb-4">
                        <div class="card-header text-center p-2">
                            <div class="heading-5">{{__('Comparison')}}</div>
                        </div>
                        @if(Session::has('compare'))
                            @if(count(Session::get('compare')) > 0)
                                <div class="card-body">
                                    <table class="table table-bordered compare-table mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width:16%" class="font-weight-bold">
                                                    {{__('Name')}}
                                                </th>
                                                @foreach (Session::get('compare') as $key => $item)
                                                    <th scope="col" style="width:28%" class="font-weight-bold">
                                                        <a href="{{ route('product', \App\Product::find($item)->slug) }}">{{ \App\Product::find($item)->name }}</a>
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">{{__('Image')}}</th>
                                                @foreach (Session::get('compare') as $key => $item)
                                                    <td>
                                                        <img loading="lazy"  src="{{ asset(\App\Product::find($item)->thumbnail_img) }}" alt="Product Image" class="img-fluid py-4">
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th scope="row">{{__('Price')}}</th>
                                                @foreach (Session::get('compare') as $key => $item)
                                                    <td>{{ single_price(\App\Product::find($item)->unit_price) }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th scope="row">{{__('Brand')}}</th>
                                                @foreach (Session::get('compare') as $key => $item)
                                                    <td>
                                                        @if (\App\Product::find($item)->brand != null)
                                                            {{ \App\Product::find($item)->brand->name }}
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th scope="row">{{__('Sub Sub Category')}}</th>
                                                @foreach (Session::get('compare') as $key => $item)
                                                    <td>
                                                        @if (\App\Product::find($item)->subsubcategory != null)
                                                            {{ \App\Product::find($item)->subsubcategory->name }}
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th scope="row">{{__('Description')}}</th>
                                                @foreach (Session::get('compare') as $key => $item)
                                                    <td><?php echo \App\Product::find($item)->description; ?></td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th scope="row"></th>
                                                @foreach (Session::get('compare') as $key => $item)
                                                    <td class="text-center py-4">
                                                        <button type="button" class="btn btn-base-1 btn-circle btn-icon-left" onclick="showAddToCartModal({{ $item }})">
                                                            <i class="icon ion-android-cart"></i>{{__('Add to cart')}}
                                                        </button>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @else
                            <div class="card-body">
                                <p>{{__('Your comparison list is empty')}}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="addToCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="c-preloader">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <button type="button" class="close absolute-close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div id="addToCart-modal-body">

                </div>
            </div>
        </div>
    </div>

@endsection
