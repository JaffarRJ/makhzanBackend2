<label>{{ __('messages.Sub Accounts')}}</label>
@if(count($subAccounts) > 0)
    @foreach($subAccounts as $subAccount)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="sub_account_id[]" id="{{ $subAccount->id }}" value="{{ $subAccount->id }}" {{ $accountSubAccounts->contains('sub_account_id', $subAccount->id) ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $subAccount->name }}">{{ ucfirst($subAccount->name) }}</label>
        </div>
    @endforeach
@endif

@if ($errors->has('sub_account_id'))
    <span class="invalid-feedback">
        <strong>{{ $errors->first('sub_account_id') }}</strong>
    </span>
@endif

