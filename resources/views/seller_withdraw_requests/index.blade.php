@extends('layouts.app')



@section('content')



    <div class="panel">

        <div class="panel-heading">

            <h3 class="panel-title">{{__('Seller Withdraw Request')}}</h3>

        </div>

        <div class="panel-body">

            <table class="table table-striped res-table mar-no" cellspacing="0" width="100%">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>{{__('Date')}}</th>

                        <th>{{__('Seller')}}</th>

                        <th>{{__('Total Amount to Pay')}}</th>

                        <th>{{__('Requested Amount')}}</th>

                        <th>{{ __('Message') }}</th>

                        <th>{{ __('Status') }}</th>

                        <th width="10%">{{__('Options')}}</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($seller_withdraw_requests as $key => $seller_withdraw_request)

                        @if (\App\Seller::find($seller_withdraw_request->user_id) != null && \App\Seller::find($seller_withdraw_request->user_id)->user != null)

                            <tr>

                                <td>{{ ($key+1) + ($seller_withdraw_requests->currentPage() - 1)*$seller_withdraw_requests->perPage() }}</td>

                                <td>{{ $seller_withdraw_request->created_at }}</td>

                                <td>

                                    @if (\App\Seller::find($seller_withdraw_request->user_id) != null)

                                        {{ \App\Seller::find($seller_withdraw_request->user_id)->user->name }} ({{ \App\Seller::find($seller_withdraw_request->user_id)->user->shop->name }})

                                    @endif

                                </td>

                                <td>{{ single_price(\App\Seller::find($seller_withdraw_request->user_id)->admin_to_pay) }}</td>

                                <td>{{ single_price($seller_withdraw_request->amount) }}</td>

                                <td>

                                    {{ $seller_withdraw_request->message }}

                                </td>

                                <td>

                                    @if ($seller_withdraw_request->status == 1)

                                        <span class="ml-2" style="color:green"><strong>{{__('Paid')}}</strong></span>

                                    @else

                                        <span class="ml-2" style="color:red"><strong>{{__('Pending')}}</strong></span>

                                    @endif

                                </td>

                                <td>

                                    <div class="btn-group dropdown">

                                        <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">

                                            {{__('Actions')}} <i class="dropdown-caret"></i>

                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-right">

                                            <li><a onclick="show_seller_payment_modal('{{$seller_withdraw_request->user_id}}','{{ $seller_withdraw_request->id }}');">{{__('Pay Now')}}</a></li>

                                            <li><a href="{{route('sellers.payment_history', encrypt($seller_withdraw_request->user_id))}}">{{__('Payment History')}}</a></li>

                                        </ul>

                                    </div>

                                </td>

                            </tr>

                        @endif

                    @endforeach

                </tbody>

            </table>

            <div class="clearfix">

                <div class="pull-right">

                    {{ $seller_withdraw_requests->links() }}

                </div>

            </div>

        </div>

    </div>



    <div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content" id="modal-content">



            </div>

        </div>

    </div>

    <div class="modal fade" id="message_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">

            <div class="modal-content" id="modal-content">



            </div>

        </div>

    </div>

@endsection



@section('script')

    <script type="text/javascript">

        function show_seller_payment_modal(id, seller_withdraw_request_id){



            $.post('{{ route('withdraw_request.payment_modal') }}',{_token:'{{ @csrf_token() }}', id:id, seller_withdraw_request_id:seller_withdraw_request_id}, function(data){

                $('#modal-content').html(data);

                $('#payment_modal').modal('show', {backdrop: 'static'});

                $('.demo-select2-placeholder').select2();

            });

        }



        function show_message_modal(id){

            $.post('{{ route('withdraw_request.message_modal') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){

                $('#message_modal .modal-content').html(data);

                $('#message_modal').modal('show', {backdrop: 'static'});

            });

        }

    </script>

@endsection
