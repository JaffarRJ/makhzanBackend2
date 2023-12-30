<div class="modal fade" id="permissionModel" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('messages.Sub Account')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('permission.store')}}" name="permissionForm" class="card-body" method="POST">
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
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.Cancel')}}</button>
                                <button type="submit" class="btn btn-primary">{{ __('messages.Add')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('messages.Id')}}</th>
                        <th scope="col">{{ __('messages.Name') }}</th>
                        <th scope="col">{{ __('messages.Tab Name') }}</th>
                        <th scope="col">{{ __('messages.Route') }}</th>
{{--                        <th scope="col">{{ __('messages.Permissions') }}</th>--}}
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
            </div>
        </div>
    </div>
</div>