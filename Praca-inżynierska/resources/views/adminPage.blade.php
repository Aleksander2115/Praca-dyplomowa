@extends('layouts.app', ['pageSlug' => 'adminPage'])

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
                <h4 class="card-title">Roles management</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table tablesorter" id="">
                        <thead class=" text-primary">
                            <tr>
                                <th class="text-center">
                                    User ID
                                </th>
                                <th class="text-center">
                                    Name
                                </th>
                                <th class="text-center">
                                    Role
                                </th>
                                <th class="text-right">
                                    Options
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            @foreach ($user->roles as $pivot_role)

                            <tr>
                                <td class="text-center">
                                    {{ $user->id }}
                                </td>
                                <td class="text-center">
                                    {{ $user->name }}
                                </td>
                                <td class="text-center">
                                    {{ $pivot_role->pivot->role_id }}
                                </td>
                                <td class="td-actions text-right">
                                    <form method="post" action="{{ route('changeToAdmin', $user->id) }}">
                                        @csrf
                                        @method('patch')
                                        <input type="submit" rel="tooltip" class="btn btn-danger btn-sm btn-icon tim-icons icon-simple-remove" value="ADM">
                                    </form>
                                    <form method="post" action="{{ route('changeToUser', $user->id) }}">
                                        @csrf
                                        @method('patch')
                                        <input type="submit" rel="tooltip" class="btn btn-success btn-sm btn-icon tim-icons icon-simple-remove" value="USE">
                                    </form>
                                    <form method="post" action="{{ route('changeToMod', $user->id, $user->id) }}">
                                        @csrf
                                        @method('post')
                                        <input type="submit" rel="tooltip" class="btn btn-success btn-sm btn-icon tim-icons icon-simple-remove" value="MOD">
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        @empty

                        <tr>
                            <th>ADMIN ELO</th>
                        </tr>

                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
