{{--<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/dash.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
   

    {{-- monstyle --}}

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
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
           
            <div  class="container">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 transparence">
                        <h1 class="text-center">Ajouter ligneCommande</h1>

                        <form  method="POST" action="{{route('lignecommande.store')}}">
                            @csrf 

                            <label class="label col-md-9 control-label">IdCommande:</label>
                            <div class="col-md-12">
                               
                                 @include('managements.selection.selectIdCmd')
                                
                            </div>

                            <label class="label col-md-9 control-label">nom Produit:</label>
                            <div class="col-md-12">
                               
                                 @include('managements.selection.selectIdProd')
                                
                            </div>



                            <label class="label col-md-9 control-label">Quantité :</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="quantite" placeholder="quantite"    >
                            </div>

                            <label class="label col-md-9 control-label">prixtotal :</label>
                            <div class="col-md-12">
                            <input  type="text" id="yarbi" name="yarbi" > 
                           
                        </div>

                    
                           
                        @if ($errors->any())  

                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        @endif
                        
                        <div class="col-md-12">
                         <button class="btn btn-info" type="submit" >Ajouter</button>
                        <a href="{{action('LignecommandeController@index')}}" class="btn btn-info"  >retour</a>
                        </div>
                    </form>

                    </div> 
                    
                </div>
             </div>
            
        </main>
    </div>
    

</body>
 </html> --}}



 @extends('layout.dashboard')

@section('contenu')



<div class="row justify-content-center">
    <div class="col-md-10">

 <table class="table">
                <tr>
                    <th style="background-color:rgb(186, 206, 224); color:black; text-align:center ; font-size:21px;">ajouter lignecommande</th>
                 </tr>
             </table>
        
         <form  method="POST" action="{{route('commande.storeL')}}">
            @csrf 
        {{-- <div class="form-row"> --}}

              
                <input type="text" class="form-control" name="commande_id" value="{{$commande->id}}"   >
          
                &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
              
              {{-- ---------------- BEGIN --------------------- --}}
          
      
              <select class="productcategory form-control" id="prod_cat_id">
              
              <option value="0" disabled="true" selected="true">-Select-</option>
              @foreach($prod as $cat)
              <option value="{{$cat->id}}">{{$cat->nom_categorie}}</option>
              @endforeach
              
              </select>
         
              &nbsp;&nbsp;
        
         
                <select  class="productname form-control" name="nom_produit">
                
                <option value="0" disabled="true" selected="true">Product Name</option>
                </select>
         
        
             &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
        
           <input type="text" class="prod_price form-control" id="prod_price" name="prod_price" placeholder="prix_unutaire">
       

           &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
      
        
        <input type="text" class="prod_id form-control" id="prod_id" name="prod_id" placeholder="produit_id">

        &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
        
        <input type="text" class="prod_TVA form-control" id="prod_TVA" name="prod_TVA" placeholder="TVA">
        
        {{-- </div> --}}
        <script type="text/javascript">
          $(document).ready(function(){
        
            $(document).on('change','.productcategory',function(){
              // console.log("hmm its change");
        
              var cat_id=$(this).val();
              // console.log(cat_id);
              var div=$(this).parent();
        
              var op=" ";
        
              $.ajax({
                type:'get',
                url:'{!!URL::to('findProductName')!!}',
                data:{'id':cat_id},
                success:function(data){
                  // console.log('success');
        
                  // console.log(data);
        
                  // console.log(data.length);
                  op+='<option value="0" selected disabled>chose product</option>';
                  for(var i=0;i<data.length;i++){
                  op+='<option value="'+data[i].id+'">'+data[i].nom_produit+'</option>';
                   }
        
                   div.find('.productname').html(" ");
                   div.find('.productname').append(op);
                },
                error:function(){
        
                }
              });
            });
        
            $(document).on('change','.productname',function () {
              var prod_id=$(this).val();
        
              var a=$(this).parent();
              // console.log(prod_id);
              var op="";
              $.ajax({
                type:'get',
                url:'{!!URL::to('findPrice')!!}',
                data:{'id':prod_id},
                dataType:'json',//return data will be json
                success:function(data){
                  // console.log("price");
                  console.log(data);
                  // console.log(data.prix_produit_HT);
        
                  // here price is coloumn name in products table data.coln name
        
                  a.find('.prod_price').val(data.prix_produit_HT);
                  a.find('.prod_TVA').val(data.TVA);
                  a.find('.prod_id').val(data.id);

        
                },
                error:function(){
        
                }
              });
        
        
            });
        
          });
        </script>

              {{-- -----------------END -------------------- --}}

              &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
              <div class="form-row">  
                <div class="col">
                  <input type="text" class="form-control" id="quantite" name="quantite" placeholder="quantite" onchange="calcul() "   >
                </div>
  
                <div class="col">
                <input  type="text" class="form-control" id="amount" name="amount" readonly  placeholder="Prix_TTC"> 
                </div>
  
                <div class="col">
                  <button class="btn btn-primary" type="submit" style="width: 100px">Ajouter</button>
                 </div>
            </div>    
              &nbsp;&nbsp;
              
            </form>
      </div>
</div>


<div class="row justify-content-center">
  <div class="col-md-10">
      <div class="row">
         


      </div>
      <div class="card" style="background-color: rgba(241, 241, 241, 0.842);">
          <div class="card-body">
              <table class="table table-hover">
                  <thead>
                      <tr>
                          <th scope="col">#id</th>
                          
                          <th scope="col"> idcommande</th>
                          <th scope="col"> Nom produit</th>
                          <th scope="col"> quantite </th>

                          <th scope="col">Prix_TTC</th>
                          <th scope="col">Action</th>
                          
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($lignecommandes as $lignecommande)
                        <tr>
                            <th scope="row" >{{$lignecommande->id }}</th>
                            {{-- <td>{{$lignecommande->cadre}}</td> --}}
                            <td>{{$lignecommande->commande_id}}</td>
                            <td>{{$lignecommande->nom_produit}}</td>
                            <td>{{$lignecommande->quantite}}</td>
                            <td>{{$lignecommande->total_produit}}</td>
                          <td>
                              <form style="display: inline" method="POST" action="{{route('lignecommande.destroy',['lignecommande'=> $lignecommande])}}">
                                  @csrf 
                                 @method('DELETE')
                                 <a href="{{ action('LignecommandeController@show',['lignecommande'=> $lignecommande])}}" class="btn btn-secondary btn-md">detailler</i></a>
                                 <a href="{{route('lignecommande.edit',['lignecommande'=> $lignecommande])}}"class="btn btn-success btn-md">editer</i></a>
                                 <button class="btn btn-danger btn-md" type="submit">archiver</button>
                               </form>  

                          </td>

                         
                          </tr>
                         
                      @endforeach
                  </tbody>
              </table>
          </div>
        

      </div>
      {{ $lignecommandes->links()}}
      &nbsp;&nbsp;&nbsp;&nbsp;
     
     <span><strong>Prix_total</strong></span>
      <input type="text" class="form-control" name="prix-total" id="prix-total" readonly placeholder="prix_total" value="{{ $priceTotal}}">  

      
     
  </div>

</div>


@endsection
