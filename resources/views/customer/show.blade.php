@if (isset($order) && $order == 'ASC')
    @php $newOrder = 'DESC' @endphp
@else
    @php $newOrder = 'ASC' @endphp
@endif

@if(isset($success))
    <div class="alert alert-success" role="alert">
        {{ $success }}
    </div>
@endif

<div class="row">
    <table class="table table-bordered data-table">
        <tbody>
            <tr>
                <td class="col-sm-3">#</td>
                <td>{{ $customer->id }}</td>
            </tr>
            <tr>
                <td class="col-sm-3">{{ __('First Name') }}</td>
                <td>{{ $customer->first_name }}</td>
            </tr>
            <tr>
                <td class="col-sm-3">{{ __('Last Name') }}</td>
                <td>{{ $customer->last_name }}</td>
            </tr>
            <tr>
                <td class="col-sm-3">{{ __('Email') }}</td>
                <td>{{ $customer->email }}</td>
            </tr>
            <tr>
                <td class="col-sm-3">{{ __('Roles') }}</td>
                <td>
                    @foreach($customer->roles as $role)
                        {{ $role->name }}<br/>
                    @endforeach
                </td>
            </tr>

            <tr>
                <td class="col-sm-3">{{ __('Meta') }}</td>
                <td>
                    <table class="table table-bordered data-table">
                        @foreach($customer->meta as $meta)
                            <tr>
                                <td class="col-sm-3">{{ ucwords(Str::lower(str_replace('_', ' ', $meta->code->name))) }}</td>
                                <td>{{ $meta->value }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="text-right">
                    <a href="{{ route('customer.form_update', ['customer_id' => $customer->id, 'sort' => 'last_name', 'order' => $newOrder, 'limit' => $limit ?? '', 'page' => $page ?? '', 'search' => $search ?? '']) }}" class="btn btn-warning customer-update" data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}"><i class="fa fa-pencil"></i></a>

                    <button data-form-action="{{ route('customer.destroy', ['customer_id' => $customer->id, 'sort' => 'last_name', 'order' => $newOrder ?? '', 'limit' => $limit ?? '', 'page' => $page ?? '', 'search' => $search ?? '']) }}" class="customer-delete btn btn-danger" data-toggle="tooltip" data-placement="top" title="{{ __('Delete') }}"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
