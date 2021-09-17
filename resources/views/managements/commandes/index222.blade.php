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
      <option value="">--La liste des clients--</option>
        @foreach($clients as $client)
        <option value="{{$client->id }}">{{ $client->nom_client}}</option>
        @endforeach
      </select>
    </div>
    <div class="col-6">
      <div class="row">
          <div class="form-check">
              <input type="checkbox" class="form-check-input" name="f" id="f" value="f" checked>
              <label for="f">facturée</label>
          </div>
          &nbsp;&nbsp;&nbsp;&nbsp;
          <div class="form-check">
              <input type="checkbox" class="form-check-input" name="nf" id="nf" value="nf" checked>
              <label for="nf">Non facturée</label>
          </div>
          &nbsp;&nbsp;&nbsp;&nbsp;
          <div class="form-check">
              <input type="checkbox" class="form-check-input" name="r" id="r" value="r" checked>
              <label for="r">Réglée</label>
          </div>
          &nbsp;&nbsp;&nbsp;&nbsp;
          <div class="form-check">
              <input type="checkbox" class="form-check-input" name="nr" id="nr" value="nr" checked>
              <label for="nr">Non réglée</label>
          </div>
      </div>
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
    searchSelect(null,'all','all');
    // -----------Change Select_Facturée--------------//
    $(document).on('change','#f',function(){
      search();
    });
    // -----------End Select_Facturée--------------//
    // -----------Change Select_NonFacturée--------------//
    $(document).on('change','#nf',function(){
      search();
    });
    // -----------End Select_NonFacturée--------------//
    // -----------Change Select_Reglée--------------//
    $(document).on('change','#r',function(){
      search();
    });
    // -----------End Select_Reglée--------------//
    // -----------Change Select_NonReglée--------------//
    $(document).on('change','#nr',function(){
      search();
    });
    // -----------End Select_NonReglée--------------//
    // -----------Change Select_Client--------------//
    $(document).on('change','#client',function(){
      // var client=$(this).val();
      // searchSelect(client,null);
      search();
    });
    // -----------End Select_Client--------------//
  });
  // -----------My function--------------//
  function searchSelect(param1,param2,param3){
    var table=$('#table');
    $.ajax({
      type:'get',
      url:'{!!Route('commande.getCommandes2')!!}',
      data:{'client':param1,'facture':param2,'status':param3},
      success:function(data){
        var lignes = '';
        var commandes = data;
        commandes.forEach(commande => {
          // ************************ //
          var url_edit = "{{route('commande.edit2',['id'=>":id"])}}".replace(':id', commande.id);
          var url_show = "{{route('commande.show2',['id'=>":id"])}}".replace(':id', commande.id);
          var url_reg = "{{route('reglement.create3',['commande'=>"commande_id"])}}".replace('commande_id', commande.id);
          var url_fac = "{{route('commande.facture2',['commande'=>"commande_id"])}}".replace('commande_id', commande.id);
          var facture = "NF";
          if(commande.facture == "f")
            facture = "F";
          var status = "R";
          if(commande.reste > 0)
            status = "NR";
          // ************************ //
              // <td>${commande.id}</td>
          lignes += `<tr>
              <td>${commande.code}</td>
              <td>${commande.date}</td>
              <td>${commande.nom_client}</td>
              <td>${commande.total}</td>
              <td>${commande.avance}</td>
              <td>${commande.reste}</td>
              <td>${status}</td>
              <td>${facture}</td>
              <td>
                <button class="btn btn-link" onclick="window.location.assign('${url_fac}')"><i class="fa fa-plus">&nbsp;Facture</i></button>
                &nbsp;&nbsp;<br/>
                <button class="btn btn-link" onclick="window.location.assign('${url_reg}')"><i class="fa fa-plus">&nbsp;Règlement</i></button>
                &nbsp;&nbsp;<br/>
                <a class="btn btn-link" href=${url_edit}>Edit</a>
                &nbsp;&nbsp;<br/>
                <a class="btn btn-link" href=${url_show}>Show</a>
              </td>
            </tr>`;

        });
        table.find('tbody').html("");
        table.find('tbody').append(lignes);
        actionButton();    
      },
      error:function(){
        console.log([]);    
      }
    });
  }
  function search(){
    var f=$('#f');
    var nf=$('#nf');
    var r=$('#r');
    var nr=$('#nr');
    var facture = null;
    var status = null;
    var client = null;
    // -----------------------------------
    if($('#client').val() != "")
      client = $('#client').val(); 
    // -----------------------------------
    if(r.prop("checked") && nr.prop("checked"))
      status = 'all';
    else if(r.prop("checked") && !nr.prop("checked"))
      status = 'r';
    else if(!r.prop("checked") && nr.prop("checked"))
      status = 'nr';
    // -----------------------------------
    if(f.prop("checked") && nf.prop("checked"))
      facture = 'all';
    else if(f.prop("checked") && !nf.prop("checked"))
      facture = 'f';
    else if(!f.prop("checked") && nf.prop("checked"))
      facture = 'nf';
    // -----------------------------------
    searchSelect(client,facture,status);
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

