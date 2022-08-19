<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta http-equiv="Content-Type" content="text/html; charset=big5">
    <!-- Metas Antiguos -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Metas Desconocido -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- TITULO EDITABLE -->
    <!--title>@yield('title')</title-->
    <title>Manager SUR</title>
    <!-- Bootstrap -->
    <!-- Scripts Antiguos -->
    <!--script src="{{ asset('js/app.js') }}" defer></script (ESTE ESCRIPT ES VIEJO PERO CAGA LAS TABLAS)-->
    <script src="{{ asset('js/tags.js') }}" defer></script>
    <!-- Script Desconocido -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Script Desconocido pero sirven para el DropDown -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/tags.css">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/images/surlogo.png">
                    <img src="/images/logologo.png">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item"><a href="{{ url('/homes') }}" class="nav-link">Home Manager</a></li>

                        <li class="dropdown">
                            <a href="#" class="nav-link" data-toggle="dropdown">
                                Menu de Solicitudes <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a href="{{ url('/MostrarSolicitudesManager') }}" class="nav-link">Solicitudes Pendientes de Aprobar: {{Session::get('countSolicitudesManager')}}</a></li>
                                <li class="nav-item"><a href="{{ url('/MostrarSolicitudesManagerAprobadas') }}" class="nav-link">Solicitudes Aprobadas por Manager: {{Session::get('countSolicitudesManagerAprobadas')}}</a></li>
                                <li class="nav-item"><a href="{{ url('/MostrarSolicitudesManagerRechazadas') }}" class="nav-link">Solicitudes Rechazadas por Manager: {{Session::get('countSolicitudesManagerRechazadas')}}</a></li>
                                <!--<li><a href="#" class="nav-link">Acci��n #2</a></li>
                                <li><a href="#" class="nav-link">Acci��n #3</a></li>
                                <li class="divider"></li>
                                <li><a href="#" class="nav-link">Acci��n #4</a></li>-->
                            </ul>
                        </li>


                        </ul>
                        <li class="dropdown">
                            <a href="#" class="nav-link" data-toggle="dropdown">
                                Menu Manager <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                    <li class="nav-item"><a href="{{ url('/MostrarSolicitudesColaborador') }}" class="nav-link">Mis Solicitudes Realizadas: {{Session::get('countSolicitudesMiasManager')}}</a></li>
                                <!--<li><a href="#" class="nav-link">Acci��n #2</a></li>
                                <li><a href="#" class="nav-link">Acci��n #3</a></li>
                                <li class="divider"></li>
                                <li><a href="#" class="nav-link">Acci��n #4</a></li>-->
                            </ul>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar Sesion') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registro') }}</a>
                                @endif
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Manager: {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="users/{{ Auth::user()->id }}" class="nav-link">Mi Usuario</a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>