@extends('layouts.apps')
@section('tab')
    {{ __('messages.Add Role Permission')}}
@endsection
@section('title')
    <h1 class="page-title">{{ __('messages.Add Role Permission')}}</h1>
@endsection
@section('content')
    <h3 class="card-title">{{ __('messages.Add Role Permission')}}</h3>
    <a href="{{route('role.create')}}" class="btn btn-success mb-3"><i class="bi bi-star me-1"></i>{{ __('messages.Add Role') }}</a>
    <a href="{{route('permission.create')}}" class="btn btn-success mb-3"><i class="bi bi-star me-1"></i>{{ __('messages.Add Permission') }}</a>
    <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
    </div>
    @if(session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{route('role_permission.store')}}" name="addform" class="card-body" method="POST">
        @csrf
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Role</label>
                    <select id="roleDropdown" name="role_id" class="form-select">
                        <option value="">{{ __('messages.Choose')}} ...</option>
                        @if(count($roles) > 0 )
                            @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('role'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('role') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
            <div class="col-md-12 col-sm-12 mt-2">
                <div class="form-group" id="permissionContainer">
                    <label>{{ __('messages.Permissions')}}</label>
                    @if(count($permissions) > 0 )
                    @foreach($permissions as $permission)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permission_id[]" id="{{ $permission->id }}" value="{{ $permission->id }}" {{ is_array(old('permission')) && in_array($permission, old('permission')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $permission->name }}">{{ ucfirst($permission->name) }}</label>
                        </div>
                    @endforeach
                    @endif
                    @if ($errors->has('permission'))
                        <span class="invalid-feedback">
                <strong>{{ $errors->first('permission') }}</strong>
            </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <button type="submit" class="btn btn-primary">
                    {{ __('messages.Add')}}
                </button>
                <a href="{{route('role_permission.listing')}}" class="btn btn-outline-secondary">
                    {{ __('messages.Cancel')}}
                </a>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script src="{{asset('js/page/rolePermissions/create.js')}}"></script>
    <script>
        $(document).ready(function () {
            // Handle change event on the role dropdown
            $('#roleDropdown').change(function () {
                // Get the selected role ID
                var roleId = $(this).val();
                // Send an Ajax request to Laravel
                $.ajax({
                    url: "{{route('role_permission.getPermissions')}}", // Update this with the actual route URL
                    type: 'POST',
                    data: {
                        role_id: roleId,
                    },
                    success: function (data) {
                        // Update the permission container with the response from Laravel
                        $('#permissionContainer').html(data);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
