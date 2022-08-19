<script src="//voguepay.com/js/voguepay.js"></script>

<script>
    closedFunction=function() {
        alert('window closed');
        location.href = '{{ env('APP_URL') }}'+'/admin/sellers'
    }

    successFunction=function(transaction_id) {
        location.href = '{{ env('APP_URL') }}'+'/vogue-pay/success/'+transaction_id
    }
    failedFunction=function(transaction_id) {
         location.href = '{{ env('APP_URL') }}'+'/vogue-pay/success/'+transaction_id
    }
</script>

<input type="hidden" id="merchant_id" name="v_merchant_id" value="{{ $seller->voguepay_merchand_id }}">


<script>

        window.onload = function(){
            pay3();
        }

        function pay3() {
         Voguepay.init({
             v_merchant_id: document.getElementById("merchant_id").value,
             total: '{{ Session::get('payment_data')['amount'] }}',
             cur: '{{\App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code}}',
             merchant_ref: 'ref123',
             loadText:'Custom load text',
             customer: {
                name: '{{ Auth::user()->name }}',

                email: '{{ Auth::user()->email }}',
                phone: '{{ Auth::user()->phone }}'
            },
             closed:closedFunction,
             success:successFunction,
             failed:failedFunction
         });
        }
</script>
