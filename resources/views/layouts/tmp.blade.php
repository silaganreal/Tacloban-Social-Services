<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Tacloban Social Services</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">

    @yield('externalcss')

    {{-- datatable --}}
    <link rel="stylesheet" href="{{ asset('datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatables/buttons.dataTables.min.css') }}">
    {{-- datatable --}}
</head>

<body class="hold-transition sidebar-mini">

    <div class="wrapper" id="app">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="Gothong" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Tacloban Social Services</span>
            </a>
            <div class="sidebar">
                @yield('navlink')
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ url('/clients') }}" class="nav-link <?php echo $link_clients; ?>">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Clients</p>
                            </a>
                        </li>
                        @if (Auth::user()->accountType == 'admin' || Auth::user()->accountType == 'dhc')
                            <li class="nav-item">
                                <a href="{{ url('/medicines') }}" class="nav-link <?php echo $link_medicines; ?>">
                                    <i class="nav-icon fas fa-briefcase-medical"></i>
                                    <p>Medicines</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/client-logs') }}" class="nav-link <?php echo $link_logs; ?>">
                                    <i class="nav-icon fas fa-info-circle"></i>
                                    <p>Logs</p>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->accountType == 'admin' || Auth::user()->accountType == 'cswdo' || Auth::user()->accountType == 'masa')
                            <li class="nav-item">
                                <a href="{{ url('/household') }}" class="nav-link <?php echo $link_household; ?>">
                                    <i class="nav-icon fas fa-house-user"></i>
                                    <p>Family Composition</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>

        @yield('content')

    </div>

    {{-- included scripts --}}
        <script src="{{ asset('dist/js/jquery.min.js') }}"></script>
        {{-- <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script> --}}
        <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
    {{-- included scripts --}}

    @yield('externaljs')

    {{-- datatables --}}
        <script src="{{ asset('datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('datatables/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('datatables/jszip.min.js') }}"></script>
        <script src="{{ asset('datatables/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('datatables/buttons.print.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.dtable1').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'print'
                    ]
                });

                $('.dtable2').DataTable({bFilter: false, bInfo: false});
                $('.dtable3').DataTable({bFilter:true});
            });
        </script>
    {{-- datatables --}}

</body>
</html>
