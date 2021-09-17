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
    width:5%;
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

        
        header {
           position: fixed;
           top: 0;
           z-index:100 ;    
           width: calc(100% - 240px);
           background:#fff;
           height:60px ;
           padding: 0rem 1rem;
           display: flex;
           align-items: center;
           justify-content: space-between;
           border-bottom: 1px solid #ccc;
        }

        .search-wrapper{
           display: flex;
           align-items: center;

        }
        .search-wrapper input{
            border: 0;
            outline: 0;
            padding: 1rem;
            height: 38px;
        }
        .social-icons{
            display: flex;
            align-items: center;
        }

        .solcial-icons span,
        .social-icons div {

            margin-left: 1.2rem;
        }

        .social-icons div{ 
            height: 38px;
            width: 38px;
            background-size: cover;
            background-repeat: no-repeat;
            background-image: url(https://www.l4mcdn.fr/5/8/580429.jpg);
            border-radius: 50%;
        }
        
        .image{
            width:80%;
            height:200px;
            margin-left: 10%;
            margin-right: 5%;
            margin-bottom: 3%;
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
                @if( Auth::user()->is_admin )
                <li>   
                    <a href="{{ route('commande.index')}}">
                        <span ><i class="fab fa-shopify"></i></span>
                        <span>Commandes</span>
                     </a>
                </li>
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
               
                <li>   
                    <a href="{{ route('facture.index')}}"">
                        <span ><i class="fas fa-money-check-alt"></i></span>
                        <span>Factures</span>
                        
                     </a>
                </li>
                <li>   
                    <a href="{{ route('reglement.index')}}">
                        <span ><i class="fab fa-cc-amazon-pay"></i></span>
                        <span> Règlement</span>
                     </a>
                </li>
               @endif

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
                        <h1 class="text-center">Modifier Produit</h1>

                        <form  method="POST" action="{{route('produit.update',['produit'=> $produit])}}">
                            @csrf {{-- génère un toke pur protéger le formulaie --}}
                            
                            @method('PUT')
                            <label class="label col-md-9 control-label">Nom Produit :</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="nom_produit" placeholder="nom_produit" value="{{ old('nom_produit', $produit->nom_produit?? null) }}"  >
                            </div>
    
                            <label class="label col-md-9 control-label">Code Produit :</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="code_produit" placeholder="code_produit" value="{{ old('code_produit', $produit->code_produit?? null) }}" >
                            </div>
                            <label class="label col-md-9 control-label">TVA:</label>
                            <div class="col-md-12">
                                <select name="TVA" id="TVA" class="form-control">
                                    <option value="">---TVA---</option>
                                    <option value="20" @if ($produit->TVA == old('TVA',"20" ?? null)) selected="selected" @endif>20</option>
                                    <option value="14" @if ($produit->TVA == old('TVA',"14" ?? null)) selected="selected" @endif>14</option>
                                    <option value="10" @if ($produit->TVA == old('TVA',"10" ?? null)) selected="selected" @endif>10</option>
                                    <option value="7" @if ($produit->TVA == old('TVA',"7" ?? null)) selected="selected" @endif>7</option>
                                </select>
                                {{-- <input type="text" class="form-control" name="TVA" placeholder="TVA" value="{{ old('TVA', $produit->TVA ?? null) }}"  > --}}
                            </div>
                            <label class="label col-md-9 control-label">Prix produit HT :</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="prix_produit_HT" placeholder="prix_produit_HT" value="{{ old('prix_produit_HT', $produit->prix_produit_HT ?? null) }}"   >
                            </div>
                            <label class="label col-md-9 control-label">Description:</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="description" placeholder="description" value="{{ old('description', $produit->description ?? null) }}" >
                            </div>
                            <label class="label col-md-9 control-label">Nom categorie :</label>
                            <div class="col-md-12">
                                @include('managements.selection.select')
                            </div>
                            {{-- <div class="col-md-12">
                                <input type="text" class="form-control" name="nom_categorie" placeholder="description" value="{{ old('nom_categorie', $produit->nom_categorie ?? null) }}" readonly>
                            </div> --}}

                            
                        @if ($errors->any())  

                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        @endif
                        
                        <div class="col-md-12">
                         <button class="btn btn-info" type="submit">Modifier</button>
                        <a href="{{action('ProduitController@index')}}" class="btn btn-info"  >retour</a>
                        </div>
                    </form>

                    </div>
                    
                </div>
             </div>
            
        </main>
    </div>
</body>
</html>


