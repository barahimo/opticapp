@extends('layout.dashboard')

@section('contenu')

<div class="row justify-content-center">
    <div class="col-md-10">
        
        <div class="card" style="background-color: rgba(209, 204, 219, 0.842); margin-top:60px">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom produit</th>
                            <th>Code produit</th>
                            <th>TVA</th>
                            <th>Prix_produit_HT</th>
                            <th>Description</th>
                            <th>Categorie_id</th>
                            
                            {{-- <th>id_client</th>
                            <th>total</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produits as $produit)
                          <tr>
                              <td>{{$produit->id }}</td>
                              <td>{{$produit->nom_produit}}</td>
                              <td>{{$produit->code_produit}}</td>
                              <td>{{$produit->TVA}}</td>
                              <td>{{$produit->prix_produit_HT}}</td>
                              <td>{{$produit->description}}</td>
                              <td>{{$produit->categorie_id}}</td>

                              <td>
                                  {{-- <a href="" class="btn btn-secondary btn-sm">info</i></a>
                                  <a href="{{route('client.edit',['client'=> $client])}}"class="btn btn-success btn-sm">editer</i></a>
                                  <a href="{{route('client.destroy',['client'=> $client])}}" class="btn btn-danger btn-sm">archiver</i></a> 
                                   --}}
                                  {{-- hadi  liltaht khdama --}}

                                  <form style="display: inline" method="POST" action="{{route('produit.destroy',['produit'=> $produit])}}">
                                    @csrf {{-- génère un toke pur protéger le formulaie--}}
                                   @method('DELETE')
                                   <a href="{{ action('ProduitController@show',['produit'=> $produit])}}" class="btn btn-secondary btn-sm">detailler</i></a>
                                   <a href="{{route('produit.edit',['produit'=> $produit])}}"class="btn btn-success btn-sm">editer</i></a>
                                   <button class="btn btn-danger btn-sm" type="submit">archiver</button>
                                 </form>  

                              </td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        {{ $produits->links()}}
    </div>
</div>

@endsection

