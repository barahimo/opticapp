
@extends('layout.dashboard')

@section('contenu')
<center>
<table cellspacing="0" style=" height:500px; width: 800px; margin-top:30px; background-color:rgba(241, 241, 241, 0.842);" class="table table-hover ">
    <thead>
      <tr  >
        <th style=" padding-left:330px; font-size:25px; width:400px; background-color:white; " colspan="4" scope="col"> les lignes de commande</th>
        <!-- {{-- <th style=" padding-left:200px; width:400px; background-color:white; " colspan="2" scope="col">

          <a href="{{route('lignecommandecr.createProduit')}}" class="btn btn-primary m-b-10 "><i class="fa fa-user-plus">Ajouter Produit</i></a>

        </th>
          --}} -->
      </tr>
    </thead>
    <tbody>
        @foreach($lignecommandes as $ligne)

          
        
          <tr style="height: 20px">
            <th >nom Produit :</th>
            <td >{{$ligne->nom_produit}}</td>
            <th >Quantite :</th>
            <td >{{$ligne->quantite}}</td>
          </tr>

          <tr>
            <th scope="col">Prix Total Produit TTC :</th>
            <td>
            
                {{$ligne->total_produit}}
             </td>
            <th>idlignecommande :</th>
            <td>{{$ligne->id}}</td>
          </tr>
          <tr > 
            <td scope="col" colspan="4">
              <hr style="height:5px; background-color:gainsboro">
            </td>
          </tr>
          
    @endforeach    
   
          <tr  >
            <th style=" padding-left:330px; font-size:25px; width:800px; background-color:white; " colspan="4" scope="col">Info client:</th>
        
          </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
    
               <tr>
                <th style="width: 200px" >idclient :</th>
                <td style="width: 200px" >{{$client->id}}</td>
                <th style="width: 200px" >nom client :</th>
                <td style="width: 200px" >{{$client->nom_client}}</td>
              </tr> 
    
             
             
              <tr>
                <th >Adresse :</th>
                <td >{{$client->adresse}}</td>
                <th >Code client :</th>
                <td >{{$client->code_client}}</td>
              </tr>

              <tr>
                <th >oeil_gauche :</th>
                <td >{{$commande->oeil_gauche}}</td>
                <th >oeil_droite :</th>
                <td >{{$commande->oeil_droite}}</td>
              </tr>

              

    
              
    
        @endforeach    
        </tbody>
      </table>
      <a href="{{action('CommandeController@index')}}" class="btn btn-info btn-lg" style=" width:110px; margin-left: 100px ; margin-top: 20px ; margin-left:1030px;">retour</a>

      <!-- <button class="btn btn-primary  "  onclick="window.print()" >imprimer</button> -->
    </center> 

   @endsection