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
                    
                    <li><a href="{{ route('jobs.index') }}" @if(Route::is('jobs.index')  || Route::is('jobs.show')) id="current" @endif>Jobs</a></li>
                    
                    <li><a href="{{ route('categories') }}" @if(Route::is('categories')) id="current" @endif>Categories</a></li>

                    {{-- <li><a href="#">For Candidates</a>
                        <ul>
                            <li><a href="browse-jobs.html">Browse Jobs</a></li>
                            <li><a href="browse-categories.html">Browse Categories</a></li>
                            <li><a href="add-resume.html">Add Resume</a></li>
                            <li><a href="manage-resumes.html">Manage Resumes</a></li>
                            <li><a href="job-alerts.html">Job Alerts</a></li>
                        </ul>
                    </li> --}}

                    <li><a href="#">For Employers</a>
                        <ul>
                            <li><a href="add-job.html">Add Job</a></li>
                            <li><a href="manage-jobs.html">Manage Jobs</a></li>
                            <li><a href="manage-applications.html">Manage Applications</a></li>
                            <li><a href="browse-resumes.html">Browse Resumes</a></li>
                        </ul>
                    </li>

                    <li><a href="blog.html">Blog</a></li>
                </ul>


                <ul class="float-right">
                    @auth
                        <li><a href="#"><i class="fa fa-user"></i> {{ auth()->user()->name }}</a>
                            <ul>
                                <li>
                                    @if (auth()->user()->role_id === 3)
                                        <a href="{{ route('profile.index') }}">Profile</a>
                                    @elseif (auth()->user()->role_id === 2)
                                        <a href="{{ route('jobs.create') }}">Add Job</a>
                                    @endif
                                </li>
                                <li><a href="job-page-alt.html">Job Page Alternative</a></li>
                                <li><a href="resume-page.html">Resume Page</a></li>
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