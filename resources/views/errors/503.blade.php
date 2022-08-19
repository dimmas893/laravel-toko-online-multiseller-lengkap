@extends('layouts.blank')

@section('content')
<div class="text-center">
    {{-- <h1 class="error-code text-danger">{{__('OOPS!')}}</h1> --}}
    <p class="h3 text-uppercase text-bold">{{__('OOPS!')}}</p>
    <div class="pad-btm">
        {{__('This site is under developement. We will be back soon!!')}}
    </div>
    <hr class="new-section-sm bord-no">
</div>
@endsection
