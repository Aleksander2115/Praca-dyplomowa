<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            @if (Auth::user()->roles()->where('role_name', 'user')->exists())

                @if (Auth::user()->cars()->where('in_use','1')->exists())
                    <a class="simple-text logo-normal">Car in use: <br>{{ Auth::user()->cars->where('in_use','1')->first()->brand }}
                        {{ Auth::user()->cars->where('in_use','1')->first()->model }}
                        {{ Auth::user()->cars->where('in_use','1')->first()->licence_plate_num }}
                    </a>
                @else
                    <a href="{{ route('userCars') }}" class="simple-text logo-normal">
                        Choose your car <i class="tim-icons icon-minimal-left"></i>
                    </a>
                @endif

            @elseif(Auth::user()->roles()->where('role_name', 'admin')->exists())

                <a class="simple-text logo-normal">Admin's page</a>

            @elseif (Auth::user()->roles()->where('role_name', 'mod')->exists())

                <a class="slimple-text logo-normal">Mod's page</a>

            @endif
        </div>
        <ul class="nav">
            @if (Auth::user()->roles()->where('role_name', 'user')->exists())
                <li @if ($pageSlug == 'userPage') class="active " @endif>
                    <a href="{{ route('userPage') }}">
                        <i class="tim-icons icon-bank"></i>
                        <p>{{ __('Home') }}</p>
                    </a>
                </li>

                <li @if ($pageSlug == 'userCars') class="active " @endif>
                    <a href="{{ route('userCars') }}">
                        <i class="tim-icons icon-bus-front-12"></i>
                        <p>{{ __('Cars') }}</p>
                    </a>
                </li>

                <li @if ($pageSlug == 'addStationView') class="active " @endif>
                    <a href="{{ route('addStationView') }}">
                        <i class="tim-icons icon-simple-add"></i>
                        <p>{{ __('Suggest Station') }}</p>
                    </a>
                </li>

                <li @if ($pageSlug == 'terms') class="active " @endif>
                    <a href="{{ route('termsPage') }}">
                        <i class="tim-icons icon-alert-circle-exc"></i>
                        <p>{{ __('Terms and regulations') }}</p>
                    </a>
                </li>
            @elseif (Auth::user()->roles()->where('role_name', 'mod')->exists())
                <li @if ($pageSlug == 'modPage') class="active " @endif>
                    <a href="{{ route('modPage') }}">
                        <i class="tim-icons icon-bank"></i>
                        <p>{{ __('Home') }}</p>
                    </a>
                </li>
                <li @if ($pageSlug == 'addStationView') class="active " @endif>
                    <a href="{{ route('addStationView') }}">
                        <i class="tim-icons icon-simple-add"></i>
                        <p>{{ __('Add Station') }}</p>
                    </a>
                </li>
                <li @if ($pageSlug == 'station_requests') class="active " @endif>
                    <a href="{{ route('station_requests') }}">
                        <i class="tim-icons icon-simple-add"></i>
                        <p>{{ __('Requests') }}</p>
                    </a>
                </li>
                <li @if ($pageSlug == 'terms') class="active " @endif>
                    <a href="{{ route('termsPage') }}">
                        <i class="tim-icons icon-alert-circle-exc"></i>
                        <p>{{ __('Terms and regulations') }}</p>
                    </a>
                </li>
            @endif
            {{-- <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#laravel-examples" aria-expanded="true">
                    <i class="fab fa-laravel" ></i>
                    <span class="nav-link-text" >{{ __('Laravel Examples') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse hide" id="laravel-examples">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'profile') class="active " @endif>
                            <a href="{{ route('profile.edit')  }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('User Profile') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'users') class="active " @endif>
                            <a href="{{ route('user.index')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('User Management') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li @if ($pageSlug == 'icons') class="active " @endif>
                <a href="{{ route('pages.icons') }}">
                    <i class="tim-icons icon-atom"></i>
                    <p>{{ __('Icons') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'maps') class="active " @endif>
                <a href="{{ route('pages.maps') }}">
                    <i class="tim-icons icon-pin"></i>
                    <p>{{ __('Maps') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'notifications') class="active " @endif>
                <a href="{{ route('pages.notifications') }}">
                    <i class="tim-icons icon-bell-55"></i>
                    <p>{{ __('Notifications') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'tables') class="active " @endif>
                <a href="{{ route('pages.tables') }}">
                    <i class="tim-icons icon-puzzle-10"></i>
                    <p>{{ __('Table List') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'typography') class="active " @endif>
                <a href="{{ route('pages.typography') }}">
                    <i class="tim-icons icon-align-center"></i>
                    <p>{{ __('Typography') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'rtl') class="active " @endif>
                <a href="{{ route('pages.rtl') }}">
                    <i class="tim-icons icon-world"></i>
                    <p>{{ __('RTL Support') }}</p>
                </a>
            </li>
            <li class=" {{ $pageSlug == 'upgrade' ? 'active' : '' }} bg-info">
                <a href="{{ route('pages.upgrade') }}">
                    <i class="tim-icons icon-spaceship"></i>
                    <p>{{ __('Upgrade to PRO') }}</p>
                </a>
            </li> --}}
        </ul>
    </div>
</div>
