@include('header')

<!-- Form specific js -->
<script src="{{ asset('js/form.js')}}"></script>

<!-- Customer Form -->
<div class="row card py-2">
        <form method="POST" action="{{ $endpoint }}" id="customerForm">
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br/>
                    @endforeach
                </div>
            @endif

            <div class="form-group row py-2">
                <label for="firstName" class="col-sm-2 col-form-label">{{ __('First Name') }}</label>
                <div class="col-sm-10">
                    <input type="text" name="first_name" value="{{ $customer->first_name ?? old('first_name') }}" class="@if($errors->has('first_name')) is-invalid @endif form-control" id="firstName" placeholder="{{ __('First Name') }}"/>
                </div>
            </div>

            <div class="form-group row py-2">
                <label for="lastName" class="col-sm-2 col-form-label">{{ __('Last Name') }}</label>
                <div class="col-sm-10">
                    <input type="text" name="last_name" value="{{ $customer->last_name ?? old('last_name') }}" class="@if($errors->has('last_name')) is-invalid @endif form-control" id="lastName" placeholder="{{ __('Last Name') }}"/>
                </div>
            </div>

            <div class="form-group row py-2">
                <label for="email" class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                <div class="col-sm-10">
                    <input type="text" name="email" value="{{ $customer->email ?? old('email') }}" class="@if($errors->has('email')) is-invalid @endif form-control" id="email" placeholder="{{ __('Email') }}"/>
                </div>
            </div>

            <div class="form-group row py-2">
                <label for="email" class="col-sm-2 col-form-label">{{ __('Password') }}</label>
                <div class="col-sm-10">
                    <input type="password" name="password" value="{{ $customer->password ?? old('password') }}" class="@if($errors->has('password')) is-invalid @endif form-control" id="password" placeholder="{{ __('Password') }}"/>
                </div>
            </div>

            <div class="form-group row py-2">
                <label for="roles" class="col-sm-2 col-form-label">{{ __('Roles') }}</label>
                <div class="col-sm-10" id="roles">
                        @foreach($allowedRoles as $allowedRole)
                            <input class="form-check-input" id="role-{{ $allowedRole->id }}" type="checkbox" name="roles[]" @if((isset($customer) && in_array($allowedRole->id, $customerRoles)) || (old('roles') && in_array($allowedRole->id, old('roles')))) checked @endif value="{{ $allowedRole->id }}"> <label class="form-check-label" for="role-{{ $allowedRole->id }}">{{ $allowedRole->name }}</label><br/>
                        @endforeach
                </div>
            </div>

            <div class="form-group row py-2">
                <label for="meta" class="col-sm-2 col-form-label">{{ __('Meta') }}</label>
                <div class="col-sm-10">
                    @foreach ($allowedMeta as $meta)
                        <div class="form-group row py-2">
                            <label for="customer-meta-{{ $meta['value'] }}" class="col-sm-2 col-form-label">{{ $meta['prettyName']  }}</label>
                            <div class="col-sm-10">
                                <input type="text" name="meta[{{ $meta['value'] }}]" value="{{ $customerMeta[$meta['name']]['value'] ?? old('meta.' . $meta['value']) }}" class="form-control" id="customer-meta-{{ $meta['value'] }}" placeholder=""/>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group row py-2">
                <div class="col-sm-4"></div>
                <div class="col-sm-4 text-center">
                    <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </form>
</div>

<!-- Footer -->
@include('footer')
