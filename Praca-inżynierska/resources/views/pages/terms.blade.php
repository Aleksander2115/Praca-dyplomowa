@extends('layouts.app', ['page' => __('Terms'), 'pageSlug' => 'terms'])

@section('content')
    <div class="header py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">Terms and regulations</h1>
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

    @if (Auth::user()->roles()->where('role_name', 'mod')->exists())
        <div class="w-5 m-auto">
            <button type="button" class="btn btn-success btn-lg btn-icon tim-icons icon-simple-add" data-toggle="modal" data-target="#termAddModal"></button>
        </div>
    @endif


    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h4 class="card-title">Terms and regulations</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table tablesorter" id="">
                        <thead class=" text-primary">
                            <tr>
                                <th>
                                    Term/regulation
                                </th>
                                @if (Auth::user()->roles()->where('role_name', 'mod')->exists())
                                    <th class="text-right">
                                        Options
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($terms as $t)
                                <tr>
                                    <td class="text-left">
                                        {{ $loop->iteration.'. ' }}
                                        {{ $t->term }}
                                    </td>

                                    @if (Auth::user()->roles()->where('role_name', 'mod')->exists())
                                        <div class="row">
                                            <td class="td-actions text-right">
                                                <button type="button" data-t="{{ $t->term }}" class="btn btn-success btn-sm btn-icon tim-icons icon-pencil" data-toggle="modal" data-target="#termEditModal"></button>

                                                <form method="post" action="{{ route('deleteTerm', $t->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" rel="tooltip" class="btn btn-danger btn-sm btn-icon tim-icons icon-simple-remove">
                                                </form>
                                            </td>
                                        </div>
                                    @endif

                                </tr>
                        </tbody>

                        {{-- edit term --}}
                        <div class="modal fade" id="termEditModal" tabindex="-1" role="dialog" aria-labelledby="termEditModal" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="w-25 m-auto">
                                            <h3 class="modal-title" id="termEditModal">{{ __('Edit term') }}</h3>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i class="tim-icons icon-simple-remove"></i>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <form method="post" action="{{ route('editTerm', $t) }}" autocomplete="off">
                                            @csrf
                                            @method('patch')

                                                <div class="text-left">
                                                    <input type="text" id="term" name="term" style="width: 450px" value="{{ $t->term }}">
                                                </div>

                                            <div class="w-25 m-auto">
                                                <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <th>
                                EMPTY
                            </th>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- add term --}}
    <div class="modal fade" id="termAddModal" tabindex="-1" role="dialog" aria-labelledby="termAddModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="w-40 m-auto">
                        <h3 class="modal-title" id="termAddModal">{{ __('Add new term') }}</h3>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="tim-icons icon-simple-remove"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form method="post" action="{{ route('addTerm') }}" autocomplete="off">
                        @csrf
                        @method('put')

                            <div class="text-left">
                                <input type="text" id="term" name="term" style="width: 450px">
                            </div>

                        <div class="w-25 m-auto">
                            <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
