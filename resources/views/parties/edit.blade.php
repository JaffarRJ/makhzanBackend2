@extends('layouts.apps')
@section('tab')
    {{ __('messages.Edit Party ')}}
@endsection
@section('title')
    <h1 class="page-title">{{ __('messages.Add Admin')}}</h1>
@endsection
@section('content')
    <h3 class="card-title">{{ __('messages.Add Admin')}}</h3>
    <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
    </div>
    @if(session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{route('party.update')}}" name="addform" class="card-body" method="POST">
        @csrf
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <input type="hidden" name="id" class="form-control"  value="{{ $party->id }}"/>
                    <label>{{ __('messages.Name')}}</label>
                    <input type="text" name="name" class="form-control"  value="{{ $party->name }}"/>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>{{ __('messages.CNIC')}}</label>
                    <input type="number" name="cnic" class="form-control"  value="{{ $party->cnic }}"/>
                    @if ($errors->has('cnic'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('cnic') }}</strong>
                                </span>
                    @endif

                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>{{ __('messages.Phone')}}</label>
                    <input type="number" name="phone" value="{{$party->phone}}" class="form-control" id="phone"/>
                    @if ($errors->has('phone'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                    @endif

                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>{{ __('messages.Address')}}</label>
                    <textarea name="address" class="form-control" id="address">{{$party->address}}</textarea>
                    @if ($errors->has('address'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <button type="submit" class="btn btn-primary">
                    Update
                </button>
                <a href="{{route('party.listing')}}" class="btn btn-outline-secondary">
                    Cancel
                </a>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script src="{{asset('js/page/admins/create.js')}}"></script>
@endsection



{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--    <div class="container">--}}
{{--        <h1>{{ __('Edit Party') }}</h1>--}}

{{--        <form method="POST" action="{{ route('parties.update', $party->id) }}">--}}
{{--            @csrf--}}
{{--            @method('PATCH')--}}
{{--            <div class="form-group">--}}
{{--                <label for="partyName">{{ __('Party Name') }}</label>--}}
{{--                <input type="text" name="partyName" id="partyName" class="form-control" value="{{ $party->partyName }}" required>--}}
{{--            </div>--}}
{{--            <div class="form-group">--}}
{{--                <label for="partyCNIC">{{ __('Party CNIC') }}</label>--}}
{{--                <input type="text" name="partyCNIC" id="partyCNIC" class="form-control" value="{{ $party->partyCNIC }}" required>--}}
{{--            </div>--}}
{{--            <div class="form-group">--}}
{{--                <label for="partyAddress">{{ __('Party Address') }}</label>--}}
{{--                <textarea name="partyAddress" id="partyAddress" class="form-control" required>{{ $party->partyAddress }}</textarea>--}}
{{--            </div>--}}
{{--            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--@endsection--}}
