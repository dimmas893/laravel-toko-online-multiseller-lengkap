@extends('layouts.app')

@section('content')

<div class="col-lg-12">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">#{{ $conversation->title }} (Between @if($conversation->sender != null) {{ $conversation->sender->name }} @endif and @if($conversation->receiver != null) {{ $conversation->receiver->name }} @endif)
            </h3>
        </div>

        <div class="panel-body">
            @foreach($conversation->messages as $message)
                <div class="form-group">
                    <a class="media-left" href="#"><img class="img-circle img-sm" alt="Profile Picture" @if($message->user != null)src="{{ asset($message->user->avatar_original) }}" @endif>
                    </a>
                    <div class="media-body">
                        <div class="comment-header">
                            <a href="#" class="media-heading box-inline text-main text-bold">
                                @if ($message->user != null)
                                    {{ $message->user->name }}
                                @endif
                            </a>
                            <p class="text-muted text-sm">{{$message->created_at}}</p>
                        </div>
                        <p>
                            {{ $message->message }}
                        </p>
                    </div>
                </div>
            @endforeach
            @if (Auth::user()->id == $conversation->receiver_id)
                <form action="{{ route('messages.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                    <div class="row">
                        <div class="col-md-12">
                            <textarea class="form-control" rows="4" name="message" placeholder="Type your reply" required></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="text-right">
                        <button type="submit" class="btn btn-info">{{__('Send')}}</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

@endsection
