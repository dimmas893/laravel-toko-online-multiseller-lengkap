@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <a href="{{ route('customer_packages.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Package')}}</a>
    </div>
</div>

<br>

<div class="row">
    @foreach ($customer_packages as $key => $customer_package)
        <div class="col-lg-3">
            <div class="panel">
                <div class="panel-body text-center">
                    <img alt="Package Logo" class="img-lg img-circle mar-btm" src="{{ asset($customer_package->logo) }}">
                    <p class="text-lg text-semibold mar-no text-main">{{$customer_package->name}}</p>
                    <p class="text-3x">{{single_price($customer_package->amount)}}</p>
                    <p class="text-sm text-overflow pad-top">
                         Product Upload:
                        <span class="text-bold">{{$customer_package->product_upload}}</span>
                    </p>
                    <div class="mar-top">
                        <a href="{{route('customer_packages.edit', encrypt($customer_package->id))}}" class="btn btn-mint">{{__('Edit')}}</a>
                        <a onclick="confirm_modal('{{route('customer_packages.destroy', $customer_package->id)}}');" class="btn btn-danger">{{__('Delete')}}</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>


@endsection
