@extends('layouts.app', ['page' => __('Queue'), 'pageSlug' => 'queuePage'])

@section('content')

    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}

        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
            <i class="tim-icons icon-simple-remove"></i>
        </button>
    </div>
    @elseif (session('alert'))
    <div class="alert alert-danger">
        {{ session('alert') }}

        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
            <i class="tim-icons icon-simple-remove"></i>
        </button>
    </div>
    @endif

    <div class="header py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6">
                        <h1 class="text-white">{{ __('Queue for ') }} <br> {{ $charging_station->postcode}} {{ $charging_station->city }} {{ $charging_station->street }} {{ $charging_station->street_number }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        @if($charging_station->number_of_charging_points === 1)

        <div class="col-lg-12">
            <div class="card card-tasks">
                <div class="card-header">
                    <div class="row">
                        <div class="w-85 m-auto">
                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#queueModal" >
                                <h3 class="card-title">Enroll <i class="tim-icons icon-double-right text-success"></i></h3>
                            </button>
                        </div>

                        <div class="w-10">
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
                                    <div class="text-left">
                                        <h3 class="modal-title" id="queueModal">{{ __('Determine your charging time') }}</h3>
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="tim-icons icon-simple-remove"></i>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <form method="post" action="{{ route('enroll', $charging_station) }}" autocomplete="off">
                                        @csrf
                                        @method('post')

                                        <div class="form-row">
                                            <div class="w-50 m-auto">
                                                <input type="datetime-local" id="start_time" name="start_time" value="{{ Carbon\Carbon::now()->setSeconds(0)->toDateTimeString() }}"
                                                min="{{ Carbon\Carbon::now()->setSeconds(0)->addMinutes(5)->toDateTimeString() }}"
                                                max="{{ Carbon\Carbon::now()->setSeconds(0)->addDay()->toDateTimeString() }}">
                                            </div>
                                            <div class="w-35 m-auto">
                                                <input type="datetime-local" id="end_time" name="end_time" value="{{ Carbon\Carbon::now()->setSeconds(0)->toDateTimeString() }}"
                                                min="{{ Carbon\Carbon::now()->setSeconds(0)->addMinutes(15)->toDateTimeString() }}"
                                                max="{{ Carbon\Carbon::now()->setSeconds(0)->addDay()->toDateTimeString() }}">
                                            </div>
                                        </div>

                                        <div class="w-25 m-auto">
                                            <button type="submit" class="btn btn-fill btn-primary">{{ __('Enroll!') }}</button>
                                        </div>
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
                                        Car
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
                                            {{ $u->cars->where('in_use','1')->first()->brand }}
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

        @elseif($charging_station->number_of_charging_points === 2)

        {{-- 1 punkt --}}

        <div class="col-lg-6">

            <div class="row">
                <div class="header py-7 py-lg-8">
                    <div class="container">
                        <div class="header-body text-center mb-7">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-md-12">
                                    <h1 class="text-white">{{ __('Queue for point #1') }} </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-tasks">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#queueModal" >
                                <h3 class="card-title">Enroll <i class="tim-icons icon-double-right text-success"></i></h3>
                            </button>
                        </div>
                        <div class="col-lg-2">
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
                                    <div class="text-left">
                                        <h3 class="modal-title" id="queueModal">{{ __('Determine your charging time') }}</h3>
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="tim-icons icon-simple-remove"></i>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <form method="post" action="{{ route('enroll', $charging_station) }}" autocomplete="off">
                                        @csrf
                                        @method('post')

                                        <div class="form-row">
                                            <div class="w-50 m-auto">
                                                <input type="datetime-local" id="start_time" name="start_time" value="{{ Carbon\Carbon::now()->setSeconds(0)->toDateTimeString() }}"
                                                min="{{ Carbon\Carbon::now()->setSeconds(0)->addMinutes(5)->toDateTimeString() }}"
                                                max="{{ Carbon\Carbon::now()->setSeconds(0)->addDay()->toDateTimeString() }}">
                                            </div>
                                            <div class="w-35 m-auto">
                                                <input type="datetime-local" id="end_time" name="end_time" value="{{ Carbon\Carbon::now()->setSeconds(0)->toDateTimeString() }}"
                                                min="{{ Carbon\Carbon::now()->setSeconds(0)->addMinutes(15)->toDateTimeString() }}"
                                                max="{{ Carbon\Carbon::now()->setSeconds(0)->addDay()->toDateTimeString() }}">
                                            </div>
                                        </div>

                                        <div class="w-30 m-auto">
                                            <button type="submit" class="btn btn-fill btn-primary">{{ __('Enroll!') }}</button>
                                        </div>
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
                                        Car
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
                                            {{ $u->cars->where('in_use','1')->first()->brand }}
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

        {{-- 2 punkt --}}

        <div class="col-lg-6">

            <div class="row">
                <div class="header py-7 py-lg-8">
                    <div class="container">
                        <div class="header-body text-right mb-7">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-md-12">
                                    <h1 class="text-white">{{ __('Queue for point #2') }} </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-tasks">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#queueModal2" >
                                <h3 class="card-title">Enroll <i class="tim-icons icon-double-right text-success"></i></h3>
                            </button>
                        </div>
                        <div class="col-lg-2">
                            <form method="post" action="{{ route('leave2', $charging_station) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" rel="tooltip" class="btn btn-link">
                                    <h3 class="card-title">Leave <i class="tim-icons icon-double-right text-danger"></i></h3>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="modal fade" id="queueModal2" tabindex="-1" role="dialog" aria-labelledby="queueModal2" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="text-left">
                                        <h3 class="modal-title" id="queueModal2">{{ __('Determine your charging time') }}</h3>
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="tim-icons icon-simple-remove"></i>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <form method="post" action="{{ route('enroll2', $charging_station) }}" autocomplete="off">
                                        @csrf
                                        @method('post')

                                        <div class="form-row">
                                            <div class="w-50 m-auto">
                                                <input type="datetime-local" id="start_time2" name="start_time2" value="{{ Carbon\Carbon::now()->setSeconds(0)->toDateTimeString() }}"
                                                min="{{ Carbon\Carbon::now()->setSeconds(0)->addMinutes(5)->toDateTimeString() }}"
                                                max="{{ Carbon\Carbon::now()->setSeconds(0)->addDay()->toDateTimeString() }}">
                                            </div>
                                            <div class="w-35 m-auto">
                                                <input type="datetime-local" id="end_time2" name="end_time2" value="{{ Carbon\Carbon::now()->setSeconds(0)->toDateTimeString() }}"
                                                min="{{ Carbon\Carbon::now()->setSeconds(0)->addMinutes(15)->toDateTimeString() }}"
                                                max="{{ Carbon\Carbon::now()->setSeconds(0)->addDay()->toDateTimeString() }}">
                                            </div>
                                        </div>

                                        <div class="w-30 m-auto">
                                            <button type="submit" class="btn btn-fill btn-primary">{{ __('Enroll!') }}</button>
                                        </div>
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
                                        Car
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
                                @forelse ($users2 as $u2)
                                    <tr>
                                        <td class="text-center">
                                            {{ $u2->name }}
                                        </td>
                                        <td class="text-center">
                                            {{ $u2->cars->where('in_use','1')->first()->brand }}
                                        </td>
                                        <td class="text-center">
                                            {{ $u2->sign_up_time }}
                                        </td>
                                        <td class="text-center">
                                            {{ $u2->start_time }}
                                        </td>
                                        <td class="text-center">
                                            {{ $u2->end_time }}
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

        @endif

    </div>
@endsection
