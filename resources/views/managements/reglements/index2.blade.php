@extends('layout.dashboard')
@section('contenu')
<!-- ##################################################################### -->
<div class="container">
    <div>
        <a id="create" href="{{route('reglement.create2')}}" class="btn btn-primary m-b-10 ">
            <i class="fa fa-plus">&nbsp;Reglement</i>
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
    <div class="col-2">
    </div>
    <div class="col-4">
        <div class="row">
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
  <br>
  <br>
  <div class="card" style="background-color: rgba(241, 241, 241, 0.842)">
    <div class="card-body">
      <table class="table" id="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Commande</th>
            <th>Client</th>
            <th>Montant total</th>
            <th>Montant payer</th>
            <th>Reste à payer</th>
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
    getReglements(null,'all');
    // -----------Change Select_Client--------------//
    $(document).on('change','#client',function(){
      search();
    });
    // -----------End Select_Client--------------//
    // -----------Change Select_Reglée--------------//
    $(document).on('change','#r',function(){
      search();
    });
    // -----------End Select_Reglée--------------//
    // -----------Change Select_nonReglée--------------//
    $(document).on('change','#nr',function(){
      search();
    });
    // -----------End Select_nonReglée--------------//
  });
  // -----------My function--------------//
  test();
  function test(){}
  function search(){
    var r=$('#r');
    var nr=$('#nr');
    var status = null;
    var client = null;
    if($('#client').val() != ""){
      client = $('#client').val(); 
      //get route from client
      var create  = $('#create');
      var url = "{{route('reglement.create2',['client'=>"val"])}}";
      url = url.replace('val', client);
      create.attr('href',url);
    }
    if(r.prop("checked") && nr.prop("checked"))
      status = 'all';
    else if(r.prop("checked") && !nr.prop("checked"))
      status = 'r';
    else if(!r.prop("checked") && nr.prop("checked"))
      status = 'nr';
    getReglements(client,status);
  }
  function getReglements(param1,param2){
    $.ajax({
      type:'get',
      url:'{!!URL::to('getReglements')!!}',
      data:{'client':param1,'status':param2},
      success:function(data){
        console.log(data);

        var table = $('#table');
          table.find('tbody').html("");
          var lignes = '';
          data.forEach(ligne => {
            lignes+=`<tr>
                    <td>${ligne.id}</td>
                    <td>${ligne.date}</td>
                    <td>Cmd_${ligne.commande_id}</td>
                    <td>${ligne.nom_client}</td>
                    <td>${ligne.commande.total}</td>
                    <td>${ligne.avance}</td>
                    <td>${ligne.reste}</td>
                    <td>
                        <button class="btn btn-success" onclick="edit(${ligne.id})"><i class="fas fa-edit"></i></button>
                        &nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger" onclick="remove(${ligne.id})"><i class="fas fa-trash"></i></button>
                    </td>
                    </tr>`;
          });
          table.find('tbody').append(lignes);
      },
      error:function(){
        console.log([]);    
      }
    });
  }
</script>
<!-- ##################################################################### -->
@endsection

