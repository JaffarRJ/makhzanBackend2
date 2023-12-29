@extends('layouts.apps')
@section('tab')
    {{ __('messages.Edit User')}}
@endsection
@section('title')
    <h1 class="page-title">{{ __('messages.Edit User')}}</h1>
@endsection
@section('content')
    <h3 class="card-title">{{ __('messages.Edit User')}}</h3>
    <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
    </div>
    @if(session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{route('user.update')}}" name="addform" class="card-body" method="POST">
        @csrf
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <input type="hidden" name="id" class="form-control"  value="{{ $user->id }}"/>
                    <label>{{ __('messages.Name')}}</label>
                    <input type="text" name="name" class="form-control"  value="{{ $user->name }}"/>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>{{ __('messages.Assign Role')}}</label>
                    <select id="inputUser" name="role_id" class="form-select">
                        <option value="">{{ __('messages.Choose ...')}}</option>
                        @if(count($roles) > 0 )
                            @foreach($roles as $role)
                                <option @if($role->id == $user->id) selected="" @endif value="{{$role->id}}">{{$role->name}}</option>
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
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>{{ __('messages.Email')}}</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{$user->email}}"/>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                    @endif

                </div>
            </div>
{{--            <div class="col-md-6 col-sm-12">--}}
{{--                <div class="form-group">--}}
{{--                    <label>Password</label>--}}
{{--                    <input type="password" name="password" class="form-control" id="password" value="{{$user->password}}"/>--}}
{{--                    @if ($errors->has('email'))--}}
{{--                        <span class="invalid-feedback">--}}
{{--                                    <strong>{{ $errors->first('password') }}</strong>--}}
{{--                                </span>--}}
{{--                    @endif--}}

{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-6 col-sm-12">--}}
{{--                <div class="form-group">--}}
{{--                    <label>Confirm Password</label>--}}
{{--                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" value="{{$user->password}}"/>--}}
{{--                    @if ($errors->has('password_confirmation'))--}}
{{--                        <span class="invalid-feedback">--}}
{{--                                    <strong>{{ $errors->first('password_confirmation') }}</strong>--}}
{{--                                </span>--}}
{{--                    @endif--}}

{{--                </div>--}}
{{--            </div>--}}
            <div class="col-sm-12 mt-5">
                <button type="submit" class="btn btn-primary">
                    {{ __('messages.Update')}}
                </button>
                <a href="{{route('user.listing')}}" class="btn btn-outline-secondary">
                    {{ __('messages.Cancel')}}
                </a>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script src="{{asset('js/page/user/edit.js')}}"></script>
@endsection
