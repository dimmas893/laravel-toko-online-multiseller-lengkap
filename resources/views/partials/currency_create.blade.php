
<div class="modal-header">
    <h5 class="modal-title strong-600 heading-5">{{__('Add New Currency')}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form class="form-horizontal" action="{{ route('currency.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="panel-body">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">{{__('Name')}}</label>
            <div class="col-sm-10">
                <input type="text" placeholder="{{__('Name')}}" id="name" name="name" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="symbol">{{__('Symbol')}}</label>
            <div class="col-sm-10">
                <input type="text" placeholder="{{__('Symbol')}}" id="symbol" name="symbol" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="code">{{__('Code')}}</label>
            <div class="col-sm-10">
                <input type="text" placeholder="{{__('Code')}}" id="code" name="code" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="exchange_rate">{{__('Exchange Rate')}}</label>
            <div class="col-sm-10">
                <input type="number" step="0.01" min="0" placeholder="{{__('Exchange Rate')}}" id="exchange_rate" name="exchange_rate" class="form-control" required>
            </div>
        </div>
    </div>
    <div class="panel-footer text-right">
        <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
    </div>
</form>
