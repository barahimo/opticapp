<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->  
    
  
    {{-- <script src="{{ asset('js/sweetalert2.min.js') }}" defer></script> --}}
    <script src="{{asset('js/sweetalert2.min.js')}}"></script> 
    <link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
   
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/dash.js') }}" defer></script>
    <script src="{{ asset('js/test.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/style.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/searchstyle.css') }}" rel="stylesheet">



    {{-- monstyle --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <title>Document</title>
</head>
<body>
    <center>
    
    <div class="card" style="background-color: rgba(255, 249, 249, 0.842); width:50%; margin-top:50px">
        <div class="card-body">
            {{-- <img src="{{asset('images/logo.jpg')}}" alt="" style="width:120px"> --}}
            <table  class="table table-hover">
    <thead>
    
        <tr >
            <td colspan="3" align="left"> <img src="{{asset('images/logo.jpg')}}" alt="" style="width:120px"></td>
            <td colspan="2" align="left">
                Code client: {{$commande->client->code_client}} <br>  
                Nom Client : {{$commande->client->nom_client}} <br>
                telephone : {{$commande->client->telephone}} <br>  
                Adresse : {{$commande->client->adresse}} <br>  
                Date : {{$commande->date}} <br>  
            </td>
        
        </tr>
        <tr >
            <th colspan="5" style="text-align:center; background-color:rgb(235, 233, 233); font-size:20px">Facture N° : {{$facture->code}}</th>
        
        </tr>
        {{-- <tr >
            <th colspan="5" align="right" >
                Code client: {{$commande->client->code_client}} <br>  
                Nom Client : {{$commande->client->nom_client}} <br>
                telephone : {{$commande->client->telephone}} <br>  
                Adresse : {{$commande->client->adresse}} <br>  
            </th>
        
        </tr> --}}
        <tr>
            {{-- <th>idlignecommande</th> --}}
            <th>Designation</th>
            <th>PU</th>
            <th>Quantité</th>
            <th>Taux TVA</th>
            <th>Montant TTC</th>
        </tr>
    </thead>
    <tbody>
        <div class="container"></div>
        @foreach($lignecommandes as $lignecommande)
        <tr>
            
            {{-- <td>{{$lignecommande->id}}</td> --}}
            <td>{{$lignecommande->nom_produit}}</td>
            <td>{{$lignecommande->produit->prix_produit_HT}}</td>
            <td>{{$lignecommande->quantite}}</td>
            <td>{{$lignecommande->produit->TVA}}</td>
            <td>{{$lignecommande->total_produit}}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2"></td>
            <td colspan="2" align="left">Total HT :</td>
            <td>{{$prix_HT}} DH</td>
        </tr>
        
        <tr>
            <td colspan="2"></td>
            <td colspan="2"  align="left">Total TVA :</td>
            <td>{{$TVA}} DH</td>
            
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2"  align="left">Total TTC:</td>
            <td> {{$priceTotal}} DH</td>
        </tr>
        <tr style="height: 10px">
            <td colspan="5">
                <pre>
siege social : ITIC SOLUTION -3 ,immeuble Karoum, Av Alkhansaa, Cité Azmani-83350 OULED TEIMA, Maroc
            Téléphone : 085785435457890 -https://itic-solution.com/ -Contact@itic-solution.com 
                    I.F. :4737443330 - ICE: 002656767875765788978
                </pre>
            </td>
        </tr>
    </tbody>
    </table>
                <form  method="POST" action="{{route('facture.store')}}">
                    @csrf 
                    
                    <input type="hidden" name="client_id" value={{$commande->client->id}}>
                    <input type="hidden" name="commande_id" value={{$commande->id}}>

                    <input type="hidden" name="total_HT" value={{$prix_HT}}>
                    <input type="hidden"  name="total_TVA" value={{$TVA}}>
                    <input type="hidden" name="total_TTC"  value={{$priceTotal}} >
                    <input type="hidden" name="reglement" value="à raception">
                    
                </form>
               
                <hr>
    </div>
   
</div>

  
     <button class="btn btn-primary btn-lg m-t-10 "  onclick="window.print()" >imprimer</button>
  </center>



</body>
</html>