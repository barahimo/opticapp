<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->  
    <link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
    <script src="{{asset('js/sweetalert2.min.js')}}"></script> 
    {{-- sweetAlert1 --}}
    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
    
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/dash.js') }}" defer></script>
    <script src="{{ asset('js/test.js') }}" defer></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
     
    {{-- monstyle --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <title>Document</title>

    <style>
    :root{
        --main-color: #027581;
        --color-dark:  #1D2231;
        --text-grey: #8390A2;
        overflow-x: hidden;
    }

    * {
         font-family:'Poppins', sans-serif ;
         margin: 0;
         padding: 0;
         text-decoration : none;
         list-style-type : none;
         box-sizing : border-box;
     }
     

     #sidebar-toggle {
            display: none;
        }

     .sidebar {

         height: 100%;
         width: 240px;
         position: fixed;
         left: 0;
         top:0;
         z-index: 100;
         background: var(--main-color);
         color:#fff;
         overflow-y: auto;
         transition: width 500ms;
  }
      .sidebar-header {
          display: flex ;
          justify-content:space-between;
          align-items: center;
          height: 60px;
          padding: auto;
          margin: auto;
      }

      /* .brand{
          padding: auto;
          margin: auto;
      } */

      .sidebar-menu{
          padding: 1rem;
      }
      .sidebar li {
          margin-bottom: 2rem;
      }
      .sidebar a {
          color: #fff;
          font-size: 1.2rem; 
      }
      .sidebar  a span:last-child {

        padding-left: .5rem;

        }
        #sidebar-toggle:checked ~ .sidebar{
            width:auto;
        }

        #sidebar-toggle:checked ~ .sidebar .sidebar-header h3 span:last-child,
        #sidebar-toggle:checked ~ .sidebar li span:last-child
        {
            display: none;
        
        }
        #sidebar-toggle:checked ~ .sidebar .sidebar-header,
        #sidebar-toggle:checked ~ .sidebar li 
        {
            display: flex;
            justify-content: center;
        
        }

        #sidebar-toggle:checked ~ .main-content{
            margin-left:auto;
        }

         .main-content {
         position: relative;
         margin-left:240px;
         transition: margin-left 500ms;

        }
        
      
   @media only screen and (max-width: 1200px){

        .sidebar{
        width: 60px
        }
       .sidebar{
            width:60px;
        }

       .sidebar .sidebar-header h3 span:last-child,
       .sidebar li span:last-child
        {
            display: none;
        
        }
       .sidebar .sidebar-header,
       .sidebar li 
        {
            display: flex;
            justify-content: center;
        
        }

       .main-content{
            margin-left:auto;
        }
   }
      

    </style>


</head>
<body onload="dataview()">
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar">
        <div class="sidebar-header">
         <h3 class="brand">
            <span> <i class="fas fa-glasses"></i></span>
            <span>Gestion-Optic </span>
         </h3>
         <label for="sidebar-toggle" class="ti-menu-alt"></label>
           
        </div>

        <div class="sidebar-menu">
            <ul>
                <li>   
                    <a href="{{ route('app.home')}}">
                        <span class="ti-home"></span>
                        <span>Home</span>
                     </a>
                </li>
                <li>   
                    <a href="{{ route('client.index')}}">
                        <span ><i class="fas fa-users"></i></span>
                        <span>Clients</span>
                     </a>
                </li>
                <!-- <li>   
                    <a href="{{ route('commande.index')}}">
                        <span ><i class="fab fa-shopify"></i></span>
                        <span>Commandes</span>
                     </a>
                </li> -->
                <!-- Commande2 -->
                <!-- <li>   
                    <a href="{{ route('commande.index')}}">
                        <span ><i class="fab fa-shopify"></i></span>
                        <span>Commandes2</span>
                    </a>
                </li> -->
                <!-- Commande2 -->
                <!-- La liste des Commandes -->
                <!-- <li>   
                    <a href="{{ route('commande.index222')}}">
                        <span ><i class="fab fa-shopify"></i></span>
                        <span>Commandes</span>
                    </a>
                </li> -->
                <!-- La liste des Commandes -->
                <li>   
                    <a href="{{ route('produit.index')}}">
                        <span ><i class="fab fa-product-hunt"></i></span>
                        <span>Produits</span>
                       
                     </a>
                </li>
                <li>   
                    <a href="{{ route('categorie.index')}}">
                        <span class="ti-folder"></span>
                        <span>Catégories</span>
                     </a>
                </li>
               <!-- -------------------- -->
               <li>   
                    <a href="{{ route('commande.index')}}">
                        <span ><i class="fab fa-shopify"></i></span>
                        <span>Commandes | Règ.</span>
                    </a>
                </li>
                <!-- -------------------- -->
                <li>   
                    <a href="{{ route('facture.index')}}"">
                        <span ><i class="fas fa-money-check-alt"></i></span>
                        <span>Factures</span>
                        
                     </a>
                </li>
                <!-- <li>   
                    <a href="{{ route('reglement.index')}}">
                        <span ><i class="fab fa-cc-amazon-pay"></i></span>
                        <span> Règlement</span>
                     </a>
                </li> -->
                <!-- <li>   
                    <a href="{{ route('reglement.index2')}}">
                        <span ><i class="fab fa-cc-amazon-pay"></i></span>
                        <span> Règlements</span>
                     </a>
                </li> -->
                <!-- <li>   
                    <a href="{{ route('reglement.index22')}}">
                        <span ><i class="fab fa-cc-amazon-pay"></i></span>
                        <span> Règlements</span>
                     </a>
                </li> -->

                <li>   
                    <a href="{{ route('commande.balance')}}">
                        <span ><i class="fab fa-cc-amazon-pay"></i></span>
                        <span>Mouvements</span>
                    </a>
                </li>
                
            </ul>
        </div>
    </div>




    <div class="main-content">
        <nav style="background-color:rgb(223, 243, 213);"  class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container" >
                <a class="navbar-brand" href="{{ url('/') }}">
                   <span><i class="fas fa-glasses-alt"> <h3 >SOLUTION OPTICIEN</h3> </i></span>  
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Se Connecter') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('creér Compte') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('company.index') }}">Paramètres</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
                </div>
            </div>
        </nav>

        <main class="py-4">
            {{-- <div class="dash-image">
            <img class="image" src="https://krys-krys-storage.omn.proximis.com/Imagestorage/images/2560/1600/602a299825ad8_Header_G_n_rique_Optique_v2.jpg" >
            </div> --}}
            
            

            <div>@yield('contenu')</div>
            
        </main>
    </div>

    @if(session('status'))
    {{-- <div class="alert  alert-success "> 
        {{ session()->get('status')}}
    </div> --}}
    <script>
        Swal.fire('{{ session('status')}}')
    </script>
    @endif

    <script>
        // Swal.fire('Any fool can use a computer')
    </script>
</body>
</html>
