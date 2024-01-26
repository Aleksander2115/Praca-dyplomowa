@extends('layouts.app', ['page' => __('User cars'), 'pageSlug' => 'userCars'])

@section('content')
    <div class="header py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ Auth::user()->name}}&apos;{{ __('s cars') }}</h1>
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

    <div class="header-body text-center mb-7">
        <div class="card ">
            <div class="card-header">
                <a href="{{ route('addCarView') }}" class="btn btn-link float-right">
                    <h3 class="card-title">Add Car <i class="tim-icons icon-simple-add text-success"></i></h3>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table tablesorter" id="">
                        <thead class=" text-primary">
                            <tr>
                                <th class="text-center">
                                    In use?
                                </th>
                                <th class="text-center">
                                    Brand
                                </th>
                                <th class="text-center">
                                    Model
                                </th>
                                <th class="text-center">
                                    Year of production
                                </th>
                                <th class="text-center">
                                    Licence plate
                                </th>
                                <th class="text-center">
                                    Plug type
                                </th>
                                <th class="text-right">
                                    Options
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse (Auth::user()->cars as $car)
                            <tr>
                                <td class="text_center">
                                    @if ($car->in_use === 1)
                                        <a href="{{ route('inUse', $car) }}">
                                            <i class="tim-icons icon-check-2"></i>
                                        </a>
                                    @elseif ($car->in_use === 0)
                                        <a href="{{ route('inUse', $car) }}">
                                            <i class="tim-icons icon-simple-remove"></i>
                                        </a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ $car->brand }}
                                </td>
                                <td class="text-center">
                                    {{ $car->model }}
                                </td>
                                <td class="text-center">
                                    {{ $car->year_of_pr }}
                                </td>
                                <td class="text-center">
                                    {{ $car->licence_plate_num }}
                                </td>
                                <td class="text-center">
                                    {{ $car->plug_type }}
                                </td>
                                <td class="td-actions text-right">
                                    <form method="post" action="{{ route('deleteCar', $car->id) }}">
                                        @csrf
                                        @method('delete')
                                        <input type="submit" rel="tooltip" class="btn btn-danger btn-sm btn-icon tim-icons icon-simple-remove" value="DEL">
                                    </form>
                                    <form method="post" action="{{ route('editCar', $car->id) }}">
                                        @csrf
                                        @method('patch')
                                        <input type="submit" rel="tooltip" class="btn btn-success btn-sm btn-icon tim-icons icon-simple-remove" value="UPD">
                                    </form>
                                </td>
                            </tr>
                        </tbody>

                        @empty

                        <tr>
                            <th>You don't have any cars</th>
                        </tr>

                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
