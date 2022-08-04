@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="align-items-center">
        <h1 class="h3">{{translate('All Users')}}</h1>
    </div>
</div>


<div class="card">
    <form class="" id="sort_customers" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-0 h6">{{translate('Users')}}</h5>
            </div>
            
            <div class="dropdown mb-2 mb-md-0">
                <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                    {{translate('Bulk Action')}}
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#" onclick="bulk_delete()">{{translate('Delete selection')}}</a>
                </div>
            </div>
            <div class="col-lg-2 ml-auto">
                <select class="form-control aiz-selectpicker" name="user_type" id="user_type">
                    <option value="">{{translate('Filter by User Type')}}</option>
                    <option value="salesperson" @if ($user_type == "salesperson") selected @endif>{{translate('Salesperson')}}</option>
                    <option value="customer" @if ($user_type == "customer") selected @endif>{{translate('Customer')}}</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type email or name') }}">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                </div>
            </div>
        </div>
    
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <!--<th data-breakpoints="lg">#</th>-->
                        <th>
                            <div class="form-group">
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" class="check-all">
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </th>
                        <th>{{translate('Name')}}</th>
                        <th data-breakpoints="lg">{{translate('Email Address')}}</th>
                        <th data-breakpoints="lg">{{translate('Status')}}</th>
                        <th data-breakpoints="lg">{{translate('Type')}}</th>
                        <!-- <th data-breakpoints="lg">{{translate('Package')}}</th>
                        <th data-breakpoints="lg">{{translate('Wallet Balance')}}</th> -->
                        <th>{{translate('Salesperson')}}</th>
                        <th>{{translate('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        @if ($user != null)
                            <tr>
                                <!--<td>{{ ($key+1) + ($users->currentPage() - 1)*$users->perPage() }}</td>-->
                                <td>
                                    <div class="form-group">
                                        <div class="aiz-checkbox-inline">
                                            <label class="aiz-checkbox">
                                                <input type="checkbox" class="check-one" name="id[]" value="{{$user->id}}">
                                                <span class="aiz-square-check"></span>
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td>@if($user->banned == 1) <i class="fa fa-ban text-danger" aria-hidden="true"></i> @endif {{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>@if($user->banned == 1) {{translate('Inactive')}} @else {{translate('Active')}} @endif</td>
                                <td>@if($user->is_salesperson == 1) Salesperson @else Customer @endif</td>
                                <td>{{(isset($user->salesperson['name']) && !empty($user->salesperson['name']))?$user->salesperson['name']:'-'}}</td>
                                <!-- <td>
                                    @if ($user->customer_package != null)
                                    {{$user->customer_package->getTranslation('name')}}
                                    @endif
                                </td>
                                <td>{{single_price($user->balance)}}</td> -->
                                <td class="text-right">
                                    <!-- <a href="{{route('customers.login', encrypt($user->id))}}" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate('Log in as this Customer') }}">
                                        <i class="las la-edit"></i>
                                    </a> -->
                                    <a href="{{route('customers.information', $user->id)}}" class="btn btn-soft-danger btn-icon btn-circle btn-sm "  title="{{ translate('All Orders') }}">
                                        <i class="las la-eye"></i>
                                    </a>
                                    <a href="{{route('user.profile', ['id' => $user->id])}}" class="btn btn-soft-danger btn-icon btn-circle btn-sm "  title="{{ translate('Edit User') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    @if($user->banned != 1)
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm" onclick="confirm_ban('{{route('customers.ban', encrypt($user->id))}}');" title="{{ translate('Ban this Customer') }}">
                                        <i class="las la-user-slash"></i>
                                    </a>
                                    @else
                                    <a href="#" class="btn btn-soft-success btn-icon btn-circle btn-sm" onclick="confirm_unban('{{route('customers.ban', encrypt($user->id))}}');" title="{{ translate('Unban this Customer') }}">
                                        <i class="las la-user-check"></i>
                                    </a>
                                    @endif
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('customers.destroy', $user->id)}}" title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                    @if($user->is_salesperson != 1)
                                        <a href="javascript:void(0)" class="btn btn-soft-success btn-icon btn-circle btn-sm" onclick="updateSalesperson(this)" data-id="{{ $user->id }}"  title="{{ translate('Select Salesperson') }}" data-salesperson_id="{{ $user->salesperson_id }}">
                                            <i class="las la-sitemap"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $users->appends(request()->input())->links() }}
            </div>
        </div>
    </form>
</div>


<div class="modal fade" id="confirm-ban">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6">{{translate('Confirmation')}}</h5>
                <button type="button" class="close" data-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>{{translate('Do you really want to ban this Customer?')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
                <a type="button" id="confirmation" class="btn btn-primary">{{translate('Proceed!')}}</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm-unban">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6">{{translate('Confirmation')}}</h5>
                <button type="button" class="close" data-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>{{translate('Do you really want to unban this Customer?')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
                <a type="button" id="confirmationunban" class="btn btn-primary">{{translate('Proceed!')}}</a>
            </div>
        </div>
    </div>
</div>

<div id="info-modal" class="modal fade">
    <div class="modal-dialog" style="max-width: 1002px !important;">
        <div class="modal-content" style="height: 450px !important;">
            <div class="modal-header">
                <h5 class="modal-title h6">{{ translate('Update Salesperson') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                </button>
            </div>
            <div class="modal-body c-scrollbar-light position-relative" id="info-modal-content">
                <div class="c-preloader text-center absolute-center">
                    <i class="las la-spinner la-spin la-3x opacity-70"></i>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">

        function updateSalesperson(e){

            $('#info-modal-content').html('<div class="c-preloader text-center absolute-center"><i class="las la-spinner la-spin la-3x opacity-70"></i></div>');
            var id = $(e).data('id');
            var selected_id = $(e).data('salesperson_id');
            $('#info-modal').modal('show');
            
            $.post('{{ route('users.update-salesperson') }}', {_token: AIZ.data.csrf, id:id, selected_id:selected_id}, function(data){
                $('#info-modal-content').html(data);
            });

        }

        $(document).on("change", ".check-all", function() {
            if(this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;                        
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;                       
                });
            }
          
        });
        
        function sort_customers(el){
            $('#sort_customers').submit();
        }
        function confirm_ban(url)
        {
            $('#confirm-ban').modal('show', {backdrop: 'static'});
            document.getElementById('confirmation').setAttribute('href' , url);
        }

        function confirm_unban(url)
        {
            $('#confirm-unban').modal('show', {backdrop: 'static'});
            document.getElementById('confirmationunban').setAttribute('href' , url);
        }
        
        function bulk_delete() {
            var data = new FormData($('#sort_customers')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('bulk-customer-delete')}}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response == 1) {
                        location.reload();
                    }
                }
            });
        }

        function add_salesperson(el){
            
            var selected = $(el).val();
            var mainid = $(el).data('mainid');
            if (selected != '') {
                $.post('{{ route('users.add-salesperson') }}', {_token:'{{ csrf_token() }}', selected:selected, mainid:mainid}, function(data){
                    if(data == 1){
                        AIZ.plugins.notify('success', '{{ translate('Add successfully') }}');
                        //update_product_child_content(mainid);
                    }
                    else{
                        AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                    }
                });                
            }

        }        
    </script>
@endsection
