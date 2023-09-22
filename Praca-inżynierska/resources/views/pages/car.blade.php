@extends('layouts.app', ['page' => __('car'), 'pageSlug' => 'addCarView'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="title">{{ __('Add a car') }}</h3>
            </div>
            <form method="post" action="{{ route('addCar') }}" autocomplete="off">
                <div class="card-body">

                    @csrf
                    @method('put')

                    @include('alerts.success')

                    <label>{{ __('Brand') }}</label>
                    <input type="text" name="brand" class="form-control{{ $errors->has('brand') ? ' is-invalid' : '' }}" placeholder="{{ __('Brand') }}">
                    @include('alerts.feedback', ['field' => 'name'])

                    <label>{{ __('Model') }}</label>
                    <input type="text" name="model" class="form-control{{ $errors->has('model') ? ' is-invalid' : '' }}" placeholder="{{ __('Model') }}">
                    @include('alerts.feedback', ['field' => 'email'])

                    <label>{{ __('Year of production') }}</label>
                    <input type="text" name="year_of_production" class="form-control{{ $errors->has('year_of_production') ? ' is-invalid' : '' }}" placeholder="{{ __('Year of production') }}">
                    @include('alerts.feedback', ['field' => 'year_of_production'])

                    <label>{{ __('Licence plate number') }}</label>
                    <input type="text" name="licence_plate_number" class="form-control{{ $errors->has('licence_plate_number') ? ' is-invalid' : '' }}" placeholder="{{ __('Licence plate number') }}">
                    @include('alerts.feedback', ['field' => 'licence_plate_number'])

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">{{ __('ADD') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
