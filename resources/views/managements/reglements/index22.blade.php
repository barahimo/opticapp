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
    <!-- <div class="card-body" id="divTable"> -->
    <div class="card-body">
      <table class="table" id="table">
        <thead class="thead-dark">
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Client</the>
            <th>Montant total</th>
            <th>Montant payer</th>
            <th>Reste à payer</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>
<!-- ---------  BEGIN SCRIPT --------- -->

<script type="text/javascript">
  $(document).ready(function(){
    getReglements2(null,'all');
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
    getReglements2(client,status);
  }
  function getReglements2(param1,param2){
    $.ajax({
      type:'get',
      url:'{!!URL::to('getReglements2')!!}',
      data:{'client':param1,'status':param2},
      success:function(data){
        // console.log(data);

        var table = $('#table');
          table.find('tbody').html("");
          var lignes = '';
          var details = ''; 
          data.forEach((ligne,index) => {
            details = ''; 
            // console.log(ligne.reglements);
            // ------ begin reglements ------
            ligne.reglements.forEach(reglement => {
              var style = "";
              var btnAvoir = reglement.reglement;
              (reglement.reste > 0) ? style = "color : red" : style = "color : green";
              if(reglement.reglement == 'AV'){
                btnAvoir = `<button  
                    onclick="avoir({
                                    reg_id: ${reglement.id}, 
                                    reg_avance: ${reglement.avance}, 
                                    reg_reste: ${reglement.reste},
                                    cmd_id: ${ligne.id}, 
                                    cmd_avance: ${ligne.avance}, 
                                    cmd_reste: ${ligne.reste}
                                  })"
                    class="btn btn-outline-success">Avoir</button>`;
              }
              var url_show = "{{route('reglement.show2',['id'=>":id"])}}".replace(':id', reglement.id);
              var btnPrint = `<a class="btn btn-outline-info" href=${url_show}>Print</a>`;
              if(reglement.avance != 0) 
                details+=`<tr  style="${style}">
                      <td>${reglement.id}</td>
                      <td>${reglement.commande_id}</td>
                      <td>${reglement.nom_client}</td>
                      <td>${reglement.mode_reglement}</td>
                      <td>${reglement.avance}</td>
                      <td>${reglement.reste}</td>
                      <td>${reglement.date}</td>
                      <td class="text-center">${btnAvoir}</td>
                      <td class="text-center">${btnPrint}</td>
                    </tr>`;
            }) ;
            // ------ end reglements ------
              lignes+=`<tr>
                      <td>${ligne.id}-${index}</td>
                      <td>${ligne.date}</td>
                      <td>${ligne.nom_client}</td>
                      <td>${ligne.total}</td>
                      <td>${ligne.avance}</td>
                      <td>${ligne.reste}</td>
                      <td>
                        <i class="fas fa-eye"
                          id="btnDetails${index}"
                          data-index="${index}" 
                          data-status="false" 
                          onclick="handleEvent(event)"
                        ></i>
                      </td>
                    </tr>
                    <tr id="viewDetails${index}" style="display: none;border:1px solid black">
                          <td colspan="7" class="border border-dark shadow p-3 mb-5 bg-white rounded">
                            <table class="table">
                              <thead  class="thead-light">
                                <tr>
                                  <th>id</th>
                                  <th>Commande_id</th>
                                  <th>Nom_client</th>
                                  <th>Mode_reglement</th>
                                  <th>Montant payer</th>
                                  <th>Reste</th>
                                  <th>Date</th>
                                  <th>Status</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                              <tbody>${details}</tbody>
                            </table>
                          </td>  
                    </tr>`;
          });
          table.find('tbody').html('');
          table.find('tbody').append(lignes);
      },
      error:function(){
        console.log([]);    
      }
    });
  }
  function handleEvent(e){
    var item = e.target.getAttribute('id');
    var index = e.target.getAttribute('data-index');
    var status = e.target.getAttribute('data-status');
    if(status == 'true'){
      e.target.setAttribute('data-status','false');
      $('#'+item).parent().parent().parent().find('#viewDetails'+index).prop('style','display: none;');
      $('#'+item).prop('class','fas fa-eye');
    }
    else{
      e.target.setAttribute('data-status','true');
      $('#'+item).parent().parent().parent().find('#viewDetails'+index).prop('style','display: contents;');
      $('#'+item).prop('class','fas fa-eye-slash');
    }
  }
  function avoir(obj){
    $.ajax({
        type:'post',
        url:'{!!URL::to('avoir')!!}',
        data:{
          _token : $('input[name=_token]').val(),
          obj : obj,
        },
        success: function(data){
          Swal.fire(data.message);
          search();
        },
        error:function(err){
          (err.status === 500) ? Swal.fire(err.statusText):Swal.fire("Erreur !!!") ;
        },
      });
  }
</script>
<!-- ##################################################################### -->
@endsection

