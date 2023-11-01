@extends('layouts.app', ['page' => __('charging_station'), 'pageSlug' => 'editStationView'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="title">{{ __('Update charging station') }}</h3>
            </div>
            <form method="post" action="{{ route('updateStation', ['charging_station'=>$charging_station]) }}" autocomplete="off">
                <div class="card-body">

                    @csrf
                    @method('put')

                    @include('alerts.success')

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>{{ __('Postcode') }}</label>
                            <input type="text" name="postcode" class="form-control{{ $errors->has('postcode') ? ' is-invalid' : '' }}" placeholder="{{ __('Postcode') }}" value="{{$charging_station->postcode}}">
                            @include('alerts.feedback', ['field' => 'postcode'])
                        </div>
                        <div class="form-group col-md-8">
                            <label>{{ __('City') }}</label>
                            <input type="text" name="city" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" placeholder="{{ __('City') }}" value="{{$charging_station->city}}">
                            @include('alerts.feedback', ['field' => 'city'])
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>{{ __('Street') }}</label>
                            <input type="text" name="street" class="form-control{{ $errors->has('street') ? ' is-invalid' : '' }}" placeholder="{{ __('Street') }}" value="{{$charging_station->street}}">
                            @include('alerts.feedback', ['field' => 'street'])
                        </div>
                        <div class="form-group col-md-4">
                            <label>{{ __('Street number') }}</label>
                            <input type="text" name="street_number" class="form-control{{ $errors->has('street_number') ? ' is-invalid' : '' }}" placeholder="{{ __('Street number') }}" value="{{$charging_station->street_number}}">
                            @include('alerts.feedback', ['field' => 'street_number'])
                        </div>
                        <div class="form-group col-md-4">
                            <label>{{ __('Number of chargers') }}</label>
                            <input type="text" name="number_of_chargers" class="form-control{{ $errors->has('number_of_chargers') ? ' is-invalid' : '' }}" placeholder="{{ __('Number of chargers') }}" value="{{$charging_station->number_of_chargers}}">
                            @include('alerts.feedback', ['field' => 'number_of_chargers'])
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
