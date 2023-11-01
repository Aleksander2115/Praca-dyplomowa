@extends('layouts.app', ['page' => __('car'), 'pageSlug' => 'addCarView'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="title">{{ __('Update car data') }}</h3>
            </div>
            <form method="post" action="{{ route('updateCar', ['car'=>$car]) }}" autocomplete="off">
                <div class="card-body">

                    @csrf
                    @method('put')

                    @include('alerts.success')

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>{{ __('Brand') }}</label>
                            <input type="text" name="brand" class="form-control{{ $errors->has('brand') ? ' is-invalid' : '' }}" placeholder="{{ __('Brand') }}" value="{{$car->brand}}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{ __('Model') }}</label>
                            <input type="text" name="model" class="form-control{{ $errors->has('model') ? ' is-invalid' : '' }}" placeholder="{{ __('Model') }}" value="{{$car->model}}">
                            @include('alerts.feedback', ['field' => 'email'])
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>{{ __('Year of production') }}</label>
                            <input type="text" name="year_of_production" class="form-control{{ $errors->has('year_of_production') ? ' is-invalid' : '' }}" placeholder="{{ __('Year of production') }}" value="{{$car->year_of_pr}}">
                            @include('alerts.feedback', ['field' => 'year_of_production'])
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{ __('Licence plate number') }}</label>
                            <input type="text" name="licence_plate_number" class="form-control{{ $errors->has('licence_plate_number') ? ' is-invalid' : '' }}" placeholder="{{ __('Licence plate number') }}" value="{{$car->licence_plate_num}}">
                            @include('alerts.feedback', ['field' => 'licence_plate_number'])
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
