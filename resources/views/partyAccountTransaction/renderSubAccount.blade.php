<label class="m-2">{{ __('messages.Sub Account')}}</label>
<select id="inputUser" name="sub_account_id" class="form-select select2">
    @if(count($subAccounts) > 0)
    <option value="">{{ __('messages.Choose')}} ...</option>
        @foreach($subAccounts as $subAccount)
            <option value="{{$subAccount->id}}">{{$subAccount->name}}</option>
        @endforeach
    @else
        <option value="">-----{{ __('messages.Not Found')}}-----</option>
    @endif
</select>
