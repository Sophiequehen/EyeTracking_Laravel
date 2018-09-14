<nav id="navbar-authentification" class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            @if(Auth::check() && Auth::user()->fk_role_id === 3) 
            <ul class="navbar-nav mr-auto">
               <li class="nav-item">
                <a id="navbarDropdown" class="nav-link" href="{{ route('new-register') }}">
                Ajouter un utilisateur</a>
            </li>
            @endif
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Connexion') }}</a></li>
            <li><a class="nav-link" href="{{ route('register') }}">{{ __("S'inscrire") }}</a></li>
            @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Se déconnecter') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
        @endguest
    </ul>
    <div id="navbar-responsive">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a id="navbarDropdown" class="nav-link" href="{{ url('/') }}">ACCUEIL</a>
            </li>
            <li class="nav-item">
                <a id="navbarDropdown" class="nav-link" href="{{ route('comics_index') }}">CATALOGUE</a>
            </li>
            @if(Auth::check() && Auth::user()->fk_role_id === 1 || Auth::check() && Auth::user()->fk_role_id === 3) 
            <li class="nav-item">
                <a id="navbarDropdown" class="nav-link" href="{{ route('medias') }}">MÉDIAS</a>
            </li>
            @endif
            <li class="nav-item">
                <a id="navbarDropdown" class="nav-link" href="{{ url('/legalmentions') }}">À PROPOS</a>
            </li>
        </ul>
    </div>
</div>

<!-- <div class="burger-menu">
    <img src="/img/burger.png">
</div> -->

</div>
</nav>