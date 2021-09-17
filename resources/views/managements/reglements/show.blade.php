@extends('layout.dashboard')

@section('contenu')

<div class="row justify-content-left m-l-10">
    <div class="col-md-8">
        <div class="card" style="background-color: rgba(241, 241, 241, 0.842)">
            <div class="card-body" >

                {{-- <table calss="table">

                    <tr>
                        <th>Nom Client :</th>
                            <td style="width: 500px; height: 30px" > 
                            <input type="text" class="form-control" placeholder="Nom Client">
                        </td>
                    </tr>
                    <tr>
                        <th>Adresse :</th>
                        <td><input type="text" class="form-control" ></td>
                    </tr>
                    <tr>
                        <th>telephone :</th>
                        <td><input type="text" class="form-control" ></td>
                    </tr>

                </table> --}}
                <table class="table">
                    <tr style="text-align: center;background:white; font-size:20px;">
                        <th > Infos Client</th>
                    </tr>

                </table>

                 
                <div class="form-group">
                    <label for="AA"><strong>Nom Complet:</strong></label> 
                    <input type="text" class="form-control" placeholder="Nom Client" value="{{$commande->client->nom_client}}">
                </div>
                <div class="form-group">
                    <label for="AA"><strong>Adresse:</strong></label> 
                     <input type="text" class="form-control" placeholder="Adresse" value="{{$commande->client->adresse}}">
                </div>
                <div class="form-group">
                    <label for="AA"><strong>Telephone:</strong></label> 

                     <input class="form-control" placeholder="telephone" value="{{$commande->client->telephone}}"> 
                </div>
                   
                {{-- &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" class="form-control" placeholder="avance">&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" class="form-control" placeholder="reste">&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="date" class="form-control" placeholder="date">&nbsp;&nbsp; --}}


            </div>
        </div>
    </div>

</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


<div class="row m-l-10" >
    <div  class="col-3">
        <div class="card" style="background-color: rgba(241, 241, 241, 0.842)">
            <div class="card-body" >
                <table class="table">
                    <tr style="text-align: center;background:white; font-size:20px;">
                        <th >info mode</th>
                    </tr>

                </table>

                <div class="form-group">
                 <label for="AA"><strong>mode reglement:</strong></label> 
                 <input type="text" class="form-control" placeholder="Nom Client" value="{{$reglement->mode_reglement}}">
                </div>
                <div class="form-group">
                  <label for="AA"><strong> Avance:</strong></label> 
                 <input type="text" class="form-control" placeholder="Adresse" value="{{$reglement->avance}}">
                </div>
                <div class="form-group">
                 <label for="AA"><strong>Reste:</strong></label>
                <input type="text" class="form-control" placeholder="Adresse" value="{{$reglement->reste}}">
                </div>
            </div>
        </div>
    </div>


    <div  class="col-3">
        <div class="card" style="background-color: rgba(241, 241, 241, 0.842)">
            <div class="card-body" >
                <table class="table">
                    <tr style="text-align: center;background:white; font-size:20px;">
                        <th > Infos commande  </th>
                    </tr>

                </table>

                <div class="form-group">
                 <label for="AA"><strong>commande_id :</strong></label>   
                <input type="text" id="AA" class="form-control" placeholder="Nom Client" value="{{$commande->id}}">
                </div>
                <div class="form-group">
                <label for="BB"> <strong>date:</strong> </label>
                <input type="text" class="form-control" id="BB" placeholder="Adresse" value="{{$commande->date}}">
                </div>
                <div class="form-group">
                <label for="BB"> <strong>Etat de règlement</strong> </label>
                <input type="text" class="form-control" id="BB" placeholder="Adresse" value="{{$reglement->status}}">
                </div>
            </div>
        </div>
    </div>
    <div  class="col-3 m-r-10">
        <div class="card" style="background-color: rgba(241, 241, 241, 0.842)">
            <div class="card-body" >
                <table class="table">
                    <tr style="text-align: center;background:white; font-size:20px;">
                        <th > Dates règelement  </th>
                    </tr>

                </table>
                <div class="form-group">
                    <label for="XX"><strong>créé le :</strong></label>
                    <input type="text" class="form-control" id="XX" placeholder="Nom Client" value="{{$reglement->created_at}}">
                </div>
                <div class="form-group">   
                    <label for="YY"><strong>modifier le :</strong></label>
                    <input type="text" class="form-control" id="YY" placeholder="Adresse" value="{{$reglement->updated_at}}">
                </div>
              
    
                    <a href="{{action('ReglementController@index')}}" class="btn btn-info btn-lg" style=" width:110px; margin-left: 100px ; margin-top: 20px ; margin-left:1030px;">retour</a>
               
            </div>
        
        </div>
        
    </div>
</div>

<a href="{{action('ReglementController@index')}}" class="btn btn-info btn-lg" style=" width:110px; margin-left: 100px ; margin-top: 20px ; margin-left:1030px;">retour</a>




@endsection