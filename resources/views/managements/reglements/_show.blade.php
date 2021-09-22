<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$reglement->code}}</title>
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
        .table { 
            width: 100% ;
        }
        .table tbody{ 
            font-size: 12px;
        }
        .table tfoot{ 
            font-size: 10px;
        }
        .table th, .table td { 
            border-top: none ;
            border-bottom: none ;
        }
        #content1 {
            /* height: 842px;
            width: 595px; */
            /* height: 565px;
            width: 830px; */
            /* to centre page on screen*/
            /* margin-left: auto;
            margin-right: auto; */
            /* border : 1px solid red; */
        }
        #content0 {
            /* height: 800px;
            width: 570px;
            background-color : yellow;
            border : 1px solid black;
            margin-left: auto;
            margin-right: auto; */
            /* height: 565px;
            width: 830px; */
            /* to centre page on screen*/
            /* border : 1px solid red; */
        }
        #content10 {
            /* height: 700px;
            width: 500px;
            background-color : yellow;
            border : 1px solid black;
            margin-left: auto;
            margin-right: auto; */
            /* height: 565px;
            width: 830px; */
            /* to centre page on screen*/
            /* border : 1px solid red; */
        }
    </style>
</head>
<body>
    <br>
    <!-- #########################################################" -->
    <div class="container">
        <div class="row">
            <div class="col-10">
                <div id="content" style="">
                    <div class="align-center" style="display: flex;align-items: center;justify-content: center;">
                        <div class="card" style="background-color: rgba(255, 249, 249, 0.842); margin-top:20px;border : 0px solid black">
                            <div class="card-body">
                                <table class="table table-hover" border="0">
                                    <thead>
                                        <tr >
                                            <th colspan="3" style="text-align:center; background-color:rgb(235, 233, 233); font-size:20px">
                                                RECEPISSE DE REGLEMENT
                                            </th>
                                        </tr>
                                        <tr>
                                            <th  colspan="2" class="text-right">
                                                <span style="background-color:yellow">
                                                    @php
                                                    $list = explode("-",$reglement->code);
                                                    $list1 = $list[1];
                                                    $list2 = $list[2];
                                                    $code = $list1.'-'.$list2;
                                                    @endphp
                                                    Reçu n° : {{$code}}
                                                </span>
                                            </th>
                                            <th   class="text-right">
                                                @php
                                                $time = strtotime($reglement->date);
                                                $date = date('d/m/Y',$time);
                                                @endphp
                                                Le, {{$date}}
                                            </th>
                                        </tr>
                                        <tr><td colspan="3"></td></tr>
                                    </thead>
                                    <tbody>
                                        <!-- Client -->
                                        <tr>
                                            <td rowspan="7" >
                                                <!-- <img src="{{asset('images/logo.jpg')}}" alt="logo" style="width:100px"> -->
                                                @if($company && ($company->logo || $company->logo != null))
                                                    <img src="{{Storage::url($company->logo ?? null)}}"  alt="logo" style="width:80px;height:80px" class="img-fluid">
                                                @else
                                                    <img src="{{asset('images/image.png')}}" alt="Logo" style="width:120px">
                                                @endif
                                            </td>
                                            <th  class="text-left border">Client:</th>
                                            <td  class="text-left border">{{$reglement->commande->client->code}} | {{$reglement->commande->client->nom_client}}</td>
                                        </tr>
                                        <!-- Adresse Client -->
                                        <tr>
                                            <!-- <td  class="text-right border"></td> -->
                                            <th  class="text-left border">Adresse :</th>
                                            <td  class="text-left border">{{$reglement->commande->client->adresse}}</td>
                                        </tr>
                                        <!-- Code Comande -->
                                        <tr>
                                            <!-- <td  class="text-right border"></td> -->
                                            <th  class="text-left border">Commande :</th>
                                            <td  class="text-left border">{{$reglement->commande->code}}</td>
                                        </tr>
                                        <!-- Total à payer -->
                                        <tr>
                                            <!-- <td  class="text-right border"></td> -->
                                            <th  class="text-left border">Total à payer :</th>
                                            <td  class="text-left border">{{$reglement->commande->total}} dh</td>
                                        </tr>
                                        <!-- Montant réglé -->
                                        <tr>
                                            <!-- <td  class="text-right border"></td> -->
                                            <th  class="text-left border">Montant réglé :</th>
                                            <td  class="text-left border">{{$reglement->avance}} dh</td>
                                        </tr>
                                        <!-- Total des règlements -->
                                        <tr>
                                            <!-- <td  class="text-right border"></td> -->
                                            <th  class="text-left border">Total des règlements :</th>
                                            @php
                                            $total_reg = $reglement->commande->total - $reglement->reste;
                                            @endphp
                                            <td  class="text-left border">{{number_format($total_reg, 2, '.', '')}} dh</td>
                                        </tr>
                                        <!-- Reste à payer -->
                                        <tr>
                                            <!-- <td  class="text-right border"></td> -->
                                            <th  class="text-left border">Reste à payer :</th>
                                            <td  class="text-left border">{{$reglement->reste}} dh</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr ><td colspan="3"></td></tr>
                                        <tr>
                                            <td colspan="3" class="text-center" style="background-color:rgb(235, 233, 233);">
                                                <!-- Siège social : ITIC SOLUTION -3 ,immeuble Karoum, Av Alkhansaa, Cité Azmani-83350 OULED TEIMA, Maroc<br>
                                                Téléphone : 085785435457890 -https://itic-solution.com/ -Contact@itic-solution.com <br>
                                                I.F. :4737443330 - ICE: 002656767875765788978 -->
                                                {!!$adresse!!}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="text-center" style="background-color:rgb(235, 233, 233); display:none">
                    Siège social : ITIC SOLUTION -3 ,immeuble Karoum, Av Alkhansaa, Cité Azmani-83350 OULED TEIMA, Maroc<br>
                    Téléphone : 085785435457890 -https://itic-solution.com/ -Contact@itic-solution.com <br>
                    I.F. :4737443330 - ICE: 002656767875765788978
                </div> -->
            </div>
            <div class="col-2" style="text-align : right">
                <div class="text-center">
                    <!-- <a href="route('pdf.generate',['id'=>$reglement->id])" class="btn btn-primary">Imprimer</a> -->
                    <div class="text-center">
                        <i class="fas fa-arrow-circle-left fa-3x" onclick="window.location.assign('{{route('commande.index')}}')"></i>
                    </div>
                    <br>
                    <button onclick="onprint()" class="btn btn-primary">Créer PDF</button>
                </div>
            </div>
        </div>
    </div>
    <!-- #########################################################" -->
    <div style="display : none">
        <div id="pdf"></div>
    </div>
    <!-- #########################################################" -->
    <!-- <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.1/html2canvas.min.js" integrity="sha512-Ki6BxhTDkeY2+bERO2RGKOGh6zvje2DxN3zPsNg4XhJGhkXiVXxIi1rkHUeZgZrf+5voBQJErceuCHtCCMuqTw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="{{ asset('js/jspdf.umd.min.js') }}"></script>
    <script src="{{ asset('js/html2canvas.min.js') }}"></script>
    <script type="application/javascript">
        function onprint(){
            // -------- declarartion des jsPDF and html2canvas ------------//
            window.html2canvas = html2canvas;
            window.jsPDF = window.jspdf.jsPDF;
            // -------- Change Style ------------//
            $('#pdf').html($('#content').html());
            $('#pdf').prop('style','height: 700px;width: 500px;margin-left: auto;margin-right: auto;');
            // -------- Initialization de doc ------------//
            var doc = new jsPDF("p", "pt", "a4",true);
            // var doc = new jsPDF("l", "pt", "a4",true);
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
                    var code = "<?php echo $reglement->code;?>";
                    // doc.save("REG-"+code+".pdf");
                    doc.save(code+".pdf");
                },
                x: 50,
                y: 50,
            });
        }
    </script>
</body>
</html>