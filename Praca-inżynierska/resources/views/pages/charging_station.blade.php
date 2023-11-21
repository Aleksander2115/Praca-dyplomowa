@extends('layouts.app', ['page' => __('charging station'), 'pageSlug' => 'addStationView'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @if (Auth::user()->roles()->where('role_name', 'user')->exists())
                <div class="card-header">
                    <h3 class="title">{{ __('Suggest a charging station') }}</h3>
                </div>
            @elseif (Auth::user()->roles()->where('role_name', 'mod')->exists())
                <div class="card-header">
                    <h3 class="title">{{ __('Add a charging station') }}</h3>
                </div>
            @endif
            <form method="post" action="{{ route('addStation') }}" autocomplete="off">
                <div class="card-body">

                    @csrf
                    @method('post')

                    @include('alerts.success')

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>{{ __('Postcode') }}</label>
                            <input type="text" name="postcode" class="form-control{{ $errors->has('postcode') ? ' is-invalid' : '' }}" placeholder="{{ __('Postcode') }}">
                            @include('alerts.feedback', ['field' => 'postcode'])
                        </div>

                        <div class="form-group col-md-8">
                            <label>{{ __('City') }}</label>
                            <input type="text" name="city" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" placeholder="{{ __('City') }}">
                            @include('alerts.feedback', ['field' => 'city'])
                        </div>
                    </div>

                    <div x-data="{ open: false }">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>{{ __('Street') }}</label>
                            <input type="text" name="street" class="form-control{{ $errors->has('street') ? ' is-invalid' : '' }}" placeholder="{{ __('Street') }}">
                            @include('alerts.feedback', ['field' => 'street'])
                        </div>

                        <div class="form-group col-md-4">
                            <label>{{ __('Street number') }}</label>
                            <input type="text" name="street_number" class="form-control{{ $errors->has('street_number') ? ' is-invalid' : '' }}" placeholder="{{ __('Street number') }}">
                            @include('alerts.feedback', ['field' => 'street_number'])
                        </div>

                        <label>{{ __('Number of charging points') }}</label>
                        <div class="form-check form-check-radio form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" x-on:click="open = false" type="radio" name="number_of_charging_points" id="option1" value="1" checked> 1
                                <span class="form-check-sign"></span>
                            </label>
                        </div>

                        <div class="form-check form-check-radio form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" x-on:click="open = true" type="radio" name="number_of_charging_points" id="option2" value="2"> 2
                                <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="type_of_electric_current">{{ __('Type of electric current') }}</label>
                            <select class="form-control" id="type_of_electric_current" name="type_of_electric_current">
                                <option>AC</option>
                                <option>DC</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="plug_type">{{ __('Plug Type') }}</label>
                            <select class="form-control" id="plug_type" name="plug_type">
                                <option>X</option>
                                <option>D</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="power">{{ __('Power') }}</label>
                            <select class="form-control" id="power" name="power">
                                <option>6</option>
                                <option>11</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row" x-show="open">
                        <div class="form-group col-md-4">
                            <label for="type_of_electric_current">{{ __('Type of electric current') }}</label>
                            <select class="form-control" id="type_of_electric_current2" name="type_of_electric_current2">
                                <option>AC</option>
                                <option>DC</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="plug_type">{{ __('Plug Type') }}</label>
                            <select class="form-control" id="plug_type2" name="plug_type2">
                                <option>X</option>
                                <option>D</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="power">{{ __('Power') }}</label>
                            <select class="form-control" id="power2" name="power2">
                                <option>6</option>
                                <option>11</option>
                            </select>
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
