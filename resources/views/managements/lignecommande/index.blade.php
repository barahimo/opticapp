@extends('layout.dashboard')

@section('contenu')

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3">
                <h4>Panneau LigneCommandes</h4>
                

            </div>
            @if(session()->has('status'))
                <div class="alert  alert-success"> 
                    {{ session()->get('status')}}
                </div>
            @endif





            <div class="col-md-9 text-right">
                <a href="{{route('lignecommande.create')}}" class="btn btn-primary m-b-10 "><i class="fa fa-user-plus">Ajouer Nouveau lignecommande</i></a>
            </div> 
            

            <table class="table">
                    
                <tr>
                <td scope="col">


                    @include('partials.searchlignecommande')

                </td>
                
                </tr>
            
            </table> 

        </div>
        <div class="card" style="background-color: rgba(209, 204, 219, 0.842);">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#id</th>
                            
                            <th scope="col"> idcommande</th>
                            <th scope="col"> Nom produit</th>
                            <th scope="col"> quantite </th>

                            <th scope="col">Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lignecommandes as $lignecommande)
                            <tr>
                                <th scope="row" >{{$lignecommande->id }}</th>
                                {{-- <td>{{$lignecommande->cadre}}</td> --}}
                                <td>{{$lignecommande->commande_id}}</td>
                                <td>{{$lignecommande->nom_produit}}</td>
                                <td>{{$lignecommande->quantite}}</td>
                            <td>
                                <form style="display: inline" method="POST" action="{{route('lignecommande.destroy',['lignecommande'=> $lignecommande])}}">
                                    @csrf 
                                    @method('DELETE')
                                    <a href="{{ action('LignecommandeController@show',['lignecommande'=> $lignecommande])}}" class="btn btn-secondary btn-lg">detailler</i></a>
                                    <a href="{{route('Lignecommande.edit',['lignecommande'=> $lignecommande])}}"class="btn btn-primary btn-lg">editer</i></a>
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

