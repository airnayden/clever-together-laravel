@include('header')

@if ($order == 'ASC')
    @php $newOrder = 'DESC' @endphp
    @php $sortIcon = 'fa-arrow-up' @endphp
@else
    @php $newOrder = 'ASC' @endphp
    @php $sortIcon = 'fa-arrow-down' @endphp
@endif

<!-- Buttons -->
<div class="row py-2">
    <div class="col-sm-4">
        <a href="{{ route('customer.form_store') }}" type="button" class="btn btn-success"><i class="fa fa-add"></i> {{ __('Add Customer') }}</a>
    </div>
    <div class="btn-group col-sm-4" role="group" aria-label="Add New Customer">
    </div>
    <div class="col-sm-4">
        <div class="input-group">
            <input type="text" id="customerSearchCriteria" class="form-control" placeholder="{{ __('First name, last name, email...') }}" aria-label="Input group example" aria-describedby="btnGroupAddon" value="{{ $search }}">
            <div class="input-group-append">
                <div class="input-group-text" id="btnGroupAddon">
                    <button data-endpoint="{{ route('customer.index') }}" class="btn btn-primary" id="customerSearch">{{ __('Search') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Customer Index Table -->
<div class="row py-2">
    <table class="table table-bordered data-table">
        <thead>
        <tr>
            <th>
                <a href="{{ route('customer.index', ['sort' => 'id', 'order' => $newOrder, 'limit' => $limit, 'page' => $page, 'search' => $search]) }}"># @if ($sort == 'id') <i class="fa {{ $sortIcon }}"></i>@endif</a>
            </th>
            <th>
                <a href="{{ route('customer.index', ['sort' => 'first_name', 'order' => $newOrder, 'limit' => $limit, 'page' => $page, 'search' => $search]) }}">{{ __('First Name') }} @if ($sort == 'first_name') <i class="fa {{ $sortIcon }}"></i>@endif</a>
            </th>
            <th>
                <a href="{{ route('customer.index', ['sort' => 'last_name', 'order' => $newOrder, 'limit' => $limit, 'page' => $page, 'search' => $search]) }}">{{ __('Last Name') }} @if ($sort == 'last_name') <i class="fa {{ $sortIcon }}"></i>@endif</a>
            </th>
            <th>
                <a href="{{ route('customer.index', ['sort' => 'email', 'order' => $newOrder, 'limit' => $limit, 'page' => $page, 'search' => $search]) }}">{{ __('Email') }} @if ($sort == 'email') <i class="fa {{ $sortIcon }}"></i>@endif</a>
            </th>
            <th>{{ __('Roles') }}</th>
            <th class="text-center">{{ __('Actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @forelse($customers as $customer)
            <tr>
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->first_name }}</td>
                <td>{{ $customer->last_name }}</td>
                <td>{{ $customer->email }}</td>
                <td>
                    @foreach($customer->roles as $role)
                        {{ $role->name }}<br/>
                    @endforeach
                </td>
                <td class="text-center">
                    <button data-href="{{ route('customer.show', ['customer_id' => $customer->id]) }}" class="btn btn-success customer-show" data-toggle="tooltip" data-placement="top" title="{{ __('Show') }}"><i class="fa fa-eye"></i></button>

                    <a href="{{ route('customer.form_update', ['customer_id' => $customer->id]) }}" class="btn btn-warning customer-update" data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}"><i class="fa fa-pencil"></i></a>

                    <button data-form-action="{{ route('customer.destroy', ['customer_id' => $customer->id, 'sort' => 'last_name', 'order' => $newOrder, 'limit' => $limit, 'page' => $page, 'search' => $search]) }}" class="customer-delete btn btn-danger" data-toggle="tooltip" data-placement="top" title="{{ __('Delete') }}"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">{{ __('No results :(') }}</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {!! $customers->withQueryString()->links('pagination::bootstrap-5') !!}
</div>

<!-- Modal -->
<div class="modal fade" id="customerModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Customer Details') }}</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
@include('footer')

