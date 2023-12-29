@extends('layouts.apps')

@section('content')
    <div class="container">
        <h1>{{ __('Party Details') }}</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $party->partyName }}</h5>
                <p class="card-text"><strong>{{ __('Party CNIC') }}:</strong> {{ $party->partyCNIC }}</p>
                <p class="card-text"><strong>{{ __('Party Address') }}:</strong> {{ $party->partyAddress }}</p>
            </div>
        </div>

        <a href="{{ route('parties.index') }}" class="btn btn-primary">{{ __('Back to List') }}</a>
    </div>
@endsection
