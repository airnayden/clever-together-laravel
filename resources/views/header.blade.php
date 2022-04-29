<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="{{ asset('js/common.js')}}"></script>
    <title>{{ $pageTitle }}</title>
</head>
<body>
    <div class="container py-2">
        <div class="row">
            <div class="col-sm-12 text-center card bg-light">
                <h1>{{ $pageTitle }}</h1>
            </div>
        </div>

        <!-- Buttons -->
        <div class="row py-2">
            <div class="col-sm-4">
                <a href="{{ route('customer.index') }}" type="button" class="btn btn-primary"><i class="fa fa-home"></i> {{ __('Home') }}</a>
                <a href="{{ route('customer.form_store') }}" type="button" class="btn btn-success"><i class="fa fa-add"></i> {{ __('Add Customer') }}</a>
            </div>
            <div class="btn-group col-sm-4" role="group" aria-label="Add New Customer">
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="text" id="customerSearchCriteria" class="form-control" placeholder="{{ __('First name, last name, email...') }}" aria-label="Input group example" aria-describedby="btnGroupAddon" value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <div class="input-group-text" id="btnGroupAddon">
                            <button data-endpoint="{{ route('customer.index') }}" class="btn btn-primary" id="customerSearch">{{ __('Search') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
