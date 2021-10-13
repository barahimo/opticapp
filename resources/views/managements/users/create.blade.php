@extends('layout.dashboard')
@section('contenu')
{{-- ################## --}}
<!-- Content Header (Page header) -->
<div class="content-header sty-one">
    <h1>Ajout d'un utlisateur</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('app.home')}}">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Utlisateur</li>
    </ol>
</div>
{{-- ################## --}}
<!-- Main content -->
<div class="content">
    <div class="row m-t-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-blue">
                    <h5 class="text-white m-b-0">Formulaire d'utilisateur</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('user.store')}}" method="POST">
                        @csrf 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                <label class="control-label" for="name">Nom d'utilisateur</label>
                                <input class="form-control" placeholder="Nom d'utilisateur" type="text" name="name" id="name">
                                <span class="fa fa-user form-control-feedback" aria-hidden="true"></span> </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                <label class="control-label" for="email">E-Mail</label>
                                <input class="form-control" placeholder="E-Mail" type="email" name="email" id="email">
                                <span class="badge badge-danger" id="erreur"></span>
                                <span class="fa fa-envelope-o form-control-feedback" aria-hidden="true"></span> </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                <label class="control-label" for="password">Mot de passe</label>
                                <input class="form-control" placeholder="Mot de passe" type="password" name="password" id="password">
                                <span class="fa fa-lock form-control-feedback" aria-hidden="true"></span> </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                <label class="control-label" for="password_confirmation">Confirmer le mot de passe</label>
                                <input class="form-control" placeholder="Confirmer le mot de passe" type="password" name="password_confirmation" id="password_confirmation">
                                <span class="fa fa-lock form-control-feedback" aria-hidden="true"></span> </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="is_admin">Type d'utilisateur</label>
                                    <select class="form-control" id="is_admin" name="is_admin">
                                        <option value="">-- Type d'utilisateur --</option>
                                        <option value="0"> User</option>
                                        <option value="1"> Admin</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="status">Status d'utilisateur</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">-- Status d'utilisateur --</option>
                                        <option value="1"> Active</option>
                                        <option value="0"> InActive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label" for="permission"><strong>Permissions</strong></label>
                                {{-- Begin - Client --}}
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="permission1" id="permission1" onclick="check1()"><u>Client</u>&nbsp;:&nbsp;</label>
                                    <div class="checkbox">
                                        <label><input name="permission10" id="permission10" value="list1" type="checkbox">&nbsp;List</label>
                                        <label><input name="permission11" id="permission11" value="show1" type="checkbox">&nbsp;Affichage</label>
                                        <label><input name="permission12" id="permission12" value="create1" type="checkbox">&nbsp;Création</label>
                                        <label><input name="permission13" id="permission13" value="edit1" type="checkbox">&nbsp;Modification</label>
                                        <label><input name="permission14" id="permission14" value="delete1" type="checkbox">&nbsp;Suppression</label>
                                    </div>
                                </div>
                                {{-- Begin - Catégorie --}}
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="permission2" id="permission2" onclick="check2()"><u>Catégorie</u>&nbsp;:&nbsp;</label>
                                    <div class="checkbox">
                                        <label><input name="permission20" id="permission20" value="list2" type="checkbox">&nbsp;List</label>
                                        <label><input name="permission21" id="permission21" value="show2" type="checkbox">&nbsp;Affichage</label>
                                        <label><input name="permission22" id="permission22" value="create2" type="checkbox">&nbsp;Création</label>
                                        <label><input name="permission23" id="permission23" value="edit2" type="checkbox">&nbsp;Modification</label>
                                        <label><input name="permission24" id="permission24" value="delete2" type="checkbox">&nbsp;Suppression</label>
                                    </div>
                                </div>
                                {{-- Begin - Produit --}}
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="permission3" id="permission3" onclick="check3()"><u>Produit</u>&nbsp;:&nbsp;</label>
                                    <div class="checkbox">
                                        <label><input name="permission30" id="permission30" value="list3" type="checkbox">&nbsp;List</label>
                                        <label><input name="permission31" id="permission31" value="show3" type="checkbox">&nbsp;Affichage</label>
                                        <label><input name="permission32" id="permission32" value="create3" type="checkbox">&nbsp;Création</label>
                                        <label><input name="permission33" id="permission33" value="edit3" type="checkbox">&nbsp;Modification</label>
                                        <label><input name="permission34" id="permission34" value="delete3" type="checkbox">&nbsp;Suppression</label>
                                    </div>
                                </div>
                                {{-- Begin - Commande --}}
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="permission4" id="permission4" onclick="check4()"><u>Commande</u>&nbsp;:&nbsp;</label>
                                    <div class="checkbox">
                                        <label><input name="permission40" id="permission40" value="list4" type="checkbox">&nbsp;List</label>
                                        <label><input name="permission41" id="permission41" value="show4" type="checkbox">&nbsp;Affichage</label>
                                        <label><input name="permission42" id="permission42" value="create4" type="checkbox">&nbsp;Création</label>
                                        <label><input name="permission43" id="permission43" value="edit4" type="checkbox">&nbsp;Modification</label>
                                        <label><input name="permission44" id="permission44" value="delete4" type="checkbox">&nbsp;Suppression</label>
                                        <label><input name="permission45" id="permission45" value="print4" type="checkbox">&nbsp;Impression</label>
                                        <label><input name="permission46" id="permission46" value="details4" type="checkbox">&nbsp;Détails</label>
                                    </div>
                                </div>
                                {{-- Begin - Règlement --}}
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="permission5" id="permission5" onclick="check5()"><u>Règlement</u>&nbsp;:&nbsp;</label>
                                    <div class="checkbox">
                                        <label><input name="permission50" id="permission50" value="list5" type="checkbox">&nbsp;List</label>
                                        <label><input name="permission51" id="permission51" value="show5" type="checkbox">&nbsp;Affichage</label>
                                        <label><input name="permission52" id="permission52" value="create5" type="checkbox">&nbsp;Création</label>
                                        <label><input name="permission53" id="permission53" value="edit5" type="checkbox">&nbsp;Modification</label>
                                        <label><input name="permission54" id="permission54" value="delete5" type="checkbox">&nbsp;Suppression</label>
                                        <label><input name="permission55" id="permission55" value="print5" type="checkbox">&nbsp;Impression</label>
                                        <label><input name="permission56" id="permission56" value="details5" type="checkbox">&nbsp;Détails</label>
                                    </div>
                                </div>
                                {{-- Begin - Facture --}}
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="permission6" id="permission6" onclick="check6()"><u>Facture</u>&nbsp;:&nbsp;</label>
                                    <div class="checkbox">
                                        <label><input name="permission60" id="permission60" value="list6" type="checkbox">&nbsp;List</label>
                                        <label><input name="permission61" id="permission61" value="show6" type="checkbox">&nbsp;Affichage</label>
                                        <label><input name="permission62" id="permission62" value="create6" type="checkbox">&nbsp;Création</label>
                                        <label><input name="permission63" id="permission63" value="edit6" type="checkbox">&nbsp;Modification</label>
                                        <label><input name="permission64" id="permission64" value="delete6" type="checkbox">&nbsp;Suppression</label>
                                        <label><input name="permission65" id="permission65" value="print6" type="checkbox">&nbsp;Impression</label>
                                    </div>
                                </div>
                                {{-- Begin - Mouvement --}}
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="permission7" id="permission7" onclick="check7()"><u>Mouvement</u>&nbsp;:&nbsp;</label>
                                    <div class="checkbox">
                                        <label><input name="permission70" id="permission70" value="list7" type="checkbox">&nbsp;List</label>
                                        <label><input name="permission71" id="permission71" value="show7" type="checkbox">&nbsp;Affichage</label>
                                        <label><input name="permission75" id="permission75" value="print7" type="checkbox">&nbsp;Impression</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success" name="sendUser" disabled>Valider</button>
                                {{-- <button type="submit" class="btn btn-success" name="sendUser">Valider</button> --}}
                                &nbsp;
                                <a href="{{action('UserController@index')}}" class="btn btn-info">Retour</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- ---------------- --}}
</div>
<!-- /.content --> 
{{-- ################## --}}
<script type="text/javascript">
    function check1(){
        $('#permission10').prop('checked',true);
        $('#permission11').prop('checked',true);
        $('#permission12').prop('checked',true);
        $('#permission13').prop('checked',true);
        $('#permission14').prop('checked',true);
    }
    function check2(){
        $('#permission20').prop('checked',true);
        $('#permission21').prop('checked',true);
        $('#permission22').prop('checked',true);
        $('#permission23').prop('checked',true);
        $('#permission24').prop('checked',true);
    }
    function check3(){
        $('#permission30').prop('checked',true);
        $('#permission31').prop('checked',true);
        $('#permission32').prop('checked',true);
        $('#permission33').prop('checked',true);
        $('#permission34').prop('checked',true);
    }
    function check4(){
        $('#permission40').prop('checked',true);
        $('#permission41').prop('checked',true);
        $('#permission42').prop('checked',true);
        $('#permission43').prop('checked',true);
        $('#permission44').prop('checked',true);
        $('#permission45').prop('checked',true);
        $('#permission46').prop('checked',true);
    }
    function check5(){
        $('#permission50').prop('checked',true);
        $('#permission51').prop('checked',true);
        $('#permission52').prop('checked',true);
        $('#permission53').prop('checked',true);
        $('#permission54').prop('checked',true);
        $('#permission55').prop('checked',true);
        $('#permission56').prop('checked',true);
    }
    function check6(){
        $('#permission60').prop('checked',true);
        $('#permission61').prop('checked',true);
        $('#permission62').prop('checked',true);
        $('#permission63').prop('checked',true);
        $('#permission64').prop('checked',true);
        $('#permission65').prop('checked',true);
    }
    function check7(){
        $('#permission70').prop('checked',true);
        $('#permission71').prop('checked',true);
        $('#permission75').prop('checked',true);
    }
    $(document).on('keyup','#name',function(){
        myFunction();
    })
    $(document).on('keyup','#email',function(){
        myFunction();
    })
    $(document).on('keyup','#password',function(){
        myFunction();
    })
    $(document).on('keyup','#password_confirmation',function(){
        myFunction();
    })
    // $(document).on('click','#is_admin',function(){
    //     myFunction();
    // })
    $(document).on('click','#status',function(){
        myFunction();
    })
    function myFunction() {
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var password_confirmation = $('#password_confirmation').val();
        // var is_admin = $('#is_admin').val();
        var status = $('#status').val();
        var erreur = $("#erreur").html();
        var btn = $('button[name=sendUser]');
        $.ajax({
            type:'get',
            url:'{!!Route('user.findEmail')!!}',
            data:{
                email : email,
            },
            success: function(data){
                (data) ? $("#erreur").html('E-mail existe déja !') : $("#erreur").html('');
                if(
                    (!name && name=='') || 
                    (!email) || 
                    (data) || 
                    (password_confirmation!=password) || 
                    (!status && status=='')
                    // (!is_admin && is_admin=='')
                ) {
                    btn.prop('disabled',true);
                }
                else{
                    btn.prop('disabled',false);
                }
            },
            error:function(err){
                (err.status === 500) ? Swal.fire(err.statusText):Swal.fire("Erreur !!!") ;
            },
        });
    }
</script>
{{-- ################## --}}
@endsection
