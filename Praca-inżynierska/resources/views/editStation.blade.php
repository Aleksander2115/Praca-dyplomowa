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
                        <div class="form-group col-md-6">
                            <label>{{ __('Street') }}</label>
                            <input type="text" name="street" class="form-control{{ $errors->has('street') ? ' is-invalid' : '' }}" placeholder="{{ __('Street') }}" value="{{$charging_station->street}}">
                            @include('alerts.feedback', ['field' => 'street'])
                        </div>
                        <div class="form-group col-md-3">
                            <label>{{ __('Street number') }}</label>
                            <input type="text" name="street_number" class="form-control{{ $errors->has('street_number') ? ' is-invalid' : '' }}" placeholder="{{ __('Street number') }}" value="{{$charging_station->street_number}}">
                            @include('alerts.feedback', ['field' => 'street_number'])
                        </div>
                        <div class="form-group col-md-3">
                            <label for="number_of_charging_points">{{ __('Number of charging points') }}</label>
                            <select class="form-control" id="number_of_charging_points" name="number_of_charging_points">
                                @if ($charging_station->number_of_charging_points === 1)
                                    <option selected>1</option>
                                    <option>2</option>
                                @else
                                    <option>1</option>
                                    <option selected>2</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    @if ($charging_station->number_of_charging_points === 1)

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="type_of_electric_current">{{ __('Type of electric current') }}</label>
                                <select class="form-control" id="type_of_electric_current" name="type_of_electric_current">
                                    @if ($charging_point->type_of_electric_current === 'AC')
                                        <option selected>AC</option>
                                        <option>DC</option>
                                    @else
                                        <option>AC</option>
                                        <option selected>DC</option>
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="plug_type">{{ __('Plug Type') }}</label>
                                <select class="form-control" id="plug_type" name="plug_type" value="{{$charging_point->plug_type}}">
                                    @if ($charging_point->plug_type === 'X')
                                        <option selected>X</option>
                                        <option>D</option>
                                    @else
                                        <option>X</option>
                                        <option selected>D</option>
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="power">{{ __('Power') }}</label>
                                <select class="form-control" id="power" name="power" value="{{$charging_point->power}}">
                                    @if ($charging_point->power === '6')
                                        <option selected>6</option>
                                        <option>11</option>
                                    @else
                                        <option>6</option>
                                        <option selected>11</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                    @else

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="type_of_electric_current">{{ __('Type of electric current') }}</label>
                                <select class="form-control" id="type_of_electric_current" name="type_of_electric_current">
                                    @if ($charging_point->type_of_electric_current === 'AC')
                                        <option selected>AC</option>
                                        <option>DC</option>
                                    @else
                                        <option>AC</option>
                                        <option selected>DC</option>
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="plug_type">{{ __('Plug Type') }}</label>
                                <select class="form-control" id="plug_type" name="plug_type" value="{{$charging_point->plug_type}}">
                                    @if ($charging_point->plug_type === 'X')
                                        <option selected>X</option>
                                        <option>D</option>
                                    @else
                                        <option>X</option>
                                        <option selected>D</option>
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="power">{{ __('Power') }}</label>
                                <select class="form-control" id="power" name="power" value="{{$charging_point->power}}">
                                    @if ($charging_point->power === '6')
                                        <option selected>6</option>
                                        <option>11</option>
                                    @else
                                        <option>6</option>
                                        <option selected>11</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="type_of_electric_current2">{{ __('Type of electric current') }}</label>
                                <select class="form-control" id="type_of_electric_current2" name="type_of_electric_current2">
                                    @if ($charging_point2->type_of_electric_current === 'AC')
                                        <option selected>AC</option>
                                        <option>DC</option>
                                    @else
                                        <option>AC</option>
                                        <option selected>DC</option>
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="plug_type2">{{ __('Plug Type') }}</label>
                                <select class="form-control" id="plug_type2" name="plug_type2">
                                    @if ($charging_point2->plug_type === 'X')
                                        <option selected>X</option>
                                        <option>D</option>
                                    @else
                                        <option>X</option>
                                        <option selected>D</option>
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="power2">{{ __('Power') }}</label>
                                <select class="form-control" id="power2" name="power2">
                                    @if ($charging_point2->power === '6')
                                        <option selected>6</option>
                                        <option>11</option>
                                    @else
                                        <option>6</option>
                                        <option selected>11</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                    @endif
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
