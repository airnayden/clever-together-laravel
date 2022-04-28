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
                <td colspan="2" class="text-right">
                    <a href="{{ route('customer.form_update', ['customer_id' => $customer->id]) }}" class="btn btn-warning customer-update" data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}"><i class="fa fa-pencil"></i></a>

                    <button data-customer-id="{{ $customer->id }}" class="customer-delete btn btn-danger" data-toggle="tooltip" data-placement="top" title="{{ __('Delete') }}"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
