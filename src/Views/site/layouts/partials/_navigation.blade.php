<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->

        {!! CW::getMenu('site-menu') !!}

        <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('causeway.login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('causeway.register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @role('admin')
                            <a class="dropdown-item" href="{{ route('causeway.dashboard') }}">
                                Admin Settings
                            </a>
                            @endrole
                            <a class="dropdown-item" href="{{ route('causeway.logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('causeway.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <cart-items-count-component :cart="{{ CWCart::summary() }}" cart_details_route="{{ route('shop.cart.details') }}"></cart-items-count-component>
                    <div class="dropdown-menu dropdown-menu-right mb-2 border-solid border-grey-light rounded border shadow-sm p-2">
                        <cart-totals-component :cart="{{ CWCart::summary() }}" cart_details_route="{{ route('shop.cart.details') }}"></cart-totals-component>
                        <a href="{{ route('shop.cart') }}" class="btn btn-info btn-block">{{ __('Show cart details') }}</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>