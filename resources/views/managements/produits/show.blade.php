@extends('layout.dashboard')

@section('contenu')
<center>
  <table style=" width: 700px; margin-top:20px;background-color:rgba(241, 241, 241, 0.842);" class="table table-hover ">
    <thead>
      <tr  >
        <th style=" font-size:25px; text-align:center; background-color:white;" colspan="2" scope="col">Fiche Produit</th>
    
      </tr>
    </thead>
    <tbody>
          <tr>
            <th scope="col">Code de produit :</th>
            <td>{{$produit->code_produit}}</td>
          </tr>
          <tr>
            <th scope="col">Nom de produit :</th>
            <td>{{$produit->nom_produit}}</td>
          </tr>
          <tr>
            <th scope="col">TVA :</th>
            <td>{{$produit->TVA}}%</td>
          </tr>
          <tr>
            <th scope="col">Prix HT :</th>
            <td>{{number_format($produit->prix_produit_HT,2)}} DH</td>
          </tr>
          <tr>
            <th scope="col">Prix TTC :</th>
            <td>{{number_format($produit->prix_produit_TTC,2)}} DH</td>
          </tr>
          <tr>
            <th scope="col">Description :</th>
            <td>{{$produit->description}}</td>
          </tr>
          <tr>
            <th scope="col">Categorie:</th>
            <td>{{$produit->categorie->nom_categorie}}</td>
          </tr>
          <tr>
            <th scope="col">Créé le :</th>
            <td>{{$produit->created_at}}</td>
          </tr>
          <tr>
            <th scope="col">Modifié le :</th>
            <td>{{$produit->updated_at}}</td>
          </tr>
          <tr>
            <td colspan="2">
              <a href="{{action('ProduitController@index')}}" class="btn btn-primary" style="margin-left: 100px ; margin-top: 20px ;">Retour</a>
            </td>
          </tr>
        
    </tbody>
  </table>
</center>







@endsection

