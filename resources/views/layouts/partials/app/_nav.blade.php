<nav class="navbar navbar-expand-lg navbar-dark">
    <span class="navbar-brand">
        <a class="navbar-brand" href="/">My Site
        </a>
    </span>
    <button aria-controls="basic-navbar-nav" type="button" aria-label="Toggle navigation" class="navbar-toggler collapsed"><span class="navbar-toggler-icon"></span></button>
    <div class="navbar-collapse collapse" id="basic-navbar-nav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="nav-link active text-uppercase mr-2">
                    <a href="/">Home</a>
                </span>
            </li>
            <li class="nav-item">
                <span class="nav-link active text-uppercase mr-2">
                    <a href="/blog">Blog</a>
                </span>
            </li>
            <li class="nav-item">
                <span class="nav-link active text-uppercase mr-2">
                    <a href="/about">About</a>
                </span>
            </li>
            <li class="nav-item">
                <span class="nav-link active text-uppercase mr-2">
                    <a href="/contact">Contact</a>
                </span>
            </li>
            @if (Route::has('login'))
                @auth
                <li class="nav-item">
                    <span class="nav-link text-uppercase mr-2">
                        <a href="{{ url('/home') }}">Profile</a>    
                    </span>
                </li>
                @else
                    <span class="nav-link text-uppercase mr-2">
                        <a href="{{ route('login') }}">Login</a>
                    </span>
                    @if (Route::has('register'))
                        <span class="nav-link text-uppercase mr-2">
                            <a href="{{ route('register') }}">Register</a>
                        </span>
                    @endif
                @endauth
            @endif
        </ul>
    </div>
</nav>
