@extends('layouts.apps')
@section('tab')
    {{ __('messages.Add Transaction')}}
@endsection
@section('title')
    <h1 class="page-title">Add Admin</h1>
@endsection
@section('content')
    <h3 class="card-title">{{ __('messages.Add Transaction')}}</h3>
    <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
    </div>
    @if(session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{route('transaction.update')}}" name="addform" class="card-body" method="POST">
        @csrf
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <input type="hidden" name="id" class="form-control"  value="{{ $transaction->id }}"/>
                    <label>{{ __('messages.Name')}}</label>
                    <input type="text" name="name" class="form-control"  value="{{ $transaction->name }}"/>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <button type="submit" class="btn btn-primary">
                    Update
                </button>
                <a href="{{route('transaction.listing')}}" class="btn btn-outline-secondary">
                    Cancel
                </a>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script src="{{asset('js/page/admins/create.js')}}"></script>
@endsection
