@extends('layouts.apps')
@section('tab')
    {{ __('messages.Add Sub Account')}}
@endsection
@section('title')
    <h1 class="page-title">{{ __('messages.Add Party Transaction')}}</h1>
@endsection
@section('content')
    <h3 class="card-title">{{ __('messages.Add Party Transaction')}}</h3>
    <a href="#" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#partyModel"><i class="bi bi-star me-1"></i>{{ __('messages.Add Party') }}</a>
    <a href="#" class="btn btn-success mb-3"  data-bs-toggle="modal" data-bs-target="#transactionModel"><i class="bi bi-star me-1"></i>{{ __('messages.Add Transaction') }}</a>
    <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
    </div>
    @if(session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
    @endif
    @include('partyTransaction/modelParty')
    @include('partyTransaction/modelTransaction')
    <form action="{{route('party_transaction.store')}}" name="partyTransaction" class="card-body" method="POST">
        @csrf
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>{{ __('messages.Party')}}</label>
                    <select id="partyDropdown" name="party_id" class="form-control form-select select2">
                        <option value="">{{ __('messages.Choose')}} ...</option>
                        @if(count($parties) > 0 )
                            @foreach($parties as $party)
                                <option value="{{$party->id}}">{{$party->name}}</option>
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('party'))
                        <span class="invalid-feedback">
                <strong>{{ $errors->first('party') }}</strong>
            </span>
                    @endif
                </div>
            </div>
            <div class="col-md-12 col-sm-12 mt-2">
                <div class="form-group" id="transactionContainer">
                    <label>{{ __('messages.Transactions')}}</label>
                    @if(count($transactions) > 0 )
                    @foreach($transactions as $transaction)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="transaction_id[]" id="{{ $transaction->id }}" value="{{ $transaction->id }}" {{ is_array(old('transaction')) && in_array($transaction, old('transactions')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $transaction->name }}">{{ ucfirst($transaction->name) }}</label>
                        </div>
                    @endforeach
                    @endif
                    @if ($errors->has('transaction'))
                        <span class="invalid-feedback">
                <strong>{{ $errors->first('transaction') }}</strong>
            </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <button type="submit" class="btn btn-primary">
                    {{ __('messages.Add')}}
                </button>
                <a href="{{route('party_transaction.listing')}}" class="btn btn-outline-secondary">
                    {{ __('messages.Cancel')}}
                </a>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script src="{{asset('js/page/partyTransactions/create.js')}}"></script>
    <script src="{{asset('js/page/parties/create.js')}}"></script>
    <script src="{{asset('js/page/transactions/create.js')}}"></script>s
    <script>
        $(document).ready(function () {
            // Handle change event on the party dropdown
            $('#partyDropdown').change(function () {
                // Get the selected party ID
                var partyId = $(this).val();
                // Send an Ajax request to Laravel
                $.ajax({
                    url: "{{route('party_transaction.getTransactions')}}", // Update this with the actual route URL
                    type: 'POST',
                    data: {
                        party_id: partyId,
                    },
                    success: function (data) {
                        // Update the transaction container with the response from Laravel
                        $('#transactionContainer').html(data);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
