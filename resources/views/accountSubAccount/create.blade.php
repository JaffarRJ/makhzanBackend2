@extends('layouts.apps')
@section('tab')
    {{ __('messages.Add Manage Account')}}
@endsection
@section('title')
    <h1 class="page-title">{{ __('messages.Add Manage Account')}}</h1>
@endsection
@section('content')
    <h3 class="card-title">{{ __('messages.Add Manage Account')}}</h3>
    <a href="#" target="_blank" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#accountModel"><i class="bi bi-star me-1"></i>{{ __('messages.Add Account') }}</a>
    <a href="#" target="_blank" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#subAccountModel"><i class="bi bi-star me-1"></i>{{ __('messages.Add Sub Account') }}</a>
    <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
    </div>
    @if(session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
    @endif
    @include('accountSubAccount/modelAccount')
    @include('accountSubAccount/modelSubAccount')
    <form action="{{route('account_sub_account.store')}}" name="addform" class="card-body" method="POST">
        @csrf
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>{{ __('messages.Account')}}</label>
                    <select  id="accountDropdown" name="account_id" class="form-select  select2">
                        <option value="">{{ __('messages.Choose ...')}}</option>
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
            <div class="col-md-12 col-sm-12 mt-2">
                <div class="form-group" id="subAccountContainer">
                    <label>{{ __('messages.Sub Accounts')}}</label>
                    @if(count($subAccounts) > 0 )
                        @foreach($subAccounts as $subAccount)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sub_account_id[]" id="{{ $subAccount->id }}" value="{{ $subAccount->id }}" {{ is_array(old('subAccount')) && in_array($subAccount, old('subAccount')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $subAccount->name }}">{{ ucfirst($subAccount->name) }}</label>
                            </div>
                        @endforeach
                    @endif
                    @if ($errors->has('subAccount'))
                        <span class="invalid-feedback">
                <strong>{{ $errors->first('subAccount') }}</strong>
            </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <button type="submit" class="btn btn-primary">
                    {{ __('messages.Add')}}
                </button>
                <a href="{{route('sub_account.listing')}}" class="btn btn-outline-secondary">
                    {{ __('messages.Cancel')}}
                </a>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script src="{{asset('js/page/accountSubAccounts/create.js')}}"></script>
    <script src="{{asset('js/page/accounts/create.js')}}"></script>
    <script src="{{asset('js/page/subAccounts/create.js')}}"></script>
    <script>
        $(document).ready(function () {
            // Handle change event on the party dropdown
            $('#accountDropdown').change(function () {
                // Get the selected party ID
                var accountId = $(this).val();
                // Send an Ajax request to Laravel
                $.ajax({
                    url: '{{route('account_sub_account.getSubAccounts')}}', // Update this with the actual route URL
                    type: 'POST',
                    data: {
                        account_id: accountId,
                    },
                    success: function (data) {
                        // Update the transaction container with the response from Laravel
                        $('#subAccountContainer').html(data);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });

    </script>
@endsection

