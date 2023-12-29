<label>{{ __('messages.Permissions')}}</label>
@if(count($permissions) > 0)
    @foreach($permissions as $permission)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="permission_id[]" value="{{ $permission->id }}" {{ $rolePermission->contains('permission_id', $permission->id) ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $permission->name }}">{{ ucfirst($permission->name) }}</label>
        </div>
    @endforeach
@endif
@if ($errors->has('permission_id'))
    <span class="invalid-feedback">
        <strong>{{ $errors->first('permission_id') }}</strong>
    </span>
@endif

