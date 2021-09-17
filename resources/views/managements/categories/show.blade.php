@extends('layout.dashboard')
@section('contenu')
{{-- ################################################# --}}
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-12">
                <h2 style="  font-size: font-size: 25px; color:black; text-align:center " class="">Fiche catégorie :  </h2>
            </div>
        </div>
        <div class="card"  style=" background-color:rgba(241, 241, 241, 0.842)">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="nom_categorie"> <strong><strong>Nom Categorie:</strong></strong></label>
                        <pre>{{$categorie->nom_categorie}}</pre>
                    </div>
                    <div class="col-md-6">
                        <label for="name"><strong><strong>Description :</strong></strong></label>
                        <pre>{{$categorie->description}}</pre>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="name"><strong><strong>crée le :</strong></strong></label>
                        <pre>{{$categorie->created_at}}</pre>
                    </div>
                    <div class="col-md-6">
                        <label for="name"><strong> <strong> modifié le :</strong></strong></label>
                        <pre>{{$categorie->updated_at}}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ################################################# --}}
<br>
<div class="row justify-content-center">
    <div class="col-md-12">
    <a href="{{route('categorie.produit',['id'=> $categorie->id])}}" class="btn btn-info btn-lg m-b-10 "> 
        <i class="fa fa-plus">Produit</i>
    </a>
        <div class="card" style="background-color: rgba(241, 241, 241, 0.842)">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th style=" font-size:25px; text-align:center; background-color:white;" colspan="8" scope="col">Produits de la catégorie</th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Libelle</th>
                            <th>TVA</th>
                            <th>prix_produit_HT</th>
                            <th>prix_produit_TTC</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produits as $key => $produit)
                        <tr>
                            <td>{{$key + 1 }}</td>
                            <td>{{$produit->code_produit}}</td>
                            <td>{{$produit->nom_produit}}</td>
                            <td>{{$produit->TVA}}</td>
                            <td>{{$produit->prix_produit_HT}}</td>
                            <td>{{$produit->prix_produit_TTC}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div  class="col-md-12" style="height: 70px">
    <a href="{{action('CategorieController@index')}}" class="btn btn-info btn-lg">
        Retour
    </a>
</div>
{{-- ################################################# --}}
@endsection

