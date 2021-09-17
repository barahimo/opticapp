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
    <!-- My Styles -->
    <!-- My Styles -->
    <style>
        .table th, .table td { 
            border-top: none ;
            border-bottom: none ;
            padding-top: 4px; 
            padding-bottom: 4px;
        }
    </style>
</head>
<body>
    <div class="align-center" style="display: flex;align-items: center;justify-content: center;">
        <div style="width : 90%;">
            <div class="card" style="background-color: rgba(255, 249, 249, 0.842); width:100%; margin-top:20px">
                <div class="card-body">
                    <i class="fas fa-arrow-circle-left fa-3x" onclick="window.location.assign('/index5')"></i>
                    <table class="table table-hover" border="0" style="border: 0px solid red">
                        <thead>
                            <tr>
                                <td colspan="3" class="text-left">
                                    @if($company && ($company->logo || $company->logo != null))
                                        <img src="{{Storage::url($company->logo ?? null)}}"  alt="logo" style="width:80px;height:80px" class="img-fluid">
                                    @else
                                        <img src="{{asset('images/image.png')}}" alt="Logo" style="width:120px">
                                    @endif
                                </td>
                                <td colspan="4" class="text-left">
                                    Code client: {{$commande->client->code}} <br>  
                                    Nom Client : {{$commande->client->nom_client}} <br>
                                    Télèphone : {{$commande->client->telephone}} <br>  
                                    Adresse : {{$commande->client->adresse}} <br>  
                                    @php
                                        $time = strtotime($date);
                                        $dateFacture = date('d/m/Y',$time);
                                    @endphp
                                    Date facture : {{$dateFacture}}<br>   
                                </td>
                            </tr>
                            <tr >
                                <th colspan="7" style="text-align:center; background-color:rgb(235, 233, 233); font-size:20px">
                                    Facture N° : {{$code}}
                                </th>
                            </tr>
                            <tr style="height:10px"></tr>
                            <tr style="height:10px; font-size : 12px">
                                <th colspan="7">
                                    @if($commande->oeil_gauche)
                                    Oeil gauche : {{$commande->oeil_gauche}} &nbsp;&nbsp;&nbsp; 
                                    @endif
                                    @if($commande->oeil_droite)
                                    Oeil droite : {{$commande->oeil_droite}}
                                    @endif
                                </th>
                            </tr>
                            <tr style="height:10px; font-size : 12px;">
                                <th colspan="7" class="text-right">
                                    Montants exprimés en Dirham
                                </th>
                            </tr>
                            <tr>
                                <th style="width:6%" class="text-center border">Réf.</th>
                                <th style="width:45%" class="text-center border">Désignation</th>
                                <th style="width:5%" class="text-center border">Qté</th>
                                <th style="width:12%" class="text-center border">PU. HT</th>
                                <th style="width:5%" class="text-center border">TVA</th>
                                <th style="width:12%" class="text-center border">MT. HT</th>
                                <th style="width:15%" class="text-center border">MT. TTC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $TTC = 0;
                                $HT = 0;
                            @endphp
                            @foreach($lignecommandes as $lignecommande)
                            @php 
                                $montant_HT = $lignecommande->total_produit / (1 + $lignecommande->produit->TVA/100);
                                $prix_unit_HT = $montant_HT / $lignecommande->quantite;
                                $HT += $montant_HT;
                                $TTC += $lignecommande->total_produit;
                            @endphp
                            <tr>
                                <td style="width:10%" class="text-left border">{{$lignecommande->produit->code_produit}}</td>
                                <td style="width:45%" class="text-left border">{{$lignecommande->nom_produit}}</td>
                                <td style="width:5%" class="text-center border">{{$lignecommande->quantite}}</td>
                                <td style="width:10%" class="text-right border">{{number_format($prix_unit_HT,2)}}</td>
                                <td style="width:5%" class="text-center border">{{$lignecommande->produit->TVA}}</td>
                                <td style="width:10%" class="text-right border">{{number_format($montant_HT,2)}}</td>
                                <td style="width:15%" class="text-right border">{{$lignecommande->total_produit}}</td>
                            </tr>
                            @endforeach
                            @php 
                            $TVA = $TTC - $HT;
                            @endphp
                            <tr>
                                <td colspan="4" style="border-bottom: none !important"></td>
                                <th colspan="2" class="text-right border">Total HT :</th>
                                <td colspan="1" class="text-right border">{{number_format($HT,2)}}</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="border-bottom: 0px solid red"></td>
                                <th colspan="2" class="text-right border">Total TVA :</th>
                                <td colspan="1" class="text-right border">{{number_format($TVA,2)}}</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="border-bottom: none !important"></td>
                                <th colspan="2" class="text-right border">Total TTC :</th>
                                <td colspan="1" class="text-right border">{{number_format($TTC,2)}}</td>
                            </tr>
                            <tr>
                                <th></th>
                                <th colspan="6">
                                    Arrêté la présente facture à la somme : 
                                </th>
                            </tr>
                            <tr>
                                <th></th>
                                <th colspan="6">
                                    @php
                                    $numberToWords = new NumberToWords\NumberToWords();
                                    // $numberTransformer = $numberToWords->getNumberTransformer('fr');
                                    $currencyTransformer = $numberToWords->getCurrencyTransformer('fr');
                                    // $numberWord = $numberTransformer->toWords(number_format($TTC,2)); // outputs "five thousand one hundred twenty"
                                    $numberWord = $currencyTransformer->toWords(number_format($TTC,2)*100,'MAD'); // outputs "five thousand one hundred twenty"
                                    @endphp    
                                    {{strtoupper($numberWord)}} 
                                </th>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr style="height:30px"></tr>
                            <tr style="height: 10px">
                                <td colspan="7" class="text-center" style="text-align:center; background-color:rgb(235, 233, 233)">
                                    {!!$adresse!!}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="text-center">
                        <form  method="POST" action="{{route('facture.store2')}}">
                            @csrf 
                            <input type="hidden" name="commande_id" value="{{$commande->id}}">
                            <input type="hidden" name="date" value="{{$date}}">
                            <input type="hidden" name="code" value="{{$code}}">
                            <input type="hidden" name="total_HT" value="{{$prix_HT}}">
                            <input type="hidden"  name="total_TVA" value="{{$TVA}}">
                            <input type="hidden" name="total_TTC"  value="{{$priceTotal}}" >
                            <input type="hidden" name="reglement" value="à réception">
                            <input type="submit" class="btn btn-info bnt-lg" value="Valider">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>