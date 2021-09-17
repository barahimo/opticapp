@extends('layout.dashboard')
@section('contenu')
{{-- ################## --}}
<!-- Content Header (Page header) -->
<div class="content-header sty-one">
    <h1>Fiche de client</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('app.home')}}">Home</a></li>
        <li><i class="fa fa-angle-right"></i> client</li>
    </ol>
</div>
{{-- ################## --}}
<div >
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3">
                <h2 style="  font-size: font-size: 25px; color:black; margin-top:10px; "  >Fiche Client :  </h2>
            </div>
        </div>
        <div class="card" style="background-color:rgba(241, 241, 241, 0.842)">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="name"> <strong><strong>Identifiant:</strong></strong></label>
                        {{$client->code}}
                    </div>
                    <div class="col-md-4">
                        <label for="name"> <strong> <strong>Nom Complet :</strong></strong></label>
                        {{$client->nom_client}}
                    </div>
                    <div class="col-md-4">
                        <label for="name"><strong><strong>nb des commandes :</strong></strong></label>
                        {{$count}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="name"><strong> <strong>Télèphone :</strong></strong></label>
                        {{$client->telephone}}
                    </div>
                    <div class="col-md-4">
                        <label for="name"><strong> <strong>Solde:</strong></strong></label>
                        {{number_format($client->solde,2)}} DH
                    </div>
                    <div class="col-md-4">
                        <label for="name"><strong> <strong>Reste à payer :</strong></strong></label>
                        {{number_format($reste,2)}} DH
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="name"><strong><strong>Adresse :</strong></strong></label>
                        {{$client->adresse}}
                    </div>
                    <div class="col-md-4">
                        <label for="name"><strong><strong>Crée le :</strong></strong></label>
                        {{$client->created_at}}
                    </div>
                    <div class="col-md-4">
                        <label for="name"><strong> <strong>Modifié le :</strong></strong></label>
                        {{$client->updated_at}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card" style="background-color: rgba(241, 241, 241, 0.842)">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr >
                            <th style=" font-size:25px; text-align:center; background-color:white;" colspan="6" scope="col">
                                Les commandes de client
                            </th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Avance</th>
                            <th>Reste</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commandes as $commande)
                            <tr>
                                <td>{{$commande->code }}</td>
                                <td>{{$commande->date}}</td>
                                <td>{{number_format($commande->total,2)}}</td>
                                <td>{{number_format($commande->avance,2)}}</td>
                                <td>{{number_format($commande->reste,2)}}</td>
                                <td>
                                    <form style="display: inline" method="POST" action="{{route('commande.destroy',['commande'=> $commande])}}">
                                    @csrf 
                                    @method('DELETE')
                                    <a href="{{ action('CommandeController@show',['commande'=> $commande])}}" class="btn btn-secondary btn-md">detailler</i></a>
                                    <a href="{{route('commande.edit',['commande'=> $commande])}}"class="btn btn-success btn-md">editer</i></a>
                                    <button class="btn btn-danger btn-md" type="submit">archiver</button>
                                    </form>  

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        {{ $commandes->links()}}
    </div>
</div>
<div  class="col-md-3" style="height: 70px" >
    {{-- <button type="button" class="btn btn-dark">Dark</button> --}}
    <a href="{{action('ClientController@index')}}" class="btn btn-primary" style="margin-left: 100px ; margin-top: 20px ;">retour</a>
</div>


@endsection

