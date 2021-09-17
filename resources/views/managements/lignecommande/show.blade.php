

  @extends('layout.dashboard')

  @section('contenu')
  



  
<center>
  <table style=" width: 900px; margin-top:30px; background-color:rgb(231, 226, 208);" class="table table-hover ">
    



      <form  method="POST" action="{{route('lgcommande.affecte',['lignecommande'=> $lignecommande])}}">
        @csrf 
        
        @method('PUT')
      

      <thead>
        
        <tr  >
          <th style=" padding-left:350px; font-size:25px; background-color:white; " colspan="2" scope="col">le Produit commandé </th>
      
        </tr>
      </thead>

      <tbody>
           
              <th scope="col">nom Produit :</th>
              <td><input id="pu"  name="pu" type="text" value="{{$nom}}" readonly></td>
            </tr>
            <tr>
              <th scope="col"> prix unitaire :</th>
              <td><input id="pu"  name="pu" type="text" value="{{$pu}}" readonly></td>
            </tr>
            <tr>
              <th scope="col">TVA:</th>
              <td><input id="tva" name="tva" type="text" value="{{$tva}}" readonly></td>
            </tr>
            
            
           
            <tr>
              <th scope="col">Quantité :</th>
              <td><input id="qt" name="qt" type="text" value="{{$lignecommande->quantite}}"  ></td>
            </tr>
            <tr>
              <th scope="col">prix TTC :</th>
              <td><input id="ttc" name="ttc" type="text" value="{{$lignecommande->total_produit}}" readonly ></td>
            </tr>
           

          
          
      </tbody>
    </form>
    </table>

  


</center>
  <center>
    <table style=" width: 900px; margin-top:30px; background-color:rgb(231, 226, 208);" class="table table-hover ">
        <thead>
          <tr  >
            <th style=" padding-left:350px; font-size:25px; background-color:white; " colspan="2" scope="col">info LigneCommande</th>
        
          </tr>
        </thead>
        <tbody>
              <tr>
                <th scope="col">IdLigneCommande :</th>
                <td>{{$lignecommande->id}}</td>
              </tr>
             
              <tr>
                <th scope="col"> IdCommande :</th>
                <td>{{$lignecommande->commande_id}}</td>
              </tr>
              
              <tr>
                <th scope="col">Quantité :</th>
                <td>{{$lignecommande->quantite}}</td>
              </tr>
              <tr>
               
              <tr>
                <th scope="col">créé le :</th>
                <td>{{$lignecommande->created_at}}</td>
              </tr>
              <tr>
                <th scope="col">modifié le :</th>
                <td>{{$lignecommande->updated_at}}</td>
              </tr>
            
        </tbody>
      </table>
</center>
<div  class="col-md-3" style="height: 70px" >
    
    <a href="{{action('CommandeController@index')}}" class="btn btn-info btn-lg" style=" width:110px; margin-left: 100px ; margin-top: 20px ; margin-left:1030px;">retour</a>
</div>





@endsection