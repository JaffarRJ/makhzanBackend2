    <label class="m-2">{{ __('messages.Transaction')}}</label>
    <select id="inputUser" name="transaction_id" class="form-select select2">
        @if(count($transactions) > 0)
        <option value="">{{ __('messages.Choose')}} ...</option>
            @foreach($transactions as $transaction)
                <option value="{{$transaction->id}}">{{$transaction->name}}</option>
            @endforeach
        @else
            <option value="">-----{{ __('messages.Not Found')}}-----</option>
        @endif
    </select>
