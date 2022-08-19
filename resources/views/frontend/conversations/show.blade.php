@extends('frontend.layouts.app')

@section('content')
    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @if(Auth::user()->user_type == 'seller')
                        @include('frontend.inc.seller_side_nav')
                    @elseif(Auth::user()->user_type == 'customer')
                        @include('frontend.inc.customer_side_nav')
                    @endif
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="card no-border p-3">
                            <h2 class="heading heading-6 text-capitalize strong-600 mb-0 d-inline-block">
                                {{ $conversation->title }}
                            </h2>
                            <br>
                            {{__('Between you and')}}
                            @if ($conversation->sender_id == Auth::user()->id)
                                {{ $conversation->receiver->name }}
                            @else
                                {{ $conversation->sender->name }}
                            @endif
                            <br>
                            @if ($conversation->sender_id == Auth::user()->id && $conversation->receiver->shop != null)
                                <a href="{{ route('shop.visit', $conversation->receiver->shop->slug) }}">{{ $conversation->receiver->shop->name }}</a>
                            @endif
                        </div>

                        <div class="card no-border mt-4 p-3">
                            <div class="py-4">
                                <div id="messages">
                                    @foreach ($conversation->messages as $key => $message)
                                        @if ($message->user_id == Auth::user()->id)
                                            <div class="block block-comment mb-3">
                                                <div class="d-flex flex-row-reverse">
                                                    <div class="pl-3">
                                                        <div class="block-image">
                                                            @if ($message->user->avatar_original != null)
                                                                <img src="{{ asset($message->user->avatar_original) }}" class="rounded-circle">
                                                            @else
                                                                <img src="{{ asset('frontend/images/user.png') }}" class="rounded-circle">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ml-5 pl-5">
                                                        <div class="p-3 bg-gray rounded">
                                                            {{ $message->message }}
                                                        </div>
                                                        <span class="comment-date alpha-7 small mt-1 d-block text-right">
                                                            {{ date('h:i:m d-m-Y', strtotime($message->created_at)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="block block-comment mb-3">
                                                <div class="d-flex">
                                                    <div class="pr-3">
                                                        <div class="block-image">
                                                            @if ($message->user->avatar_original != null)
                                                                <img src="{{ asset($message->user->avatar_original) }}" class="rounded-circle">
                                                            @else
                                                                <img src="{{ asset('frontend/images/user.png') }}" class="rounded-circle">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 mr-5 pr-5">
                                                        <div class="p-3 bg-gray rounded">
                                                            {{ $message->message }}
                                                        </div>
                                                        <span class="comment-date alpha-7 small mt-1 d-block">
                                                            {{ date('h:i:m d-m-Y', strtotime($message->created_at)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <form class="mt-4" action="{{ route('messages.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea class="form-control" rows="4" name="message" placeholder="Type your reply" required></textarea>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-base-1 mt-3">{{__('Send')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
    function refresh_messages(){
        $.post('{{ route('conversations.refresh') }}', {_token:'{{ @csrf_token() }}', id:'{{ encrypt($conversation->id) }}'}, function(data){
            $('#messages').html(data);
        })
    }

    refresh_messages(); // This will run on page load
    setInterval(function(){
        refresh_messages() // this will run after every 5 seconds
    }, 4000);
    </script>
@endsection
