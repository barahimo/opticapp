@extends('layout.dashboard')
@section('contenu')
<!-- ##################################################################### -->
<div class="container">
<div>
    <a href="{{route('commande.index2')}}" class="btn btn-primary m-b-10 ">
      <i class="fa fa-plus">&nbsp;Commande</i>
    </a>
  </div>
  <br>
  <div class="row">
    <div class="col-6">
      <select class="form-control" name="client" id="client">
        @foreach($clients as $client)
        <option value="{{$client->id }}">{{ $client->nom_client}}</option>
        @endforeach
      </select>
    </div>
    <div class="col-6">
      <select class="form-control" name="search" id="search">
        <option value="">Global</option>
        <option value="r">Réglée</option>
        <option value="nr">Non réglée</option>
        <option value="f">Facturée</option>
        <option value="nf">Non facturée</option>
      </select>
    </div>
  </div>
  <br>
  <div class="card" style="background-color: rgba(241, 241, 241, 0.842)">
    <div class="card-body">
      <table class="table" id="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Client</th>
            <th>Montant total</th>
            <th>Montant payer</th>
            <th>Reste à payer</th>
            <th>Status</th>
            <th>Facture</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- ---------  BEGIN SCRIPT --------- -->
<script type="text/javascript">
  $(document).ready(function(){
    searchSelect(null,null);
    // -----------Change Select_Search--------------//
    $(document).on('change','#search',function(){
      var search=$(this).val();
      searchSelect(null,search);
    });
    // -----------End Select_Search--------------//
    // -----------Change Select_Client--------------//
    $(document).on('change','#client',function(){
      var client=$(this).val();
      searchSelect(client,null);
    });
    // -----------End Select_Client--------------//
  });
  // -----------My function--------------//
  function searchSelect(param1,param2){
    var table=$('#table');
    $.ajax({
      type:'get',
      url:'{!!Route('commande.getCommandes')!!}',
      data:{'client':param1,'search':param2},
      success:function(data){
        var ligne = '';
        var commandes = data.commandes;
        var lignecommandes = data.lignecommandes;
        var reglements = data.reglements;
        var clients = data.clients;
        commandes.forEach(commande => {
          // ************************ //
          var somme = 0;
          var avance = 0;
          var reste = 0;
          lignecommandes.forEach(lignecommande => {
              if(lignecommande.commande_id == commande.id)
                  somme += parseFloat(lignecommande.total_produit);
          })
          reglements.forEach(reglement => {
              if(reglement.commande_id == commande.id)
                  avance += parseFloat(reglement.avance);
          })
          // ************************ //
          var url = "{{route('commande.edit2',['id'=>":id"])}}".replace(':id', commande.id);
          var url_reg = "{{route('reglement.create3',['commande'=>"commande_id"])}}".replace('commande_id', commande.id);
          var url_fac = "{{route('commande.facture2',['commande'=>"commande_id"])}}".replace('commande_id', commande.id);
          var facture = "NF";
          if(commande.facture == "f")
            facture = "F";
          var status = "R";
          if(commande.reste > 0)
            status = "NR";
            // '/reglements/create3'
          ligne += `<tr>
              <td>${commande.id}</td>
              <td>${commande.date}</td>
              <td>${commande.nom_client}</td>
              <td>${commande.total}</td>
              <td>${commande.avance}</td>
              <td>${commande.reste}</td>
              <td>${status}</td>
              <td>${facture}</td>
              <td>
                <button class="btn btn-link" onclick="window.location.assign('${url_fac}')"><i class="fa fa-plus">&nbsp;Facture</i></button>
                &nbsp;&nbsp;
                <button class="btn btn-link" onclick="window.location.assign('${url_reg}')"><i class="fa fa-plus">&nbsp;Règlement</i></button>
                &nbsp;&nbsp;
                <a class="btn btn-danger" href=${url}>Edit</a>
              </td>
            </tr>`;

        });
        table.find('tbody').html("");
        table.find('tbody').append(ligne);
        actionButton();    
      },
      error:function(){
        console.log([]);    
      }
    });
  }
  function actionButton(){
    table = $('#table');
    list = table.find('tbody').find('tr');
    for (let index = 0; index < list.length; index++) {
      var item = list.eq(index).find('td');
      var status = item.eq(6);
      var facture = item.eq(7);
      var action = item.eq(8).find('button');
      var btnFacture = action.eq(0);
      var btnStatus = action.eq(1);
      (facture.html() == 'F') ?btnFacture.attr('disabled',true) : btnFacture.attr('disabled',false);
      (status.html() == 'R') ? btnStatus.attr('disabled',true): btnStatus.attr('disabled',false);
    }
  }
</script>
<!-- ##################################################################### -->
@endsection

