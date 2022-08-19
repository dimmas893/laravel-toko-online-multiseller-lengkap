@extends('layouts.app')

@section('content')

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Conversations')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{__('Title')}}</th>
                    <th>{{__('Sender')}}</th>
                    <th>{{__('Receiver')}}</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($conversations as $key => $conversation)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $conversation->created_at }}</td>
                        <td>{{ $conversation->title }}</td>
                        <td>
                            @if ($conversation->sender != null)
                                {{ $conversation->sender->name }}
                                @if ($conversation->receiver_viewed == 0)
                                    <span class="pull-right badge badge-info">{{ __('New') }}</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if ($conversation->receiver != null)
                                {{ $conversation->receiver->name }}
                                @if ($conversation->sender_viewed == 0)
                                    <span class="pull-right badge badge-info">{{ __('New') }}</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{route('conversations.admin_show', encrypt($conversation->id))}}">{{__('View')}}</a></li>
                                    <li><a onclick="confirm_modal('{{route('conversations.destroy', encrypt($conversation->id))}}');">{{__('Delete')}}</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
