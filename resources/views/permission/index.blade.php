@extends('layouts.apps')

@section('content')
    <h5 class="card-title">{{ __('messages.Permission List') }}</h5>
    <a href="{{route('permission.create')}}" class="btn btn-success"><i class="bi bi-star me-1"></i>{{ __('messages.Create Permission') }}</a>
{{--    <button type="button" class="btn btn-primary"  href="{{ route('parties.create') }}"><i class="bi bi-star me-1"></i>{{ __('Create Permission') }}</button>--}}
    <!-- Table with stripped rows -->
    <table class="table datatable">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{ __('messages.ID')}}</th>
            <th scope="col">{{ __('messages.Name') }}</th>
            <th scope="col">{{ __('messages.Tab Name') }}</th>
            <th scope="col">{{ __('messages.Route') }}</th>
            <th scope="col">{{ __('messages.Permissions') }}</th>
            <th scope="col">{{ __('messages.Status') }}</th>
            <th scope="col">{{ __('messages.Actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($permissions) && $permissions->count())
            @foreach($permissions as $key => $value)

                <tr>
                    <td></td>
                    <td>{{$value->id}}</td>
                    <td>{{$value->name}}</td>
                    <td>
                        {{$value->tab_name}}
                    </td>
                    <td>{{$value->route}}</td>
                    <td>
                        @if($value->is_active)
                            <button type="submit" data-id="{{$value->id}}" onclick="changeStatus('updateIsActive','{{$value->id}}','0')" class="btn btn-sm btn-primary">{{ __('messages.Active')}}</button>
                        @else
                            <button type="submit" data-id="{{$value->id}}" onclick="changeStatus('updateIsActive','{{$value->id}}','1')" class="btn btn-sm btn-danger">{{ __('messages.Deactive')}}</button>
                        @endif
                    </td>
                    <td>
{{--                        @can('edit')--}}
                            <a href="{{route('permission.edit',$value->id)}}" class="btn btn-sm btn-primary">{{ __('messages.Edit')}}</a>
                        <button type="submit" data-id="{{$value->id}}" onclick="deleteValue('delete','{{$value->id}}','1')" class="btn btn-sm btn-danger">{{ __('messages.Delete')}}</button>
{{--                        @endcan--}}
{{--                        @can('delete')--}}
                            @if($value->is_show)
                                <button class="btn btn-sm btn-primary" data-id="{{$value->id}}" onclick="changeShow('updateIsShow','{{$value->id}}','0')" class="btn tag-danger active_btn">{{ __('messages.Show')}}</button>
                            @else
                                <button class="btn btn-sm btn-primary" data-id="{{$value->id}}" onclick="changeShow('updateIsShow','{{$value->id}}','1')" class="btn tag-success block_btn">{{ __('messages.Hide')}}</button>
                            @endif
                            @if($value->show_sidebar)
                                <button class="btn btn-sm btn-primary" data-id="{{$value->id}}" onclick="changeShow('updateIsShow','{{$value->id}}','0')" class="btn tag-danger active_btn">{{ __('messages.SideBar Show')}}</button>
                            @else
                                <button class="btn btn-sm btn-primary" data-id="{{$value->id}}" onclick="changeShow('updateIsShow','{{$value->id}}','1')" class="btn tag-success block_btn">{{ __('messages.SideBar Hide')}}</button>
                            @endif
{{--                        @endcan--}}
                    </td>
                </tr>
            @endforeach
        @else
            <tr style="text-align:center">
                <td colspan="10">No Record Found</td>
            </tr>
        @endif
        </tbody>
    </table>
    <!-- End Table with stripped rows -->
@endsection
{{--@section('scripts')--}}
{{--    <script src="{{asset('js/page/pagination/pagination.js')}}"></script>--}}
{{--@endsection--}}
