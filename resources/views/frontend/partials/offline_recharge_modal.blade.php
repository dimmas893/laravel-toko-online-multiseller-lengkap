<form class="" action="{{ route('wallet_recharge.make_payment') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal-body gry-bg px-3 pt-3 mx-auto">
        <div class="align-items-center gutters-5 row">
            @foreach(\App\ManualPaymentMethod::all() as $method)
              <div class="col-6">
                  <label class="payment_option mb-4" data-toggle="tooltip" data-title="{{ $method->heading }}">
                      <input type="radio" id="" name="payment_option" value="{{ $method->heading }}" onchange="toggleManualPaymentData({{ $method->id }})" required>
                      <span>
                          <img loading="lazy"  src="{{ asset($method->photo)}}" class="img-fluid">
                      </span>
                  </label>
              </div>
            @endforeach
        </div>

        <div id="manual_payment_data">

            <div class="card mb-3 p-3 d-none">
                <div id="manual_payment_description">

                </div>
            </div>

            <div class="card mb-3 p-3">
                <div class="row mt-3">
                    <div class="col-md-3">
                        <label>{{__('Amount')}} <span class="required-star">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="number" class="form-control mb-3" min="0" name="amount" placeholder="Amount" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <label>{{__('Name')}} <span class="required-star">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control mb-3" name="name" placeholder="Name" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <label>{{__('Transaction ID')}} <span class="required-star">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control mb-3" name="trx_id" placeholder="Transaction ID" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>{{__('Payment screenshot')}} <span class="required-star">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="file" name="photo" id="file-1" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" required />
                        <label for="file-1" class="mw-100 mb-3">
                            <span></span>
                            <strong>
                                <i class="fa fa-upload"></i>
                                {{__('Choose image')}}
                            </strong>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-base-1">{{__('Confirm')}}</button>
    </div>
</form>

@foreach(\App\ManualPaymentMethod::all() as $method)
  <div id="manual_payment_info_{{ $method->id }}" class="d-none">
      <div>@php echo $method->description @endphp</div>
      @if ($method->bank_info != null)
          <ul>
              @foreach (json_decode($method->bank_info) as $key => $info)
                  <li>Bank Name - {{ $info->bank_name }}, Account Name - {{ $info->account_name }}, Account Number - {{ $info->account_number}}, Routing Number - {{ $info->routing_number }}</li>
              @endforeach
          </ul>
      @endif
  </div>
@endforeach

<script type="text/javascript">
    // $(document).ready(function(){
    //     toggleManualPaymentData(null);
    // });

    function toggleManualPaymentData(id){
        $('#manual_payment_description').parent().removeClass('d-none');
        $('#manual_payment_description').html($('#manual_payment_info_'+id).html());
    }
</script>
