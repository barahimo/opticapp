<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>REG n° : {{$reglement->code}}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- My Styles -->
    <style>
        .table th, .table td { 
            border-top: none ;
            border-bottom: none ;
        }
    </style>
</head>
<body>
    <div class="align-center" style="display: flex;align-items: center;justify-content: center;">
        <div style="width : 90%;">
            <div class="card" style="background-color: rgba(255, 249, 249, 0.842); width:100%; margin-top:20px">
                <div class="card-body">
                    <table class="table table-hover" border="0" style="border: 0px solid red">
                        <thead>
                            <tr >
                                <th colspan="6" style="text-align:center; background-color:rgb(235, 233, 233); font-size:20px">
                                    RECEPISSE DE REGLEMENT
                                </th>
                            </tr>
                            <tr>
                                <th style="width:20%"></th>
                                <th style="width:60%" class="text-center" colspan="4">
                                    <span style="background-color:yellow">
                                        Reçu n° : REG-{{$reglement->code}}
                                    </span>
                                </th>
                                <th  style="width:20%" class="text-right">
                                    @php
                                    $time = strtotime($reglement->date);
                                    $date = date('d/m/Y',$time);
                                    @endphp
                                    Le, {{$date}}
                                </th>
                            </tr>
                            <tr><td colspan="6"></td></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td rowspan="3" style="width:10%">
                                    <!-- <img src="{{asset('images/logo.jpg')}}" alt="" style="width:120px"> -->
                                </td>
                                <td style="width:15%" class="text-right border">Client:</td>
                                <td style="width:25%" class="text-left border">{{$reglement->commande->client->code}} | {{$reglement->commande->client->nom_client}}</td>
                                <td style="width:5%"></td>
                                <td style="width:15%" class="text-right border">Commande :</td>
                                <td style="width:30%" class="text-left border">
                                        BON-{{$reglement->commande->code}} | 
                                        <span style="background-color:yellow">
                                        Total à payer : {{$reglement->commande->total}} dh
                                        </span>
                                </td>
                            </tr>
                            <tr>
                                <!-- <td style="width:10%" class="text-right border"></td> -->
                                <td style="width:15%" class="text-right border">Adresse : </td>
                                <td style="width:25%" class="text-left border">{{$reglement->commande->client->adresse}}</td>
                                <td style="width:5%"></td>
                                <td style="width:15%" class="text-right border">Total des règlements : </td>
                                @php
                                $total_reg = $reglement->commande->total - $reglement->reste;
                                @endphp
                                <td style="width:30%" class="text-left border">{{number_format($total_reg, 2, '.', '')}} dh</td>
                            </tr>
                            <tr>
                                <!-- <td style="width:10%" class="text-right border"></td> -->
                                <td style="width:15%" class="text-right border">Montant réglé :</td>
                                <td style="width:25%" class="text-left border">{{$reglement->avance}} dh</td>
                                <td style="width:5%"></td>
                                <td style="width:15%" class="text-right border">Reste à payer : </td>
                                <td style="width:30%" class="text-left border">{{$reglement->reste}} dh</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr><td colspan="6"></td></tr>
                            <tr style="height: 10px">
                                <td colspan="6" class="text-center" style="text-align:center; background-color:rgb(235, 233, 233)">
                                    <address>
                                        Siège social : ITIC SOLUTION -3 ,immeuble Karoum, Av Alkhansaa, Cité Azmani-83350 OULED TEIMA, Maroc<br>
                                        Téléphone : 085785435457890 -https://itic-solution.com/ -Contact@itic-solution.com <br>
                                        I.F. :4737443330 - ICE: 002656767875765788978
                                    </address>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>