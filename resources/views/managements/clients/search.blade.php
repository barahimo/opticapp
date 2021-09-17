 @extends('layout.dashboard')

@section('contenu')

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="row">
            
    
            

        </div>
        <div class="card" style="background-color: rgba(209, 204, 219, 0.842);margin-top:70px">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#id</th>
                            <th>nom Client</th>
                            <th> Adresse</th>
                            <th> Telephone</th>
                            <th>Code Client</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                          <tr>

                              <td>{{$client->id }}</td>
                              <td>{{$client->nom_client}}</td>
                              <td>{{$client->adresse}}</td>
                              <td>{{$client->telephone}}</td>
                              <td>{{$client->code_client}}</td>

                              <td>
                                  {{-- <a href="" class="btn btn-secondary btn-sm">info</i></a>
                                  <a href="{{route('client.edit',['client'=> $client])}}"class="btn btn-success btn-sm">editer</i></a>
                                  <a href="{{route('client.destroy',['client'=> $client])}}" class="btn btn-danger btn-sm">archiver</i></a> 
                                   --}}
                                  {{-- hadi  liltaht khdama --}}

                                  <form style="display: inline" method="POST" action="{{route('client.destroy',['client'=> $client])}}">
                                    @csrf {{-- génère un toke pur protéger le formulaie--}}
                                   @method('DELETE')
                                   <a href="{{ action('ClientController@show',['client'=> $client])}}" class="btn btn-secondary btn-sm">detailler</i></a>
                                   <a href="{{route('client.edit',['client'=> $client])}}"class="btn btn-success btn-sm">editer</i></a>
                                   <button class="btn btn-danger btn-sm" type="submit">archiver</button>
                                 </form>  

                              </td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        {{ $clients->links()}}
    </div>
    <div  class="col-md-3" style="height: 70px" >
        {{-- <button type="button" class="btn btn-dark">Dark</button> --}}
        <a href="{{action('ClientController@index')}}" class="btn btn-primary" style="margin-left: 100px ; margin-top: 20px ;">retour</a>
    </div>
</div>

@endsection


