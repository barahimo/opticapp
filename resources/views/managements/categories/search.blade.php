@extends('layout.dashboard')

@section('contenu')

<div class="row justify-content-center">
    <div class="col-md-10">
       
        <div class="card" style="background-color: rgba(209, 204, 219, 0.842);margin-top:60px">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#id</th>
                            <th>nom Categorie</th>
                            <th>Description</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $categorie)
                          <tr>

                              <td>{{$categorie->id }}</td>
                              <td>{{$categorie->nom_categorie}}</td>
                              <td>{{$categorie->description}}</td>
                              

                              <td>
                                  {{-- <a href="" class="btn btn-secondary btn-sm">info</i></a>
                                  <a href="{{route('categorie.edit',['categorie'=> $categorie])}}"class="btn btn-success btn-sm">editer</i></a>
                                  <a href="{{route('categorie.destroy',['categorie'=> $categorie])}}" class="btn btn-danger btn-sm">archiver</i></a> 
                                   --}}
                                  {{-- hadi  liltaht khdama --}}

                                  <form style="display: inline" method="POST" action="{{route('categorie.destroy',['categorie'=> $categorie])}}">
                                    @csrf {{-- génère un toke pur protéger le formulaie--}}
                                   @method('DELETE')
                                   <a href="{{ action('CategorieController@show',['categorie'=> $categorie])}}" class="btn btn-secondary btn-sm">detailler</i></a>
                                   <a href="{{route('categorie.edit',['categorie'=> $categorie])}}"class="btn btn-success btn-sm">editer</i></a>
                                   <button class="btn btn-danger btn-sm" type="submit">archiver</button>
                                 </form>  

                              </td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        {{ $categories->links()}}
    </div>
</div>

@endsection


