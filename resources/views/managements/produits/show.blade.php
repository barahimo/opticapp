@extends('layout.dashboard')
@section('contenu')
{{-- ################## --}}
<!-- Content Header (Page header) -->
<div class="content-header sty-one">
    <h1>Fiche de produit</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('app.home')}}">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Produit</li>
    </ol>
</div>
{{-- ################## --}}
<!-- Main content -->
<div class="content">
    <div class="card text-left">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 ">
                    <h5>Code de produit :</h5>
                    <div>
                        <span class="badge badge-success">{{$produit->code_produit}}</span>
                    </div>
                    <hr>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 ">
                    <h5>Nom de produit : </h5>
                    <div>
                        <span class="badge badge-success">{{$produit->nom_produit}}</span>
                    </div>
                    <hr>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 ">
                    <h5>Catégorie : </h5>
                    <div>
                        <span class="badge badge-success">{{$produit->categorie->nom_categorie}}</span>
                    </div>
                    <hr>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 ">
                    <h5>TVA : </h5>
                    <div>
                        <span class="badge badge-success">{{$produit->TVA}}%</span>
                    </div>
                    <hr>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 ">
                    <h5>Prix HT : </h5>
                    <div>
                        <span class="badge badge-success">{{number_format($produit->prix_produit_HT,2)}} DH</span>
                    </div>
                    <hr>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 ">
                    <h5>Prix TTC : </h5>
                    <div>
                        <span class="badge badge-success">{{number_format($produit->prix_produit_TTC,2)}} DH</span>
                    </div>
                    <hr>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 ">
                    <h5>Crée le : </h5>
                    <div>
                        <span class="badge badge-success">{{$produit->created_at}}</span>
                    </div>
                    <hr>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 ">
                    <h5>Modifié le : </h5>
                    <div>
                        <span class="badge badge-success">{{$produit->updated_at}}</span>
                    </div>
                    <hr>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 ">
                    <h5>Description : </h5>
                    <div>
                    <p class="bafge badge-success">{{$produit->description}}</p>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content -->
@endsection

