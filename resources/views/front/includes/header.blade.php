<header>
    <div class="container">
        <div class="sixteen columns">
        
            <!-- Logo -->
            <div id="logo">
                <h1><a href="{{ route('home') }}"><img src="{{ asset('assets/images/logo.png') }}" alt="{{ config('app.name') }}" /></a></h1>
            </div>

            <!-- Menu -->
            <nav id="navigation" class="menu">
                <ul id="responsive">

                    <li><a href="{{ route('home') }}" @if(Route::is('home')) id="current" @endif>Home</a></li>
                    
                    <li><a href="{{ route('jobs.index') }}" @if(Str::contains(Route::currentRouteName(), 'jobs')) id="current" @endif>Jobs</a></li>
                    
                    <li><a href="{{ route('categories') }}" @if(Route::is('categories')) id="current" @endif>Categories</a></li>
                </ul>

                <ul class="float-right">
                    @auth
                        <li><a href="#"><i class="fa fa-user"></i> {{ auth()->user()->name }}</a>
                            <ul>
                                <li>
                                    @if (auth()->user()->role_id === 3)
                                        <a href="{{ route('profile.index') }}">Profile</a>
                                        <a href="{{ route('freelance.index') }}">Dashboard</a>
                                    @elseif (auth()->user()->role_id === 2)
                                        <a href="{{ route('jobs.create') }}">Add Job</a>
                                        <a href="{{ route('customer.index') }}">Dashboard</a>
                                    @endif
                                </li>
                                <li><a href="{{ route('logout') }}" 
                                    onclick="event.preventDefault();
                                    document.querySelector('#logout-form').submit();"    
                                >Logout</a></li>
                                <form action="{{ route('logout') }}" method="post" id="logout-form">
                                    @csrf
                                </form>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}" @if(Route::is('login')) id="current" @endif><i class="fa fa-user"></i> Log In</a></li>
                        <li><a href="{{ route('register') }}" @if(Route::is('register')) id="current" @endif><i class="fa fa-lock"></i> Sign Up</a></li>
                    @endauth
                </ul>

            </nav>

            <!-- Navigation -->
            <div id="mobile-navigation">
                <a href="#menu" class="menu-trigger"><i class="fa fa-reorder"></i> Menu</a>
            </div>

        </div>
    </div>
</header>