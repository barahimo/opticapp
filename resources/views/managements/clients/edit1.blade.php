<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    {{-- monstyle --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <title>Document</title>
    <style>
    :root{
        --main-color: #027581;
        --color-dark:  #1D2231;
        --text-grey: #8390A2;
    }

    * {
         font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
         margin: 0;
         padding: 0;
         text-decoration: none;
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
            width:5%;
        }

        #sidebar-toggle:checked ~ .sidebar .sidebar-header h3 span:last-child,
        #sidebar-toggle:checked ~ .sidebar li span:last-child
        {
            display: none;
        }

        

       
        /* style formulaire */


    </style>


</head>
<body>


    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar">
        <div class="sidebar-header">
         <h3 class="brand">
            <span class="ti-unlink"></span>
            <span>Gestion-Optic </span>
         </h3>
         <label for="sidebar-toggle" class="ti-menu-alt"></label>
           
        </div>

        <div class="sidebar-menu">
            <ul>
                <li>   
                    <a href="">
                        <span class="ti-home"></span>
                        <span>Home</span>
                     </a>
                </li>
                <li>   
                    <a href="{{ route('client.index')}}">
                        <span class="ti-face-smile"></span>
                        <span>Clients</span>
                     </a>
                </li>
                <li>   
                    <a href="{{ route('commande.index')}}">
                        <span class="ti-agenda"></span>
                        <span>Commandes</span>
                     </a>
                </li>
                <li>   
                    <a href="">
                        <span class="ti-clipboard"></span>
                        <span>Produits</span>
                     </a>
                </li>
                <li>   
                    <a href="{{ route('categorie.index')}}">
                        <span class="ti-folder"></span>
                        <span>Categories</span>
                     </a>
                </li>
                <li>   
                    <a href="">
                        <span  class="ti-face-smile"></span>
                        <span>LigneCommandes</span>
                     </a>
                </li>
                <li>   
                    <a href="">
                        <span  class="ti-folder"></span>
                        <span>fournisseurs</span>
                     </a>
                </li>
                <li>   
                    <a href="">
                        <span  class="ti-settings"></span>
                        <span> Reglement </span>
                     </a>
                </li>
            </ul>
        </div>
    </div>




    <div class="main-content">
        
        <main id="hadi"  class="py-4">
            {{-- <div class="dash-image">
            <img class="image" src="https://krys-krys-storage.omn.proximis.com/Imagestorage/images/2560/1600/602a299825ad8_Header_G_n_rique_Optique_v2.jpg" >
            </div> --}}
            <div  class="container">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 transparence">
                        <h1 class="text-center">Formulaire Client</h1>

                        <form  method="POST" action="{{route('client.update',['client'=> $client])}}">
                            @csrf 
                            
                            @method('PUT')
                            

                        <label class="label col-md-9 control-label">Nom Complet :</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="nom_client" placeholder="nom_client" value="{{ old('name', $client->nom_client ?? null) }}"  >
                        </div>

                        <label class="label col-md-9 control-label">Adresse :</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="adresse" placeholder="adresse" value="{{ old('adresse', $client->adresse ?? null) }}"  >
                        </div>
                       
                        <label class="label col-md-9 control-label">Telephone :</label>
                        <div class="col-md-12">
                            <input type="tele" class="form-control" name="telephone" placeholder="telephone"  value="{{ old('telephone', $client->telephone ?? null) }}"  >
                        </div>
                        
                        <label class="label col-md-9 control-label">Solde :</label>
                        <div class="col-md-12">
                            <input type="number" class="form-control" name="solde" placeholder="solde" step="0.01" value="{{ old('solde', $client->solde ?? null) }}">
                        </div>
                        

                        {{-- <label class="label col-md-9 control-label">Code client:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="solde" placeholder="codes">
                        </div> --}}
                        
                        <div class="col-md-12">
                        <button class="btn btn-info" type="submit">Modifier</button>  
                        <a href="{{action('ClientController@index')}}" class="btn btn-info">Retour</a>
                        </div>
                    </form>

                    </div>
                    {{-- <div class="col-md-3"></div> --}}
                </div>
            </div>
            
        </main>
    </div>
    <script>
        $(document).on('keyup','input[name=nom_client]',function(){
            nom_client = $('input[name=nom_client]').val();
            btn = $('button[type=submit]');
            (!nom_client && nom_client=='') ? btn.prop('disabled',true):btn.prop('disabled',false) ;
        })
    </script>
</body>
</html>