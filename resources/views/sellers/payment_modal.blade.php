<form class="form-horizontal" action="{{ route('commissions.pay_to_seller') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">{{__('Pay to seller')}}</h4>
    </div>

    <div class="modal-body">
        <div>
            <table class="table table-responsive">
                <tbody>
                    <tr>
                        @if($seller->admin_to_pay >= 0)
                            <td>{{ __('Due to seller') }}</td>
                            <td>{{ single_price($seller->admin_to_pay) }}</td>
                        @endif
                    </tr>
                    @if ($seller->bank_payment_status == 1)
                        <tr>
                            <td>{{ __('Bank Name') }}</td>
                            <td>{{ $seller->bank_name }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Bank Account Name') }}</td>
                            <td>{{ $seller->bank_acc_name }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Bank Account Number') }}</td>
                            <td>{{ $seller->bank_acc_no }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Bank Routing Number') }}</td>
                            <td>{{ $seller->bank_routing_no }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($seller->admin_to_pay > 0)
            <input type="hidden" name="seller_id" value="{{ $seller->id }}">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="amount">{{__('Amount')}}</label>
                <div class="col-sm-9">
                    <input type="number" min="0" step="0.01" name="amount" id="amount" value="{{ $seller->admin_to_pay }}" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="payment_option">{{__('Payment Method')}}</label>
                <div class="col-sm-9">
                    <select name="payment_option" id="payment_option" class="form-control demo-select2-placeholder" required>
                        <option value="">{{__('Select Payment Method')}}</option>
                        @if($seller->cash_on_delivery_status == 1)
                            <option value="cash">{{__('Cash')}}</option>
                        @endif
                        @if($seller->bank_payment_status == 1)
                            <option value="bank_payment">{{__('Bank Payment')}}</option>
                        @endif
                    </select>
                </div>
            </div>

            <div class="form-group" id="txn_div">
                <label class="col-sm-3 control-label" for="txn_code">{{__('Txn Code')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="txn_code" id="txn_code" class="form-control">
                </div>
            </div>
        @endif

    </div>
    <div class="modal-footer">
        <div class="panel-footer text-right">
            @if ($seller->admin_to_pay > 0)
                <button class="btn btn-purple" type="submit">{{__('Pay')}}</button>
            @endif
            <button class="btn btn-default" data-dismiss="modal">{{__('Cancel')}}</button>
        </div>
    </div>
</form>
<script>
$(document).ready(function(){
    $('#payment_option').on('change', function() {
      if ( this.value == 'bank_payment')
      {
        $("#txn_div").show();
      }
      else
      {
        $("#txn_div").hide();
      }
    });
    $("#txn_div").hide();
});
</script>
