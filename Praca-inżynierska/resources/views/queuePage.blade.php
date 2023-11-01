@extends('layouts.app', ['page' => __('Queue'), 'pageSlug' => 'queuePage'])

@section('content')

    <div class="header py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6">
                        <h1 class="text-white">{{ __('Queue for ') }} <br> {{ $charging_station->postcode}} {{ $charging_station->city }} {{ $charging_station->street }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card card-tasks">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-8">
                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#queueModal" >
                                <h3 class="card-title">Enroll <i class="tim-icons icon-double-right text-success"></i></h3>
                            </button>
                        </div>
                        <div class="col-lg-4">
                            <form method="post" action="{{ route('leave', $charging_station) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" rel="tooltip" class="btn btn-link">
                                    <h3 class="card-title">Leave <i class="tim-icons icon-double-right text-danger"></i></h3>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="modal fade" id="queueModal" tabindex="-1" role="dialog" aria-labelledby="queueModal" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="queueModal">{{ __('Determine your charging time') }}</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="tim-icons icon-simple-remove"></i>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <form method="post" action="{{ route('enroll', $charging_station) }}" autocomplete="off">
                                        @csrf
                                        @method('post')

                                        @include('alerts.success')

                                        <input type="datetime-local" id="start_time" name="start_time" value="2023-10-24T20:20" min="{{ date('Y-m-dTH:i') }}" max="{{ date('Y-m-dTH:i') }}">
                                        <input type="datetime-local" id="end_time" name="end_time" value="2018-06-07T00:00" min="{{ date('Y-m-dTH:i') }}" max="{{ date('Y-m-dTH:i') }}">

                                        {{-- <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <input type="text" name="charging_start_time" class="form-control{{ $errors->has('charging_start_time') ? ' is-invalid' : '' }}" placeholder="{{ __('Charging start time') }}">
                                                @include('alerts.feedback', ['field' => 'name'])
                                            </div>

                                            <div class="form-group col-md-6">
                                                <input type="text" name="charging_end_time" class="form-control{{ $errors->has('charging_end_time') ? ' is-invalid' : '' }}" placeholder="{{ __('Charging end time') }}">
                                                @include('alerts.feedback', ['field' => 'name'])
                                            </div>
                                        </div> --}}

                                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Enroll!') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body ">
                    <div class="table-full-width table-responsive">
                        <table class="table">
                            <thead class=" text-primary">
                                <tr>
                                    <th class="text-center">
                                        User
                                    </th>
                                    <th class="text-center">
                                        Signed at
                                    </th>
                                    <th class="text-center">
                                        Starts at
                                    </th>
                                    <th class="text-center">
                                        Ends at
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $u)
                                    <tr>
                                        <td class="text-center">
                                            {{ $u->name }}
                                        </td>
                                        <td class="text-center">
                                            {{ $u->sign_up_time }}
                                        </td>
                                        <td class="text-center">
                                            {{ $u->start_time }}
                                        </td>
                                        <td class="text-center">
                                            {{ $u->end_time }}
                                        </td>
                                    </tr>
                                @empty

                                    <tr>
                                        <th>Nobody in queue</th>
                                    </tr>

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
