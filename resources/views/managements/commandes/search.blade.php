@extends('layout.dashboard')

@section('contenu')

<div class="row justify-content-center">
    <div class="col-md-10">

        @if(session()->has('status'))
        <script>
          Swal.fire('{{ session('status')}}')
        </script>

      @endif
        
        <div class="card" style="background-color: rgba(209, 204, 219, 0.842); margin-top:60px">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#id</th>
                            <th>Cadre</th>
                            <th> Date</th>
                            <th> oeil_gauche</th>
                            <th> oeil_droit</th>
                            <th>avance</th>
                            <th>reste</th>
                            <th>Nom client</th>
                            
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commandes as $commande)
                          <tr>
                              <td>{{$commande->id }}</td>
                              <td>{{$commande->cadre}}</td>
                              <td>{{$commande->date}}</td>
                              <td>{{$commande->oeil_gauche}}</td>
                              <td>{{$commande->oeil_droite}}</td>
                              <td>{{$commande->avance}}</td>
                              <td>{{$commande->reste}}</td>
                              <td>{{$commande->nom_client}}</td>

                              <td>
                                 
                                  <form style="display: inline" method="POST" action="{{route('commande.destroy',['commande'=> $commande])}}">
                                    @csrf 
                                   @method('DELETE')
                                   <a href="{{ action('CommandeController@show',['commande'=> $commande])}}" class="btn btn-secondary btn-sm">detailler</i></a>
                                   <a href="{{route('commande.edit',['commande'=> $commande])}}"class="btn btn-success btn-sm">editer</i></a>
                                   <button class="btn btn-danger btn-sm" type="submit">archiver</button>
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

@endsection

