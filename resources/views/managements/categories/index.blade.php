@extends('layout.dashboard')
@section('contenu')
{{-- ################## --}}
<!-- Content Header (Page header) -->
<div class="content-header sty-one">
    <h1>Panneau des catégories</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('app.home')}}">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Catégories</li>
    </ol>
</div>
{{-- ################## --}}
<!-- Main content -->
<div class="content">
    <!-- Main card -->
    <div class="card">
        <div class="card-body">
            {{-- ---------------- --}}
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-2 col-sm-2">
                    <a href="{{route('categorie.create')}}" class="btn btn-primary m-b-10 "><i class="fa fa-plus"></i> Catégorie</a>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8">
                    <form action="{{route('categorie.search')}}" method="get" class="search-form">
                        <div class="input-group">
                            <input name="q" class="form-control" placeholder="search..." type="text">
                            <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-info btn-flat"><i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-2 col-sm-2"></div>
            </div>
            <!-- search form --> 
            <br>
            {{-- ---------------- --}}
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Libelle</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $key=>$categorie)
                        <tr>
                            <td>{{$key+1 }}</td>
                            <td>{{$categorie->nom_categorie}}</td>
                            <td>
                                @if($categorie->description)
                                {{substr($categorie->description,0,25)}}...
                                @endif
                            </td>
                            <td>
                                <a href="{{ action('CategorieController@show',['categorie'=> $categorie])}}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-info"></i></a>
                                @if( Auth::user()->is_admin )
                                <a href="{{route('categorie.edit',['categorie'=> $categorie])}}"class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i></a>
                                <button class="btn btn-outline-danger btn-sm remove-categorie" 
                                data-id="{{ $categorie->id }}" 
                                data-action="{{ route('categorie.destroy',$categorie->id) }}"> 
                                <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.content --> 
{{-- ################## --}}
<script type="text/javascript">
    // $('#action').html(`ok`);
    $(document).ready(function(){
        searchCategorie();
        $(document).on('keyup','input[name=q]',function(e){
            e.preventDefault();
            searchCategorie();
        });
        $(document).on('click','button[type=submit]',function(e){
            e.preventDefault();
            searchCategorie();
        });
    });
    function searchCategorie() {
        $.ajax({
            type:'get',
            url:'{!!Route('categorie.searchCategorie')!!}',
            data:{'search':$('input[name=q]').val()},
            success:function(res){
                var lignes = '';
                var table = $('#table');
                table.find('tbody').html("");
                res.forEach((categorie,i) => {
                    var url_edit = "{{route('categorie.edit',['categorie'=> ":id"])}}".replace(':id', categorie.id);
                    var url_destroy = "{{ route('categorie.destroy',":id") }}".replace(':id', categorie.id);
                    var url_show = "{{action('CategorieController@show',['categorie'=> ":id"])}}".replace(':id', categorie.id);
                    var action = `<a href=${url_show} class="btn btn-outline-secondary btn-sm"><i class="fas fa-info"></i></a>
                            @if(Auth::user()->is_admin)
                            <a href=${url_edit} class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-outline-danger btn-sm remove-categorie" 
                                data-id="${categorie.id}" 
                                data-action=${url_destroy}> 
                                <i class="fas fa-trash"></i>
                            </button>
                            @endif `;
                    var description = '';
                    if(categorie.description != null)
                        description = categorie.description.substring(0,25)+'...';
                    lignes += `<tr>
                        <td>${i+1}</td>
                        <td>${categorie.nom_categorie}</td>
                        <td>${description}</td>
                        <td>${action}</td>
                    </tr>`;
                });
                table.find('tbody').append(lignes);
            },
            error:function(){
                console.log([]);    
            }
        });
    }
    $("body").on("click",".remove-categorie",function(){
        var current_object = $(this);
        Swal.fire({
            title: "Une catégorie est sur le point d'être détruite ",
            text: "Est-ce que vous êtes d'accord ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Annuler',
            confirmButtonText: 'Oui, supprimez-le!'
        }).then((result) => {
            if (result.isConfirmed) {
                // begin destroy
                    var action = current_object.attr('data-action');
                    var token = jQuery('meta[name="csrf-token"]').attr('content');
                    var id = current_object.attr('data-id');
                    $('body').html("<form class='form-inline remove-form' method='post' action='"+action+"'></form>");
                    $('body').find('.remove-form').append('<input name="_method" type="hidden" value="delete">');
                    $('body').find('.remove-form').append('<input name="_token" type="hidden" value="'+token+'">');
                    $('body').find('.remove-form').append('<input name="id" type="hidden" value="'+id+'">');
                    $('body').find('.remove-form').submit();
                //end destroy
                // Swal.fire(
                // 'Deleted!',
                // 'Your file has been deleted.',
                // 'success'
                // )
            }
        })
    });
</script>
{{-- ################## --}}
@endsection


