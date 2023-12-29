@extends('layouts.apps')
@section('tab')
    {{ __('messages.Manage Transaciton')}}
@endsection
@section('title')
    <h1 class="page-title">{{ __('messages.Add Account Transaction')}}</h1>
@endsection
@section('content')
    <h3 class="card-title">{{ __('messages.Add Account Transaction')}}</h3>
    <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
    </div>
    @if(session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{route('party_account_transaction.store')}}" name="addform" class="card-body" method="POST">
        @csrf
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="m-2">{{ __('messages.Party')}}</label>
                    <select id="partyDropdown" name="party_id" class="form-select select2" required>
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
            <div class="col-md-6 col-sm-12">
                <div class="form-group" id="transactionContainer">
                    <label class="m-2">{{ __('messages.Transaction')}}</label>
                    <select id="transaction_id" name="transaction_id" class="form-select select2" required>
                        <option value="">{{ __('messages.Choose')}} ...</option>
{{--                        @if(count($transactions) > 0 )--}}
{{--                            @foreach($transactions as $transaction)--}}
{{--                                <option value="{{$transaction->id}}">{{$transaction->name}}</option>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
                    </select>
                    @if ($errors->has('transaction'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('transaction') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="m-2">{{ __('messages.Account')}}</label>
                    <select id="accountDropdown" name="account_id" class="form-select select2" required>
                        <option value="">{{ __('messages.Choose')}} ...</option>
                        @if(count($accounts) > 0 )
                            @foreach($accounts as $account)
                                <option value="{{$account->id}}">{{$account->name}}</option>
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('account'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('account') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group" id="subAccountContainer">
                    <label class="m-2">{{ __('messages.Sub Account')}}</label>
                    <select id="sub_account_id" name="sub_account_id" class="form-select select2" required>
                        <option value="">{{ __('messages.Choose')}} ...</option>
{{--                        @if(count($subAccounts) > 0 )--}}
{{--                            @foreach($subAccounts as $subAccount)--}}
{{--                                <option value="{{$subAccount->id}}">{{$subAccount->name}}</option>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
                    </select>
                    @if ($errors->has('sub_account'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('sub_account') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="m-3">{{ __('messages.Amount')}}</label>
                    <input type="number" name="amount" class="form-control" required/>
                    @if ($errors->has('amount'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                    @endif

                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="m-3">{{ __('messages.Transaction Type')}}</label>
                    <div class="form-check">
                        <input type="radio" name="transaction_type" value="1" class="form-check-input" id="drRadio" checked>
                        <label class="form-check-label" for="drRadio">{{ __('messages.Debit')}}</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="transaction_type" value="2" class="form-check-input" id="crRadio">
                        <label class="form-check-label" for="crRadio">{{ __('messages.Credit')}}</label>
                    </div>
                    @if ($errors->has('transaction_type'))
                        <span class="invalid-feedback">
                <strong>{{ $errors->first('transaction_type') }}</strong>
            </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <button type="submit" class="btn btn-primary">
                    {{ __('messages.Add')}}
                </button>
                <a href="{{route('party_account_transaction.listing')}}" class="btn btn-outline-secondary">
                    {{ __('messages.Cancel')}}
                </a>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script src="{{asset('js/page/partyAccountTransaction/create.js')}}"></script>
    <script>
        $(document).ready(function () {
            // Handle change event on the party dropdown
            $('#partyDropdown').change(function () {
                // Get the selected party ID
                var partyId = $(this).val();
                // Send an Ajax request to Laravel
                if(partyId) {
                    $.ajax({
                        url: "{{route('party_account_transaction.getTransactions')}}", // Update this with the actual route URL
                        type: 'POST',
                        data: {
                            id: partyId,
                        },
                        success: function (data) {
                            // Update the transaction container with the response from Laravel
                            $('#transactionContainer').html(data);
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
            // Handle change event on the party dropdown
            $('#accountDropdown').change(function () {
                // Get the selected party ID
                var accountId = $(this).val();
                // Send an Ajax request to Laravel
                if(accountId) {
                    $.ajax({
                        url: "{{route('party_account_transaction.getSubAccounts')}}", // Update this with the actual route URL
                        type: 'POST',
                        data: {
                            id: accountId,
                        },
                        success: function (data) {
                            // Update the transaction container with the response from Laravel
                            $('#subAccountContainer').html(data);
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
@endsection
