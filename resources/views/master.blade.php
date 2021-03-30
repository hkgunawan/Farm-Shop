<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" href="{{ URL::asset('assets/img/PSMTI/logo.png') }}">

	<title>PSMTI Jawa Timur</title>

	<!-- Bootstrap core CSS -->
	<link href="{{ URL::asset('assets/css/bootstrap.css') }}"  rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">






	<!-- Just for debugging purposes. Don't actually copy this line! -->
	<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->



    
      @yield('head')
    </head>

    <body>

     <!-- Fixed navbar -->
     <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
       <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
         <span class="sr-only">Toggle navigation</span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
       </button>


  <img   class="kiri" src="{{ URL::asset('assets/img/PSMTI/logo.png') }}">
       <a class="navbar-brand" href="/"> PSMTI Jawa Timur </a>
      
     </div>
     <div class="navbar-collapse collapse navbar-right">
      <ul class="nav navbar-nav" >
        @if (Auth::guest())
                         <li {{{ (Request::is('/') ? 'class=active' : '') }}}>
         <a href="{{ url('/') }}">BERANDA</a></li>



          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">TENTANG PSMTI<b class="caret"></b></a>
              <ul class="dropdown-menu">
               <li {{{ (Request::is('visimisi') ? 'class=active' : '') }}}>
                 <a href="{{ url('visimisi') }}">VISI MISI</a></li>
                 <li {{{ (Request::is('pokok') ? 'class=active' : '') }}}>
                   <a href="{{ url('pokok') }}">POKOK PEMIKIRAN</a></li>
                   <li {{{ (Request::is('sejarah') ? 'class=active' : '') }}}>
                     <a href="{{ url('sejarah') }}">SEJARAH</a></li>
                     <li {{{ (Request::is('pengurus') ? 'class=active' : '') }}}>
                       <a href="{{ url('Pengurus') }}">PENGURUS</a></li>
                     </ul>
                   </li>



          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">KEGIATAN<b class="caret"></b></a>
              <ul class="dropdown-menu">
               <li {{{ (Request::is('berita') ? 'class=active' : '') }}}>
                 <a href="{{ url('berita') }}">BERITA</a></li>
                 <li {{{ (Request::is('event') ? 'class=active' : '') }}}>
                   <a href="{{ url('Event') }}">EVENT</a></li>
                   
                     </ul>
                   </li>

         
           <li {{{ (Request::is('contact') ? 'class=active' : '') }}}>
             <a href="{{ url('contact') }}">HUBUNGI KAMI</a></li>



              <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">KEANGGOTAAN<b class="caret"></b></a>
              <ul class="dropdown-menu">
               <li {{{ (Request::is('daftar') ? 'class=active' : '') }}}>
                 <a href="{{ url('daftar') }}">DAFTAR</a></li>
                
                     </ul>
                   </li>

                       
                    @else

       <li {{{ (Request::is('/') ? 'class=active' : '') }}}>



          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">BERITA<b class="caret"></b></a>
              <ul class="dropdown-menu">
               <li {{{ (Request::is('Berita') ? 'class=active' : '') }}}>
                 <a href="{{ url('Berita') }}">LIST</a></li>
                 <li {{{ (Request::is('Kategori') ? 'class=active' : '') }}}>
                   <a href="{{ url('Kategori') }}">KATEGORI</a></li>
                     </ul>
                   </li>




                   <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">EVENT<b class="caret"></b></a>
                <ul class="dropdown-menu">
               <li {{{ (Request::is('Event') ? 'class=active' : '') }}}>
                 <a href="{{ url('Event') }}">LIST</a></li>
                 <li>
                 <a  href="{{ route('Event.create') }}"> Create Event</a>
                 </li>
                 
                     </ul>
                   </li>
  <li {{{ (Request::is('Member') ? 'class=active' : '') }}}>
         <a href="{{ url('Member') }}">Keanggotaan</a></li>
         <li {{{ (Request::is('Pengurus.create') ? 'class=active' : '') }}}>
         <a href="{{ route('Pengurus.create') }}">Pengurus</a></li>

       <li {{{ (Request::is('Pesan') ? 'class=active' : '') }}}>
         <a href="{{ url('Pesan') }}">PESAN MASUK</a></li>

            <!-- Authentication Links -->
                  
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" >
                                <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif


                 </ul>


               </div><!--/.nav-collapse -->
             </div>
           </div>

           @yield('content')

<!-- *****************************************************************************************************************
	 FOOTER
	 ***************************************************************************************************************** -->
	  <div id="footerwrap">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <h4>Tentang</h4>
          <div class="hline-w"></div>
          <p> Organisasi Paguyuban Sosial Marga Tionghwa Indonesia</p>
        </div>
      
        <div class="col-lg-4">
          <h4>Alamat Kami</h4>
          <div class="hline-w"></div>
          <p>

            Jl. Sutorejo Prima Utara II/1 <br/>
            60112, Surabaya,<br/>
            Jawa Timur<br/>
          </p>
        </div>

      </div><! --/row -->
    </div><! --/container -->
   </div><! --/footerwrap -->
	 
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->


  
    



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/retina-1.1.0.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.hoverdir.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.hoverex.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.isotope.min.js') }}"></script>
   
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>



     <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    

       @yield('script')
    

 </body>
 </html>
