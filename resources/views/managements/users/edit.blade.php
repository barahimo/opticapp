@extends('layout.dashboard')
@section('contenu')
{{-- ################## --}}
<!-- Content Header (Page header) -->
<div class="content-header sty-one">
    <h1>Modification d'utlisateur</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('app.home')}}">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Utlisateur</li>
    </ol>
</div>
{{-- ################## --}}
<!-- Main content -->
<div class="content">
    {{-- ---------------- --}}
    <div class="row m-t-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-blue">
                    <h5 class="text-white m-b-0">Formulaire d'utilisateur</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('user.update',['user'=> $user->id])}}" method="POST">
                        @csrf 
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                <label class="control-label" for="name">Nom d'utilisateur</label>
                                <input class="form-control" placeholder="Nom d'utilisateur" type="text" name="name" id="name"  value="{{ old('name', $user->name ?? null) }}">
                                <span class="fa fa-user form-control-feedback" aria-hidden="true"></span> </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                <label class="control-label" for="email">E-Mail</label>
                                <input class="form-control" placeholder="E-Mail" type="email" id="email1" value="{{ old('email', $user->email ?? null) }}" disabled>
                                <input class="form-control" placeholder="E-Mail" type="hidden" name="email" id="email2" value="{{ old('email', $user->email ?? null) }}">
                                <span class="badge badge-danger" id="erreur"></span>
                                <span class="fa fa-envelope-o form-control-feedback" aria-hidden="true"></span> </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-danger btn-sm text-white" name="changePasse">Changer le mot de passe</button>
                            </div>
                            <div class="col-md-12">
                                &nbsp;&nbsp;
                            </div>
                            <div class="col-12" id="pass" style="display : none">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label" for="password">Nouveau mot de passe</label>
                                            <input class="form-control" placeholder="Mot de passe" type="password" name="password" id="password">
                                            <span class="fa fa-lock form-control-feedback" aria-hidden="true"></span> 
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label" for="password_confirmation">Confirmer le mot de passe</label>
                                            <input class="form-control" placeholder="Confirmer le mot de passe" type="password" name="password_confirmation" id="password_confirmation">
                                            <span class="fa fa-lock form-control-feedback" aria-hidden="true"></span> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="is_admin">Type d'utilisateur</label>
                                    <select class="form-control" id="is_admin" name="is_admin">
                                        <option value="">-- Type d'utilisateur --</option>
                                        <option value="0"  @if ($user->is_admin == old('is_admin',0 ?? null)) selected="selected" @endif> User</option>
                                        <option value="1"  @if ($user->is_admin == old('is_admin',1 ?? null)) selected="selected" @endif> Admin</option>
                                    </select>
                                </div>
                            </div> --}}
                            <input type="hidden" name="visibility" id="visibility" value="{{$visibility}}">
                            @if($visibility)
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="status">Status d'utilisateur</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">-- Status d'utilisateur --</option>
                                        <option value="1"  @if ($user->status == old('status',1 ?? null)) selected="selected" @endif> Active</option>
                                        <option value="0"  @if ($user->status == old('status',0 ?? null)) selected="selected" @endif> InActive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="permission">Permissions</label>
                                    <input type="checkbox" name="permission1" id="permission1" value="create" @if (in_array('create',$permission)) checked="checked" @endif>create
                                    <input type="checkbox" name="permission2" id="permission2" value="edit"  @if (in_array('edit',$permission)) checked="checked" @endif>edit
                                    <input type="checkbox" name="permission3" id="permission3" value="delete"  @if (in_array('delete',$permission)) checked="checked" @endif>delete
                                    <input type="checkbox" name="permission4" id="permission4" value="show"  @if (in_array('show',$permission)) checked="checked" @endif>show
                                </div>
                            </div>
                            @endif
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-warning text-white" name="updateUser">Modifier</button>
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
    $(document).on('click','button[name=changePasse]',function(e){
        e.preventDefault();
        pass = $('#pass');
        isDisplay = pass.prop('style').display;
        if(isDisplay == 'none'){
            pass.prop('style','display : content');
            var btn = $('button[name=updateUser]');
            btn.prop('disabled',true);
            var password = $('#password');
            var password_confirmation = $('#password_confirmation');
            password.val('');
            password_confirmation.val('');
        }
        else{
            pass.prop('style','display : none');
        }
        myFunction();
    })
    $(document).on('keyup','#name',function(){
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
        var password = $('#password').val();
        var password_confirmation = $('#password_confirmation').val();
        // var is_admin = $('#is_admin').val();
        var status = $('#status').val();
        var btn = $('button[name=updateUser]');
        var visibility = "{{$visibility}}";
        pass = $('#pass');
        isDisplay = pass.prop('style').display;
        if(visibility){
            if(isDisplay == 'none'){
                if(
                    (!name && name=='') || 
                    (!status && status=='')
                    // (!is_admin && is_admin=='')
                ) {
                    btn.prop('disabled',true);
                }
                else{
                    btn.prop('disabled',false);
                }
            }
            else{
                if(
                    (!name && name=='') || 
                    (!password && password=='') || 
                    (password_confirmation!==password) || 
                    (!status && status=='')
                    // (!is_admin && is_admin=='')
                ) {
                    btn.prop('disabled',true);
                }
                else{
                    btn.prop('disabled',false);
                }
            }
        }   
        else{
            if(isDisplay == 'none'){
                if(
                    (!name && name=='')
                ) {
                    btn.prop('disabled',true);
                }
                else{
                    btn.prop('disabled',false);
                }
            }
            else{
                if(
                    (!name && name=='') || 
                    (!password && password=='') || 
                    (password_confirmation!==password) 
                ) {
                    btn.prop('disabled',true);
                }
                else{
                    btn.prop('disabled',false);
                }
            }
        }
    }
</script>
{{-- ################## --}}
@endsection
