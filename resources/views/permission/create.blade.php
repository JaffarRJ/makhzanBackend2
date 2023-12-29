@extends('layouts.apps')
@section('tab')
    {{ __('messages.Add Permission')}}
@endsection
@section('title')
    <h1 class="page-title">{{ __('messages.Add Permission')}}</h1>
@endsection
@section('content')
    <h3 class="card-title">{{ __('messages.Add Permission')}}</h3>
    <a href="{{route('permission.listing')}}" class="btn btn-success mb-3"><i class="bi bi-star me-1"></i>{{ __('messages.Show') }}</a>
    <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
    </div>
    @if(session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{route('permission.store')}}" name="addform" class="card-body" method="POST">
        @csrf
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>{{ __('messages.Name') }}</label>
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
                    <label>{{ __('messages.Tab Name')}}</label>
                    <input type="text" name="tab_name" placeholder="Tab Name" class="form-control"/>
                    @if ($errors->has('tab_name'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('tab_name') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>{{ __('messages.Route')}}</label>
                    <input type="text" name="route" class="form-control" id="route"/>
                    @if ($errors->has('route'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('route') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <button type="submit" class="btn btn-primary">
                    Add
                </button>
                <a href="{{route('permission.listing')}}" class="btn btn-outline-secondary">
                    Cancel
                </a>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script src="{{asset('js/page/permissions/create.js')}}"></script>
@endsection
