@extends('layouts.apps')
@section('tab')
    {{ __('messages.Add User')}}
@endsection
@section('title')
    <h1 class="page-title">{{ __('messages.Add User')}}</h1>
@endsection
@section('content')
    <h3 class="card-title">{{ __('messages.Add User')}}</h3>
    <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
    </div>
    @if(session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{route('user.store')}}" name="addform" class="card-body" method="POST">
        @csrf
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>{{ __('messages.Name')}}</label>
                    <input type="text" name="name" class="form-control"/>
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
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>{{ __('messages.Email')}}</label>
                    <input type="email" name="email" class="form-control" id="email"/>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                    @endif

                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>{{ __('messages.Password')}}</label>
                    <input type="password" name="password" class="form-control" id="password"/>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                    @endif

                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>{{ __('messages.Confirm Password')}}</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"/>
                    @if ($errors->has('password_confirmation'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                    @endif

                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <button type="submit" class="btn btn-primary">
                    {{ __('messages.Add')}}
                </button>
                <a href="{{route('party.listing')}}" class="btn btn-outline-secondary">
                    {{ __('messages.Cancel')}}
                </a>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script src="{{asset('js/page/users/create.js')}}"></script>
@endsection
