<div class="panel">
    <div class="panel-body">
        <div class="">
            <!-- Simple profile -->
            <div class="text-center">
                <div class="pad-ver">
                    <img src="{{ asset($seller->user->avatar_original) }}" class="img-lg img-circle" alt="Profile Picture">
                </div>
                <h4 class="text-lg text-overflow mar-no">{{ $seller->user->name }}</h4>
                <p class="text-sm text-muted">{{ $seller->user->shop->name }}</p>

                <div class="pad-ver btn-groups">
                    <a href="{{ $seller->user->shop->facebook }}" class="btn btn-icon demo-pli-facebook icon-lg add-tooltip" data-original-title="Facebook" data-container="body"></a>
                    <a href="{{ $seller->user->shop->twitter }}" class="btn btn-icon demo-pli-twitter icon-lg add-tooltip" data-original-title="Twitter" data-container="body"></a>
                    <a href="{{ $seller->user->shop->google }}" class="btn btn-icon demo-pli-google-plus icon-lg add-tooltip" data-original-title="Google+" data-container="body"></a>
                </div>
            </div>
            <hr>

            <!-- Profile Details -->
            <p class="pad-ver text-main text-sm text-uppercase text-bold">{{__('About')}} {{ $seller->user->name }}</p>
            <p><i class="demo-pli-map-marker-2 icon-lg icon-fw"></i>{{ $seller->user->shop->address }}</p>
            <p><a href="{{ route('shop.visit', $seller->user->shop->slug) }}" class="btn-link"><i class="demo-pli-internet icon-lg icon-fw"></i>{{ $seller->user->shop->name }}</a></p>
            <p><i class="demo-pli-old-telephone icon-lg icon-fw"></i>{{ $seller->user->phone }}</p>

            <p class="pad-ver text-main text-sm text-uppercase text-bold">{{__('Payout Info')}}</p>
            <p>{{__('Bank Name')}} : {{ $seller->bank_name }}</p>
            <p>{{__('Bank Acc Name')}} : {{ $seller->bank_acc_name }}</p>
            <p>{{__('Bank Acc Number')}} : {{ $seller->bank_acc_no }}</p>
            <p>{{__('Bank Routing Number')}} : {{ $seller->bank_routing_no }}</p>

            <br>

            <div class="table-responsive">
                <table class="table table-striped mar-no">
                    <tbody>
                    <tr>
                        <td>Total Products</td>
                        <td>{{ App\Product::where('user_id', $seller->user->id)->get()->count() }}</td>
                    </tr>
                    <tr>
                        <td>Total Orders</td>
                        <td>{{ App\OrderDetail::where('seller_id', $seller->user->id)->get()->count() }}</td>
                    </tr>
                    <tr>
                        <td>Total Sold Amount</td>
                        @php
                            $orderDetails = \App\OrderDetail::where('seller_id', $seller->user->id)->get();
                            $total = 0;
                            foreach ($orderDetails as $key => $orderDetail) {
                                if($orderDetail->order->payment_status == 'paid'){
                                    $total += $orderDetail->price;
                                }
                            }
                        @endphp
                        <td>{{ single_price($total) }}</td>
                    </tr>
                    <tr>
                        <td>Wallet Balance</td>
                        <td>{{ single_price($seller->user->balance) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
