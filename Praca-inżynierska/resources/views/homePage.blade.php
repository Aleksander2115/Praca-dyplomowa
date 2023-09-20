@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')
    <div class="header py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ __('Dołącz do kolejki!') }}</h1>
                        <a href="{{ route('login') }}" class="btn btn-fill btn-primary">Dołącz</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
