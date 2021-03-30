<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('Mutiara', 'Mutiara') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/chosen/chosen.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        Toko Mutiara
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                             @if (Auth::guest())

                             @elseif(Auth::user()->role==1)
                                    @if (Auth::user()->aktif==1)
                            
                          
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Master <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li {{{ (Request::is('barang') ? 'class=active' : '') }}}>
                                         <a href="{{ url('barang') }}">Barang</a>
                                </li>
                                <li><a href="{{ url('suplier') }}">Supplier</a></li>
                                <li><a href="{{ url('pelanggan') }}">Pelanggan</a></li>
                                <li><a href="{{ url('user') }}">User</a></li>
                                 <li><a href="{{ url('kategori') }}">Kategori</a></li>
                            
                              </ul>
                            </li>
                
                          

                                @endif

                             @elseif(Auth::user()->role==2)
                                  @if (Auth::user()->aktif==1)
                            
                            <li><a href="{{ url('home') }}">Home</a></li>
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Penjualan <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="{{ url('penjualan') }}">Penjualan</a></li>
                                    <li><a href="{{ url('cicilan_penjualan') }}">Cicilan Penjualan</a></li>
                                <li><a href="{{ url('returjual') }}">Retur Penjualan</a></li>

                            
                              </ul>
                            </li>
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Laporan <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="{{ url('laporankas') }}">laporan kas</a></li>
                            
                              </ul>
                            </li>

                                @endif


                             @elseif(Auth::user()->role==3)
                                  @if (Auth::user()->aktif==1)
                            
                                 <li><a href="{{ url('home') }}">Reminder</a></li>
                 
                
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pembelian <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="{{ url('pembelian') }}">Pembelian</a></li>
                                <li><a href="{{ url('cicilan_pembelian') }}">Cicilan Hutang</a></li>  

                                <li><a href="{{ url('returbeli') }}">Retur Pembelian</a></li>
                            
                              </ul>
                            </li>
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Penjualan <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="{{ url('penjualan') }}">Penjualan</a></li>
                                <li><a href="{{ url('cicilan_penjualan') }}">Cicilan Piutang</a></li>
                                <li><a href="{{ url('returjual') }}">Retur Penjualan</a></li>
                            
                              </ul>
                            </li>
                
                            <li><a href="{{ url('pengeluaran') }}">Pengeluaran</a></li>
                            <li><a href="{{ url('pemasukan') }}">Pemasukan</a></li> 
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Laporan <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                              
                            
                                <li><a href="{{ url('laporanpembelian') }}">Laporan Pembelian</a></li>
                                <li><a href="{{ url('laporanpenjualan') }}">Laporan Penjualan</a></li>
                                <li><a href="{{ url('laporankas') }}">Laporan Kas</a></li>
                                <li><a href="{{ url('laporanhutang') }}">Laporan Hutang</a></li>
                                <li><a href="{{ url('laporanpiutang') }}">Laporan Piutang</a></li>
                                <li><a href="{{ url('laporanlabarugi') }}">Laba Rugi</a></li>
                            
                              </ul>
                                @endif
                            @endif
                        
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                          
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('assets/chosen/chosen.jquery.min.js') }}"></script>
    @yield('script')
</body>
</html>
