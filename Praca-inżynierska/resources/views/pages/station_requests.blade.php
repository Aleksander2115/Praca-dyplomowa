@extends('layouts.app', ['pageSlug' => 'station_requests'])

@section('content')
    <div class="header py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ __('Welcome!') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-body text-center mb-7">
        <div class="card ">
            <div class="card-header">
                <h4 class="card-title">Charging stations</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table tablesorter" id="">
                        <thead class=" text-primary">
                            <tr>
                                <th class="text-center">
                                    Postcode
                                </th>
                                <th class="text-center">
                                    City
                                </th>
                                <th class="text-center">
                                    Street
                                </th>
                                <th class="text-center">
                                    Street number
                                </th>
                                <th class="text-center">
                                    Number of chargers
                                </th>
                                <th class="text-center">
                                    Is verified
                                </th>
                                <th class="text-right">
                                    Verify
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($charging_stations as $charging_station)
                            <tr>
                                <td class="text-center">
                                    {{ $charging_station->postcode }}
                                </td>
                                <td class="text-center">
                                    {{ $charging_station->city }}
                                </td>
                                <td class="text-center">
                                    {{ $charging_station->street }}
                                </td>
                                <td class="text-center">
                                    {{ $charging_station->street_number }}
                                </td>
                                <td class="text-center">
                                    {{ $charging_station->number_of_chargers }}
                                </td>
                                <td class="text-center">
                                    {{ $charging_station->is_verified }}
                                </td>
                                <td class="td-actions text-right">
                                    <form method="post" action="{{ route('verifyStation', $charging_station->id) }}">
                                        @csrf
                                        @method('put')
                                        <input type="submit" rel="tooltip" class="btn btn-success btn-sm btn-icon tim-icons icon-simple-remove" value="VER">
                                    </form>
                                </td>
                            </tr>
                        </tbody>

                        @empty

                        <tr>
                            <th>No stations to verify</th>
                        </tr>

                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
