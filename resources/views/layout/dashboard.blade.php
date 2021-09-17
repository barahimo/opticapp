<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from uxliner.com/adminkit/demo/main/ltr/pages-blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 17:41:44 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>OpticApp - Application</title>

<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- sweetAlert2 --> 
<link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
<script src="{{asset('js/sweetalert2.min.js')}}"></script> 

<!-- jQuery 3 --> 
<script src="{{ asset('dist/js/jquery.min.js')}}"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}

<!-- font-awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css')}}" /> --}}

<!-- v4.0.0 -->
<link rel="stylesheet" href="{{ asset('dist/bootstrap/css/bootstrap.min.css')}}">

<!-- Favicon -->
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo_opticapp_16x16.png')}}">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/style.css')}}">
<link rel="stylesheet" href="{{ asset('dist/css/font-awesome/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{ asset('dist/css/et-line-font/et-line-font.css')}}">
<link rel="stylesheet" href="{{ asset('dist/css/themify-icons/themify-icons.css')}}">
<link rel="stylesheet" href="{{ asset('dist/css/simple-lineicon/simple-line-icons.css')}}">

<!-- Chartist CSS -->
<link rel="stylesheet" href="{{ asset('dist/plugins/chartist-js/chartist.min.css')}}">
<link rel="stylesheet" href="{{ asset('dist/plugins/chartist-js/chartist-plugin-tooltip.css')}}">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body class="skin-blue sidebar-mini">
  @php
  $companies = App\Company::get();
  $count = count($companies);
  ($count>0)  ? $company = App\Company::first(): $company = null;
  if($company && ($company->logo || $company->logo != null)){
    $logo = Storage::url($company->logo ?? null);
    $nom = $company->nom;
  }
  else{
    $logo = asset('images/image.png');
    $nom = '';
  }
  @endphp
<div class="wrapper boxed-wrapper">
  <header class="main-header"> 
    <!-- Logo --> 
    <a href="{{route('app.home')}}" class="logo blue-bg"> 
    <!-- mini logo for sidebar mini 50x50 pixels --> 
    <span class="logo-mini"><img src="{{ asset('dist/img/logo-n-blue.png')}}" alt=""></span> 
    <!-- logo for regular state and mobile devices --> 
    <span class="logo-lg"><img src="{{ asset('dist/img/logo-blue.png')}}" alt=""></span> </a> 
    <!-- Header Navbar -->
    <nav class="navbar blue-bg navbar-static-top"> 
      <!-- Sidebar toggle button-->
      <ul class="nav navbar-nav pull-left">
        <li><a class="sidebar-toggle" data-toggle="push-menu" href="#"></a> </li>
      </ul>
      <div class="pull-left search-box">
        <form action="#" method="get" class="search-form">
          <div class="input-group">
            <input name="search" class="form-control" placeholder="" type="text">
            <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i> </button>
            </span></div>
        </form>
        <!-- search form --> </div>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages -->
          <li class="dropdown messages-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope-o"></i>
            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 new messages</li>
              <li>
                <ul class="menu">
                  <li><a href="#">
                    <div class="pull-left"><img src="{{ asset('dist/img/img1.jpg')}}" class="img-circle" alt="User Image"> <span class="profile-status online pull-right"></span></div>
                    <h4>Alex C. Patton</h4>
                    <p>I've finished it! See you so...</p>
                    <p><span class="time">9:30 AM</span></p>
                    </a></li>
                  <li><a href="#">
                    <div class="pull-left"><img src="{{ asset('dist/img/img3.jpg')}}" class="img-circle" alt="User Image"> <span class="profile-status offline pull-right"></span></div>
                    <h4>Nikolaj S. Henriksen</h4>
                    <p>I've finished it! See you so...</p>
                    <p><span class="time">10:15 AM</span></p>
                    </a></li>
                  <li><a href="#">
                    <div class="pull-left"><img src="{{ asset('dist/img/img2.jpg')}}" class="img-circle" alt="User Image"> <span class="profile-status away pull-right"></span></div>
                    <h4>Kasper S. Jessen</h4>
                    <p>I've finished it! See you so...</p>
                    <p><span class="time">8:45 AM</span></p>
                    </a></li>
                  <li><a href="#">
                    <div class="pull-left"><img src="{{ asset('dist/img/img4.jpg')}}" class="img-circle" alt="User Image"> <span class="profile-status busy pull-right"></span></div>
                    <h4>Florence S. Kasper</h4>
                    <p>I've finished it! See you so...</p>
                    <p><span class="time">12:15 AM</span></p>
                    </a></li>
                </ul>
              </li>
              <li class="footer"><a href="#">View All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications  -->
          <li class="dropdown messages-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bell-o"></i>
            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Notifications</li>
              <li>
                <ul class="menu">
                  <li><a href="#">
                    <div class="pull-left icon-circle red"><i class="icon-lightbulb"></i></div>
                    <h4>Alex C. Patton</h4>
                    <p>I've finished it! See you so...</p>
                    <p><span class="time">9:30 AM</span></p>
                    </a></li>
                  <li><a href="#">
                    <div class="pull-left icon-circle blue"><i class="fa fa-coffee"></i></div>
                    <h4>Nikolaj S. Henriksen</h4>
                    <p>I've finished it! See you so...</p>
                    <p><span class="time">1:30 AM</span></p>
                    </a></li>
                  <li><a href="#">
                    <div class="pull-left icon-circle green"><i class="fa fa-paperclip"></i></div>
                    <h4>Kasper S. Jessen</h4>
                    <p>I've finished it! See you so...</p>
                    <p><span class="time">9:30 AM</span></p>
                    </a></li>
                  <li><a href="#">
                    <div class="pull-left icon-circle yellow"><i class="fa  fa-plane"></i></div>
                    <h4>Florence S. Kasper</h4>
                    <p>I've finished it! See you so...</p>
                    <p><span class="time">11:10 AM</span></p>
                    </a></li>
                </ul>
              </li>
              <li class="footer"><a href="#">Check all Notifications</a></li>
            </ul>
          </li>
          <!-- User Account  -->
          <li class="dropdown user user-menu p-ph-res"> 
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
              <img src="{{$logo}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{$nom}}</span> 
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <div class="pull-left user-img"><img src="{{$logo}}" class="img-responsive img-circle" alt="User"></div>
                <p class="text-left">Florence Douglas <small>florence@gmail.com</small> </p>
              </li>
              <li><a href="#"><i class="icon-profile-male"></i> My Profile</a></li>
              <li><a href="#"><i class="icon-wallet"></i> My Balance</a></li>
              <li><a href="#"><i class="icon-envelope"></i> Inbox</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#"><i class="icon-gears"></i> Account Setting</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar"> 
    <!-- sidebar -->
    <div class="sidebar"> 
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="image text-center">
          <img src="{{$logo}}" class="img-circle" alt="Logo" style="width:120px">
        </div>
        <div class="info">
          <p>{{$nom}}</p>
      </div>
      
      <!-- sidebar menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header"></li>
        <li class=""> 
          <a href="{{route('app.home')}}">
            <i class="icon-home"></i>  
            <span>Dashboard</span>
          </a>
        </li>
        <li class=""> 
          <a href="{{route('client.index')}}">
            <i class="icon-people"></i>  
            <span>Clients</span>
          </a>
        </li>
        <li class=""> 
          <a href="{{route('categorie.index')}}">
            <i class="icon-grid"></i>  
            <span>Catégories</span>
          </a>
        </li>
        <li class=""> 
          <a href="{{route('produit.index')}}">
            <i class="icon-eyeglass"></i>  
            <span>Produits</span>
          </a>
        </li>
        <li class=""> 
          <a href="{{route('commande.index')}}">
            <i class="icon-note"></i>  
            <span>Commandes | Règ.</span>
          </a>
        </li>
        <li class=""> 
          <a href="{{route('facture.index')}}">
            <i class="icon-docs"></i>  
            <span>Factures</span>
          </a>
        </li>
        <li class=""> 
          <a href="{{route('commande.balance')}}">
            <i class="icon-book-open"></i>  
            <span>Mouvements</span>
          </a>
        </li>
      </ul>
    </div>
    <!-- /.sidebar --> 
  </aside>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
      @yield('contenu')
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">Version 1.0</div>
    Copyright © 2021 - itic-solution.com - tous les droits sont réservés.
  </footer>
</div>

{{-- ################################## --}}
@if(session()->has('status'))
<script>
  Swal.fire('{{ session('status')}}')
</script>
@endif
{{-- ################################## --}}
<!-- ./wrapper --> 

<!-- jQuery 3 --> 
{{-- <script src="{{ asset('dist/js/jquery.min.js')}}"></script> --}}

<script src="{{ asset('dist/plugins/popper/popper.min.js')}}"></script>

<!-- v4.0.0-alpha.6 -->
<script src="{{ asset('dist/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- template --> 
<script src="{{ asset('dist/js/adminkit.js')}}"></script>

<!-- Chart Peity JavaScript --> 
<script src="{{ asset('dist/plugins/peity/jquery.peity.min.js')}}"></script> 
<script src="{{ asset('dist/plugins/functions/jquery.peity.init.js')}}"></script>
</body>

<!-- Mirrored from uxliner.com/adminkit/demo/main/ltr/pages-blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 17:41:44 GMT -->
</html>
