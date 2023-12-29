@extends('layouts.apps')
@section('tab')
    {{ __('messages.Edit Sub Account')}}
@endsection
@section('title')
    <h1 class="page-title">{{ __('messages.Edit Sub Account')}}</h1>
@endsection
@section('content')
    <h3 class="card-title">{{ __('messages.Edit Sub Account')}}</h3>
    <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
    </div>
    @if(session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{route('sub_account.update')}}" name="addform" class="card-body" method="POST">
        @csrf
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <input type="hidden" name="id" class="form-control"  value="{{ $subAccount->id }}"/>
                    <label>Name</label>
                    <input type="text" name="name" class="form-control"  value="{{ $subAccount->name }}"/>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>{{ __('messages.Detail')}}</label>
                    <textarea name="detail" class="form-control" id="address">{{$subAccount->detail}}</textarea>
                    @if ($errors->has('detail'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('detail') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <button type="submit" class="btn btn-primary">
                    {{ __('messages.Update')}}
                </button>
                <a href="{{route('sub_account.listing')}}" class="btn btn-outline-secondary">
                    {{ __('messages.Cancel')}}
                </a>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script src="{{asset('js/page/admins/create.js')}}"></script>
@endsection
