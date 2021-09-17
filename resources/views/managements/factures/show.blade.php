<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Facture N° : {{$facture->code}}</title>
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
    <style>
        .table th, .table td { 
            border-top: none ;
            border-bottom: none ;
            padding-top: 4px; 
            padding-bottom: 4px;
        }
        #content{
            width: 550px;
            height: 800px;
            margin-left: auto;
            margin-right: auto;
            font-size:12px;
            /* border : 1px solid black;  */
            /* background-color : yellow; */
        }
    </style>
</head>
<body>
    <br>
    <!-- #########################################################" -->
    <div class="container">
        <div class="row">
            <div class="col-10">
                <div id="content">
                    <div class="align-center" style="display: flex;align-items: center;justify-content: center;">
                        <div class="card" style="background-color: rgba(255, 249, 249, 0.842); width:100%; margin-top:20px;border : 0px solid black">
                            <div class="card-body">
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
                                                    $time = strtotime($facture->date);
                                                    $date = date('d/m/Y',$time);
                                                @endphp
                                                Date facture : {{$date}}<br>   
                                            </td>
                                        </tr>
                                        <tr >
                                            <!-- <th colspan="7" style="text-align:center; background-color:rgb(235, 233, 233); font-size:20px"> -->
                                            <th colspan="7" style="text-align:center; background-color:rgb(235, 233, 233);">
                                                Facture N° : {{$facture->code}}
                                            </th>
                                        </tr>
                                        <tr style="height:10px"></tr>
                                        <tr style="height:10px; font-size : 7px">
                                            <th colspan="7">
                                                @if($commande->oeil_gauche)
                                                Oeil gauche : {{$commande->oeil_gauche}} &nbsp;&nbsp;&nbsp; 
                                                @endif
                                                @if($commande->oeil_droite)
                                                Oeil droite : {{$commande->oeil_droite}}
                                                @endif
                                            </th>
                                        </tr>
                                        <tr style="height:10px; font-size : 8px;">
                                            <th colspan="7" class="text-right">
                                                Montants exprimés en Dirham
                                            </th>
                                        </tr>
                                        <tr style="font-size:8px ;padding : 0">
                                            <th style="width:6%" class="text-center border">Réf.</th>
                                            <th style="width:45%" class="text-center border">Désignation</th>
                                            <th style="width:5%" class="text-center border">Qté</th>
                                            <th style="width:12%" class="text-center border">PU. HT</th>
                                            <th style="width:5%" class="text-center border">TVA</th>
                                            <th style="width:12%" class="text-center border">MT. HT</th>
                                            <th style="width:15%" class="text-center border">MT. TTC</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size : 8px">
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
                                            <td style="width:10%;" class="text-left border-right border-left">{{$lignecommande->produit->code_produit}}</td>
                                            <td style="width:45%;" class="text-left border-right border-left">{{$lignecommande->produit->nom_produit}}</td>
                                            <td style="width:5%;" class="text-center border-right border-left">{{$lignecommande->quantite}}</td>
                                            <td style="width:10%;" class="text-right border-right border-left">{{number_format($prix_unit_HT,2)}}</td>
                                            <td style="width:5%;" class="text-center border-right border-left">{{$lignecommande->produit->TVA}}</td>
                                            <td style="width:10%;" class="text-right border-right border-left">{{number_format($montant_HT,2)}}</td>
                                            <td style="width:15%;" class="text-right border-right border-left">{{$lignecommande->total_produit}}</td>
                                        </tr>
                                        @endforeach
                                        <tr id="tbody_ligne">
                                            <td class="text-left border-right border-left border-bottom"></td>
                                            <td class="text-left border-right border-left border-bottom"></td>
                                            <td class="text-left border-right border-left border-bottom"></td>
                                            <td class="text-left border-right border-left border-bottom"></td>
                                            <td class="text-left border-right border-left border-bottom"></td>
                                            <td class="text-left border-right border-left border-bottom"></td>
                                            <td class="text-left border-right border-left border-bottom"></td>
                                        </tr>
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
                                                $numberTransformer = $numberToWords->getNumberTransformer('fr');
                                                $currencyTransformer = $numberToWords->getCurrencyTransformer('fr');
                                                // $numberWord = $numberTransformer->toWords(number_format($TTC,2)); // outputs "five thousand one hundred twenty"
                                                // $numberWord = $currencyTransformer->toWords(number_format($TTC,2)*100,'MAD'); // outputs "five thousand one hundred twenty"
                                                // --------------------------------------------------------
                                                $pow9 = pow(10,9);
                                                $pow6 = pow(10,6);
                                                $pow3 = pow(10,3);
                                                $msg = '';
                                                if($TTC>=$pow9){
                                                    $msg = $TTC;
                                                }
                                                else {
                                                    $million = intdiv($TTC , $pow6);
                                                    // $mille = intdiv(($TTC % $pow6) , $pow3);
                                                    $mille = intdiv(fmod($TTC , $pow6) , $pow3);
                                                    // $reste = ($TTC % $pow6) % $pow3;
                                                    $reste = fmod($TTC , $pow3);
                                                    if($million != 0){
                                                        $numberWord1 = $numberTransformer->toWords(number_format($million,2)); // outputs "five thousand one hundred twenty"
                                                        $msg .= $numberWord1.' MILLION ';
                                                    }
                                                    if($mille != 0){
                                                        $numberWord1 = $numberTransformer->toWords(number_format($mille,2)); // outputs "five thousand one hundred twenty"
                                                        $msg .= $numberWord1.' MILLE ';
                                                    }
                                                    $numberWord2 = $currencyTransformer->toWords(number_format($reste,2)*100,'MAD'); // outputs "five thousand one hundred twenty"
                                                    $msg .= $numberWord2;
                                                }
                                                // --------------------------------------------------------
                                                @endphp    
                                                {{strtoupper($msg)}} 
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2" style="text-align : right">
                <div class="text-center">
                    <i class="fas fa-arrow-circle-left fa-3x" onclick="window.location.assign('/facture')"></i>
                </div>
                <br>
                <div class="text-center">
                    <button onclick="onprint()" class="btn btn-primary">Créer PDF</button>
                </div>
            </div>
        </div>
    </div>
    <!-- #########################################################" -->
    <div id="display" style="display : none">
        <div id="pdf"></div>
    </div>
    <!-- #########################################################" -->
    <!-- #########################################################" -->
    <!-- <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.1/html2canvas.min.js" integrity="sha512-Ki6BxhTDkeY2+bERO2RGKOGh6zvje2DxN3zPsNg4XhJGhkXiVXxIi1rkHUeZgZrf+5voBQJErceuCHtCCMuqTw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="{{ asset('js/jspdf.umd.min.js') }}"></script>
    <script src="{{ asset('js/html2canvas.min.js') }}"></script>
    <script type="application/javascript">
        function dimensionTBODY(){
            var tbody = $('#display').find('#pdf').find('table').find('tbody');
            var height_tbody = tbody.outerHeight();
            var lignes = tbody.find('tr');
            // tbody_ligne = lignes.eq(lignes.length - 6);
            // tbody_ligne.height(300-height_tbody);
            $('#pdf').find('#tbody_ligne').height(300-height_tbody);
            // var height_tbody = $('#display').find('table').find('tbody').outerHeight();
            // $('#display').find('#tbody_ligne').height(480-height_tbody);
            // var height_tbody = $('table').find('tbody').outerHeight();
            // $('#tbody_ligne').height(500-height_tbody);
            // console.log(document.getElementById('tr1').offsetHeight);
            // console.log(document.getElementById('tr2').offsetHeight);
        }
        function onprint(){
            // -------- declarartion des jsPDF and html2canvas ------------//
            window.html2canvas = html2canvas;
            window.jsPDF = window.jspdf.jsPDF;
            // -------- Change Style ------------//
            $('#pdf').html($('#content').html());
            dimensionTBODY();
            // $('#pdf').prop('style','height: 700px;width: 500px;margin-left: auto;margin-right: auto;');
            var style = `
                height: 800px;
                width: 550px;
                margin-left: auto;
                margin-right: auto;
                font-size:10px;
            `;
            $('#pdf').prop('style',style);
            // -------- Initialization de doc ------------//
            var doc = new jsPDF("p", "pt", "a4",true);
            // -------- html to pdf ------------//
            // -------- Footer ------------//
            var foot1 = `Siège social : ITIC SOLUTION -3 ,immeuble Karoum, Av Alkhansaa, Cité Azmani-83350 OULED TEIMA, Maroc`;
            var foot2 = `Téléphone : 085785435457890 -https://itic-solution.com/ -Contact@itic-solution.com`;
            var foot3 = `I.F. :4737443330 - ICE: 002656767875765788978`;
            doc.setFontSize(10);//optional
            var pageHeight = doc.internal.pageSize.height || doc.internal.pageSize.getHeight();
            var pageWidth = doc.internal.pageSize.width || doc.internal.pageSize.getWidth();
            // doc.text(foot1, pageWidth / 2, pageHeight  - 50, {align: 'center'});
            // doc.text(foot2, pageWidth / 2, pageHeight  - 35, {align: 'center'});
            // doc.text(foot3, pageWidth / 2, pageHeight  - 20, {align: 'center'});
            // -------- Footer ------------//
            doc.html(document.querySelector("#pdf"), {
                callback: function (doc) {
                    var code = "<?php echo $facture->code;?>";
                    doc.save(code+".pdf");
                },
                x: 20,
                y: 10,
            });
        }
    </script>
</body>
</html>