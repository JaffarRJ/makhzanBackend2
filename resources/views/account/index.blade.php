@extends('layouts.apps')

@section('content')
    <h5 class="card-title">{{ __('messages.Account List') }}</h5>
    <a href="{{route('account.create')}}" class="btn btn-success"><i class="bi bi-star me-1"></i>{{ __('messages.Create Account') }}</a>
    {{--    <button type="button" class="btn btn-primary"  href="{{ route('parties.create') }}"><i class="bi bi-star me-1"></i>{{ __('Create Account') }}</button>--}}
    <!-- Table with stripped rows -->
    <table class="table datatable">
        <thead>
        <tr>
            {{--            <th scope="col">#</th>--}}
            <th scope="col">ID</th>
            <th scope="col">{{ __('messages.Account Name') }}</th>
            <th scope="col">{{ __('messages.Detail') }}</th>
            <th scope="col">{{ __('messages.Status') }}</th>
            <th scope="col">{{ __('messages.Actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($accounts) && $accounts->count())
            @foreach($accounts as $key => $value)

                <tr>
                    {{--                    <td></td>--}}
                    <td>{{$value->id}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->detail}}</td>
                    <td>
                        @if($value->is_active)
                            <button type="submit" data-id="{{$value->id}}" onclick="changeStatus('updateIsActive','{{$value->id}}','0')" class="btn btn-sm btn-primary">{{ __('messages.Active')}}</button>
                        @else
                            <button type="submit" data-id="{{$value->id}}" onclick="changeStatus('updateIsActive','{{$value->id}}','1')" class="btn btn-sm btn-danger">{{ __('messages.Deactive')}}</button>
                        @endif
                    </td>
                    <td>
                        {{--                        @can('edit')--}}
                        <a href="{{route('account.edit',$value->id)}}" class="btn btn-sm btn-primary">{{ __('messages.Edit')}}</a>
                        <button type="submit" data-id="{{$value->id}}" onclick="deleteValue('delete','{{$value->id}}','1')" class="btn btn-sm btn-danger">{{ __('messages.Delete')}}</button>
                        {{--                        @endcan--}}
                        {{--                        @can('delete')--}}
                        @if($value->is_show)
                            <button class="btn btn-sm btn-primary" data-id="{{$value->id}}" onclick="changeShow('updateIsShow','{{$value->id}}','0')" class="btn tag-danger active_btn">{{ __('messages.Show')}}</button>
                        @else
                            <button class="btn btn-sm btn-primary" data-id="{{$value->id}}" onclick="changeShow('updateIsShow','{{$value->id}}','1')" class="btn tag-success block_btn">{{ __('messages.Hide')}}</button>
                        @endif
                        {{--                        @endcan--}}
                    </td>
                </tr>
            @endforeach
        @else
            <tr style="text-align:center">
                <td colspan="10">{{ __('messages.No Record Found')}}</td>
            </tr>
        @endif
        </tbody>
    </table>
    <!-- End Table with stripped rows -->
@endsection
{{--@section('scripts')--}}
{{--    <script src="{{asset('js/page/pagination/pagination.js')}}"></script>--}}
{{--@endsection--}}
