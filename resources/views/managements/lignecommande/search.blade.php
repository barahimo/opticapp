@extends('layout.dashboard')

@section('contenu')

<div class="row justify-content-center">
    <div class="col-md-10">
       
        <div class="card" style="background-color: rgba(209, 204, 219, 0.842); margin-top:60px">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#id</th>
                            
                            <th> idcommande</th>
                            <th> Nom produit</th>
                            <th> quantite </th>

                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lignecommandes as $lignecommande)
                          <tr>
                              <td>{{$lignecommande->id }}</td>
                              {{-- <td>{{$lignecommande->cadre}}</td> --}}
                              <td>{{$lignecommande->commande_id}}</td>
                              <td>{{$lignecommande->nom_produit}}</td>
                              <td>{{$lignecommande->quantite}}</td>
                            <td>
                                <form style="display: inline" method="POST" action="{{route('lignecommande.destroy',['lignecommande'=> $lignecommande])}}">
                                    @csrf 
                                   @method('DELETE')
                                   <a href="{{ action('LignecommandeController@show',['lignecommande'=> $lignecommande])}}" class="btn btn-secondary btn-lg">detailler</i></a>
                                   <a href="{{route('lignecommande.edit',['lignecommande'=> $lignecommande])}}"class="btn btn-primary btn-lg">editer</i></a>
                                   <button class="btn btn-danger btn-lg" type="submit">archiver</button>
                                 </form>  

                            </td>

                              
                          </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        {{ $lignecommandes->links()}}
    </div>
</div>

@endsection

