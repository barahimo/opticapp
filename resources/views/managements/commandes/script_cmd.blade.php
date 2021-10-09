<script type="text/javascript">
  $(document).ready(function(){
    // searchSelect(null,'all','all',null);
    search();
    // -----------Change Select_Facturée--------------//
    $(document).on('change','#f',function(){
      $('#search').val('');
      search();
    });
    // -----------End Select_Facturée--------------//
    // -----------Change Select_NonFacturée--------------//
    $(document).on('change','#nf',function(){
      $('#search').val('');
      search();
    });
    // -----------End Select_NonFacturée--------------//
    // -----------Change Select_Reglée--------------//
    $(document).on('change','#r',function(){
      $('#search').val('');
      search();
    });
    // -----------End Select_Reglée--------------//
    // -----------Change Select_NonReglée--------------//
    $(document).on('change','#nr',function(){
      $('#search').val('');
      search();
    });
    // -----------End Select_NonReglée--------------//
    // -----------Change Select_Client--------------//
    $(document).on('change','#client',function(){
      // var client=$(this).val();
      // searchSelect(client,null);
      $('#search').val('');
      search();
    });
    // -----------End Select_Client--------------//
    // -----------KeyUp searchCommandes--------------//
    $(document).on('keyup','#search',function(){
      search();
    });
    // -----------KeyUp searchCommandes--------------//
  });
  // -----------My function--------------//
  // function searchSelect(param1,param2,param3){
  function searchSelect(param1,param2,param3,param4){
    var table=$('#table');
    $.ajax({
      type:'get',
      url:'{!!Route('commande.getCommandes5')!!}',
      data:{'client':param1,'facture':param2,'status':param3,'search':param4},
      success:function(data){
        // console.log(data);
        // return;
        var lignes = '';
        // console.log(lignes);
        // ------------------ //
        table.find('tbody').html("");
        var details = ''; 
        // ------------------ //
        var commandes = data;
        commandes.forEach((commande,index) => {
          // ************************ //
          var url_edit = "{{route('commande.edit',['commande'=>":id"])}}".replace(':id', commande.id);
          var url_delete1 = "{{route('commande.destroy',['commande'=>":commande"])}}".replace(':commande', commande.id);
          var url_show1 = "{{route('commande.show',['commande'=>":id"])}}".replace(':id', commande.id);
          var url_reg = "{{route('reglement.create3',['commande'=>"commande_id"])}}".replace('commande_id', commande.id);
          var url_fac = "{{route('commande.facture',['commande'=>"commande_id"])}}".replace('commande_id', commande.id);
          var facture = "NF";
          if(commande.facture == "f")
            facture = "F";
          var status = "R";
          if(commande.reste > 0)
            status = "NR";
          // ************************ //
          details = ''; 
            // ------ begin reglements ------
            commande.reglements.forEach((reglement,i) => {
              var style = "";
              var btnAvoir = reglement.status;
              (reglement.reste > 0) ? style = "color : red" : style = "color : green";
              if(reglement.status == 'AV'){
                btnAvoir = `<button  
                    onclick="avoir({
                      reg_id: ${reglement.id}, 
                      reg_avance: ${parseFloat(reglement.avance).toFixed(2)}, 
                      reg_reste: ${parseFloat(reglement.reste).toFixed(2)},
                      cmd_id: ${commande.id}, 
                      cmd_avance: ${parseFloat(commande.avance).toFixed(2)}, 
                      cmd_reste: ${parseFloat(commande.reste).toFixed(2)}
                    })"
                    class="btn btn-outline-success btn-sm">Avoir</button>`;
              }
              var url_show2 = "{{route('reglement.show',['reglement'=>":id"])}}".replace(':id', reglement.id);
              var url_delete2 = "{{route('reglement.delete',['reglement'=>":reglement"])}}".replace(':reglement', reglement.id);
              var btnPrint = `<a class="btn btn-outline-info  btn-sm" href=${url_show2}><i class="fas fa-print"></i></a>`;
              // var btnDelete2 = `<a class="btn btn-outline-danger  btn-sm" href=${url_delete2}><i class="fas fa-trash"></i></a>`;
              var btnDelete2 = `<button 
                  class="btn btn-outline-danger btn-sm" 
                  id="btnDelete2${index+1}${i+1}" 
                  data-id="${reglement.id}" 
                  data-route="${url_delete2}" 
                  onclick="javascript:deleteReglement(${index+1}${i+1})">
                    <i class="fas fa-trash-alt fa-0.5px"></i>
                </button>`;
              if(reglement.avance != 0) 
                details+=`<tr  style="${style}">
                      <td>${reglement.code}</td>
                      <td style="display : none">${reglement.id}</td>
                      <td style="display : none">${reglement.commande_id}</td>
                      <td style="display : none">${commande.client.nom_client}</td>
                      <td>${reglement.date}</td>
                      <td>${parseFloat(reglement.avance).toFixed(2)}</td>
                      <td id="reste${i}">${parseFloat(reglement.reste).toFixed(2)}</td>
                      <td>${reglement.mode_reglement}</td>
                      <td class="text-center">${btnAvoir}</td>
                      <td class="text-center">
                        ${btnPrint}
                        ${btnDelete2}
                      </td>
                    </tr>`;
            }) ;
            // ------ end reglements ------
          // ************************ //
          // <button id="btnDelete1${index}" class="btn btn-outline-danger btn-sm" onclick="window.location.assign('${url_delete1}')"><i class="fas fa-trash-alt fa-0.5px"></i></button>
          actions = `
            <div class="row">
              <div class="col-8">
                <span>[${commande.code}]</span>
                <button id="btnFacture${index}" class="btn btn-link" onclick="window.location.assign('${url_fac}')"><i class="fa fa-plus-square"></i>&nbsp;Facture&nbsp;<i class="fas fa-receipt"></i></button>
                <button id="btnStatus${index}" class="btn btn-link" onclick="window.location.assign('${url_reg}')"><i class="fa fa-plus-square"></i>&nbsp;Règlement&nbsp;<i class="fas fa-hand-holding-usd"></i></button>
                <a class="btn btn-outline-info btn-sm" href=${url_show1}><i class="fas fa-print"></i></a>
                <a class="btn btn-outline-success btn-sm" id="btnEdit${index+1}" href=${url_edit}><i class="fas fa-edit"></i></a>
                <a 
                  class="btn btn-outline-danger btn-sm" 
                  id="btnDelete1${index+1}" 
                  data-id="${commande.id}" 
                  data-route="${url_delete1}" 
                  href="javascript:deleteCommande(${index+1})">
                    <i class="fas fa-trash-alt fa-0.5px"></i>
                </a>
              </div>
              <div class="col-4 text-right">
                  <button class="btn btn-outline-success btn-sm"
                    id="btnDetails${index}"
                    data-index="${index}" 
                    data-status="false" 
                    onclick="handleEvent(${index})">
                    <i class="fas fa-angle-down"></i><span>&nbsp;Liste des règlements</span>
                  </button>
              </div>
            </div>
          `;
          lignes += `
            <tr>
              <td>${commande.code}</td>
              <td>${commande.date}</td>
              <td>${commande.client.nom_client}</td>
              <td>${parseFloat(commande.total).toFixed(2)}</td>
              <td>${parseFloat(commande.avance).toFixed(2)}</td>
              <td>${parseFloat(commande.reste).toFixed(2)}</td>
              <td id="viewStatus${index}" style="display : none">${status}</td>
              <td id="viewFacture${index}" style="display : none">${facture}</td>
              <td>
                <i class="fas fa-eye fa-1x"
                  id="btnActions${index}"
                  data-index="${index}" 
                  data-status="false" 
                  onclick="handleActions(event)"
                ></i>
              </td>
            </tr>
            <tr id="viewActions${index}" style="display : none;">
              <td colspan="7" class="border border-dark shadow p-3 mb-5 bg-light rounded">
                  ${actions}
                  <hr>
                  <div id="viewDetails${index}" style="display : none;">
                    <table class="table">
                      <thead class="thead-light">
                        <tr>
                          <th>#</th>
                          <th style="display : none">id</th>
                          <th style="display : none">Commande_id</th>
                          <th style="display : none">Nom client</th>
                          <th>Date</th>
                          <th>Montant payer</th>
                          <th>Reste</th>
                          <th>Mode règlement</th>
                          <th>Status</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>${details}</tbody>
                    </table>
                  </div>
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
    var search = null;
    // -----------------------------------
    if($('#search').val() != ""){
      search = $('#search').val();
    }
    // -----------------------------------
    if($('#client').val() != ""){
      client = $('#client').val(); 
      clientHTML = $('#client').html(); 
      var create  = $('#create');
      var text = $("#client option:selected" ).text();
      var msg = `<i class="fa fa-plus"></i>&nbsp;Règlements [ ${text} ]` ;
      create.html(msg);
      var url = "{{route('reglement.create2',['client'=>"val"])}}";
      url = url.replace('val', client);
      create.attr('href',url);
    }
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
    // searchSelect(client,facture,status);
    searchSelect(client,facture,status,search);
  }

  function actionButton(){
    table = $('#table');
    list = table.find('tbody').find('tr');
    for (let index = 0; index < list.length; index++) {
      // var item = list.eq(index).find('td');
      // var status = item.eq(6);
      // var facture = item.eq(7);
      var status = $('#viewStatus'+index);
      var facture = $('#viewFacture'+index);
      // var action = item.eq(8).find('button');
      // var btnFacture = action.eq(0);
      // var btnStatus = action.eq(1);
      var btnFacture = $('#btnFacture'+index);
      var btnStatus = $('#btnStatus'+index);
      var btnEdit = $('#btnEdit'+(index+1));
      var btnDelete1 = $('#btnDelete1'+(index+1));
      if(facture.html() == 'F'){
        btnFacture.attr('disabled',true);
        btnEdit.attr('style',"color : grey;cursor: default !important;pointer-events: none;");
        btnEdit.attr('onclick',"return false;");

        btnDelete1.attr('style',"color : grey;cursor: default !important;pointer-events: none;");
        btnDelete1.attr('onclick',"return false;");
      }
      else{
        btnFacture.attr('disabled',false);
        btnEdit.attr('style',"");
        btnEdit.attr('onclick',"");

        btnDelete1.attr('style',"");
        btnDelete1.attr('onclick',"");
      }
      (status.html() == 'R') ? btnStatus.attr('disabled',true): btnStatus.attr('disabled',false);
    }
  }
  // ------------------------------------ //
  function handleEvent(index){
    btnDetails = $('#btnDetails'+index);
    var item = 'btnDetails'+index;
    var status = btnDetails.data('status');
    if(status == 'true'){
      btnDetails.data('status','false');
      btnDetails.parent().parent().parent().find('#viewDetails'+index).prop('style','display: none;');
      btnDetails.find('i').prop('class','fas fa-angle-down');
      // $('#'+item).prop('class','fas fa-eye');
      // $('#'+item).prop('class','fas fa-plus');
      // $('#'+item).prop('class','fas fa-angle-down');
    }
    else{
      btnDetails.data('status','true');
      btnDetails.parent().parent().parent().find('#viewDetails'+index).prop('style','display: contents;');
      btnDetails.find('i').prop('class','fas fa-angle-up');
      // $('#'+item).prop('class','fas fa-eye-slash');
      // $('#'+item).prop('class','fas fa-minus');
      // $('#'+item).prop('class','fas fa-angle-up');
    }
  }
  function handleActions(e){
    var item = e.target.getAttribute('id');
    var index = e.target.getAttribute('data-index');
    var status = e.target.getAttribute('data-status');
    if(status == 'true'){
      e.target.setAttribute('data-status','false');
      $('#'+item).parent().parent().parent().find('#viewActions'+index).prop('style','display: none;');
      $('#'+item).prop('class','fas fa-eye');
      // $('#'+item).prop('class','fas fa-angle-up');
    }
    else{
      e.target.setAttribute('data-status','true');
      $('#'+item).parent().parent().parent().find('#viewActions'+index).prop('style','display: contents;');
      $('#'+item).prop('class','fas fa-eye-slash');
      // $('#'+item).prop('class','fas fa-angle-down');
    }
  }
  function avoir(obj){
    $.ajax({
        type:'post',
        url:'{!!Route('reglement.avoir')!!}',
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
  function deleteCommande(index){
    console.log(index);
    var btnDelete = $('#btnDelete1'+index);
    var action = btnDelete.data('route');
    Swal.fire({
      title: "Une commande est sur le point d'être détruite",
      text: "Est-ce que vous êtes d'accord ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Annuler',
      confirmButtonText: 'Oui, supprimez-le!'
    }).then((result) => {
      // begin destroy
      if (result.isConfirmed) {
        // var action = current_object.attr('data-action');
        var token = jQuery('meta[name="csrf-token"]').attr('content');
        // var id = current_object.attr('data-id');
        // $('body').find('.remove-form').append('<input name="id" type="hidden" value="'+id+'">');
        $('body').html("<form class='form-inline remove-form' method='post' action='"+action+"'></form>");
        $('body').find('.remove-form').append('<input name="_method" type="hidden" value="delete">');
        $('body').find('.remove-form').append('<input name="_token" type="hidden" value="'+token+'">');
        $('body').find('.remove-form').submit();
      }
      //end destroy
    })
    // end swal2
  }
  function deleteReglement(index){
    var btnDelete = $('#btnDelete2'+index);
    var action = btnDelete.data('route');
    var id = btnDelete.data('id');
    Swal.fire({
      title: "Un règlement est sur le point d'être détruite",
      text: "Est-ce que vous êtes d'accord ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Annuler',
      confirmButtonText: 'Oui, supprimez-le!'
    }).then((result) => {
      // begin destroy
      if (result.isConfirmed) {
        // var action = current_object.attr('data-action');
        var token = jQuery('meta[name="csrf-token"]').attr('content');
        // var id = current_object.attr('data-id');
        // $('body').find('.remove-form').append('<input name="id" type="hidden" value="'+id+'">');
        $('body').html("<form class='form-inline remove-form' method='post' action='"+action+"'></form>");
        $('body').find('.remove-form').append('<input name="_method" type="hidden" value="delete">');
        $('body').find('.remove-form').append('<input name="_token" type="hidden" value="'+token+'">');
        $('body').find('.remove-form').submit();
      }
      //end destroy
    })
    // end swal2
  }
</script>