@extends('layouts.apps')
@section('tab')
    {{ __('messages.Add Party')}}
@endsection
@section('title')
    <h1 class="page-title">{{ __('messages.Add Party')}}</h1>
@endsection
@section('content')
    <h3 class="card-title">{{ __('messages.welcome') }}</h3>
    <a href="{{route('party.listing')}}" class="btn btn-success mb-3"><i class="bi bi-star me-1"></i>{{ __('messages.Show') }}</a>
    <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
    </div>
    @if(session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{route('party.store')}}" name="addform" class="card-body" method="POST">
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
                    <label>{{ __('messages.CNIC')}}</label>
                    <input type="number" name="cnic" data-inputmask="'mask': '99999-9999999-9'"  placeholder="XXXXX-XXXXXXX-X" class="form-control"/>
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
                    <input type="number" name="phone" data-inputmask="'mask': '0399-99999999'" class="form-control" id="phone"/>
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
                    <textarea name="address" class="form-control" id="address"></textarea>
                    @if ($errors->has('address'))
                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <button type="submit" class="btn btn-primary">
                    Add
                </button>
                <a href="{{route('party.listing')}}" class="btn btn-outline-secondary">
                    Cancel
                </a>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script src="{{asset('js/page/parties/create.js')}}"></script>
@endsection




{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--            <h5 class="card-title">{{ __('Create Party') }}</h5>--}}
{{--            <!-- No Labels Form -->--}}
{{--            <form class="row g-3" id="createPartyForm"  method="POST" action="{{ route('parties.store') }}">--}}
{{--                @csrf--}}
{{--                <div class="col-md-6">--}}
{{--                    <input type="text" class="form-control" placeholder="{{ __('Party Name') }}">--}}
{{--                </div>--}}
{{--                <div class="col-md-6">--}}
{{--                    <input type="number" class="form-control" placeholder="{{ __('Party CNIC') }}">--}}
{{--                </div>--}}
{{--                <div class="col-6">--}}
{{--                    <textarea class="form-control" placeholder="{{ __('Party Address') }}"></textarea>--}}
{{--                </div>--}}
{{--                <div class="text">--}}
{{--                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>--}}
{{--                    <button type="reset" class="btn btn-secondary">Reset</button>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--            <script>--}}
{{--                $(document).ready(function() {--}}
{{--                    aler("ALI");--}}
{{--                    $('#createPartyForm').validate({--}}
{{--                        rules: {--}}
{{--                            partyName: 'required',--}}
{{--                            partyCNIC: {--}}
{{--                                required: true,--}}
{{--                                maxlength: 13,--}}
{{--                            },--}}
{{--                            partyAddress: 'required',--}}
{{--                        },--}}
{{--                        messages: {--}}
{{--                            partyName: '{{ __('Please enter the party name') }}',--}}
{{--                            partyCNIC: {--}}
{{--                                required: '{{ __('Please enter the party CNIC') }}',--}}
{{--                                maxlength: '{{ __('CNIC must be at most 10 characters long') }}',--}}
{{--                            },--}}
{{--                            partyAddress: '{{ __('Please enter the party address') }}',--}}
{{--                        }--}}
{{--                    });--}}
{{--                });--}}
{{--            </script>--}}
{{--@endsection--}}
{{--endsection--}}
