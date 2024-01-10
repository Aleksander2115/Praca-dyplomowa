@extends('layouts.app', ['page' => __('Home Page'), 'pageSlug' => 'userPage'])

@section('content')

    <div class="header py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6">
                        <h1 class="text-white">{{ __('List of available charging stations') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        <div class="card ">

                <form method="post" action="{{ route('filter') }}" autocomplete="off" id="filters">
                    @csrf
                    @method('post')

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>{{ __('FILTER BY POSTCODE ') }}</label>
                            <input type="text" name="postcode" class="form-control" placeholder="Postcode 00-000">
                        </div>

                        <div class="form-group col-md-4">
                            <label> {{ __('Show available') }} </label>
                            <div class="form-check form-check-radio form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="is_available_now" value="1">
                                    <span class="form-check-sign"></span>
                                </label>
                                <button type="submit" class="btn btn-success btn-icon">
                                    <i class="tim-icons icon-send"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

        </div>

    <div class="col-md-12">
        <div class="card ">
            <div class="card-body ">
                <div class="table-full-width table-responsive">
                    <table class="table">
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
                                    Number of charging points
                                </th>
                                <th class="text-center">
                                    Plug #1
                                </th>
                                <th class="text-center">
                                    Cars in queue #1
                                </th>
                                <th class="text-center">
                                    Plug #2
                                </th>
                                <th class="text-center">
                                    Cars in queue #2
                                </th>
                                <th class="text-center">
                                    Map
                                </th>
                                <th class="text-center">
                                    Queue
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($charStat as $cs)
                                <tr>
                                    <td class="text-center">
                                        {{ $cs->postcode }}
                                    </td>
                                    <td class="text-center">
                                        {{ $cs->city }}
                                    </td>
                                    <td class="text-center">
                                        {{ $cs->street }}
                                    </td>
                                    <td class="text-center">
                                        {{ $cs->street_number }}
                                    </td>
                                    <td class="text-center">
                                        {{ $cs->number_of_charging_points }}
                                    </td>
                                    <td class="text-center">
                                        Current: {{ $cs->charging_points->first()->type_of_electric_current }} <br>
                                        Plug: {{ $cs->charging_points->first()->plug_type }} <br>
                                        Power: {{ $cs->charging_points->first()->power }}
                                    </td>
                                    <td class="text-center">
                                        @if (count($cs->charging_points->first()->users) === 0)
                                            <p style="color:Chartreuse">0</p>
                                        @else
                                            <p style="color:Red">{{ count($cs->charging_points->first()->users) }}</p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($cs->number_of_charging_points === 1)
                                            ---
                                        @elseif ($cs->number_of_charging_points === 2)
                                            Current: {{ $cs->charging_points->skip(1)->take(1)->first()->type_of_electric_current }} <br>
                                            Plug: {{ $cs->charging_points->skip(1)->take(1)->first()->plug_type }} <br>
                                            Power: {{ $cs->charging_points->skip(1)->take(1)->first()->power }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($cs->number_of_charging_points === 1)
                                            ---
                                        @elseif ($cs->number_of_charging_points === 2)
                                            @if (count($cs->charging_points->skip(1)->take(1)->first()->users) === 0)
                                                <p style="color:Chartreuse">0</p>
                                            @else
                                                <p style="color:Red">{{ count($cs->charging_points->skip(1)->take(1)->first()->users) }}</p>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="td-actions text-center">
                                        <a href="{{ 'https://www.google.com/maps/place/' . $cs->postcode . " " . $cs->city . " " . $cs->street. " ". $cs->street_number}}" class="btn btn-info btn-icon" target="_blank">
                                            <i class="tim-icons icon-square-pin"></i>
                                        </a>
                                    </td>
                                    <td class="td-actions text-center">
                                        <a href="{{ route('queueView', [$cs]) }}" class="btn btn-danger btn-icon">
                                            <i class="tim-icons icon-bullet-list-67"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty

                                <tr>
                                    <th>No charging station available</th>
                                </tr>

                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
