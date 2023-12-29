<label>{{ __('messages.Transactions')}}</label>
@if(count($transactions) > 0)
    @foreach($transactions as $transaction)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="transaction_id[]" value="{{ $transaction->id }}" {{ $partyTransaction->contains('transaction_id', $transaction->id) ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $transaction->name }}">{{ ucfirst($transaction->name) }}</label>
        </div>
    @endforeach
@endif

@if ($errors->has('transaction_id'))
    <span class="invalid-feedback">
        <strong>{{ $errors->first('transaction_id') }}</strong>
    </span>
@endif

