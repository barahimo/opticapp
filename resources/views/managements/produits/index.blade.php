@extends('layout.dashboard')
@section('contenu')
<?php
    use function App\Providers\hasPermssion;
?>
{{-- ################## --}}
<!-- Content Header (Page header) -->
<div class="content-header sty-one">
    <h1>Panneau des produits</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('app.home')}}">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Produits</li>
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
                    @if(hasPermssion('create3') == 'yes') 
                    <a href="{{route('produit.create')}}" class="btn btn-primary m-b-10 "><i class="fa fa-plus"></i> Produit</a>
                    @endif
                </div>
                <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8">
                    <form action="" method="get" class="search-form">
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
            <div class="table-responsive">
                <table class="table" id="table">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Produit</th>
                            <th>TVA</th>
                            <th>prix HT</th>
                            <th>prix TTC</th>
                            <th>Cat??gorie</th>                            
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produits as $key=>$produit)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$produit->code_produit}}</td>
                                <td>{{$produit->nom_produit}}</td>
                                <td>{{$produit->TVA}}%</td>
                                <td>{{number_format($produit->prix_produit_HT,2)}}</td>
                                <td>{{number_format($produit->prix_produit_TTC,2)}}</td>
                                <td>{{$produit->categorie->nom_categorie}}</td>
                                <td>
                                    @if(hasPermssion('show3') == 'yes') 
                                    <a href="{{ action('ProduitController@show',['produit'=> $produit])}}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-info"></i></a>
                                    @endif
                                    @if(hasPermssion('edit3') == 'yes') 
                                    <a href="{{route('produit.edit',['produit'=> $produit])}}"class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i></a>
                                    @endif
                                    @if(hasPermssion('delete3') == 'yes') 
                                    <button class="btn btn-outline-danger btn-sm remove-produit" 
                                    data-id="{{ $produit->id }}" 
                                    data-action="{{ route('produit.destroy',$produit->id) }}"> 
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
</div>
<!-- /.content --> 
{{-- ################## --}}
<script type="text/javascript">
    $(document).ready(function(){
        searchProduit();
        $(document).on('keyup','input[name=q]',function(e){
            e.preventDefault();
            searchProduit();
        });
        $(document).on('click','button[type=submit]',function(e){
            e.preventDefault();
            searchProduit();
        });
    });
    function searchProduit() {
        $.ajax({
            type:'get',
            url:'{!!Route('produit.searchProduit')!!}',
            data:{'search':$('input[name=q]').val()},
            success:function(res){
                var lignes = '';
                var table = $('#table');
                table.find('tbody').html("");
                res.forEach((produit,i) => {
                    var url_show = "{{ action('ProduitController@show',['produit'=> ":id"])}}".replace(':id', produit.id);
                    var url_edit = "{{route('produit.edit',['produit'=> ":id"])}}".replace(':id', produit.id);
                    var url_destroy = "{{ route('produit.destroy',":id") }}".replace(':id', produit.id);
                    var action = `
                        @if(hasPermssion('show3') == 'yes') 
                        <a href=${url_show} class="btn btn-outline-secondary btn-sm"><i class="fas fa-info"></i></a>
                        @endif
                        @if(hasPermssion('edit3') == 'yes') 
                        <a href=${url_edit} class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i></a>
                        @endif
                        @if(hasPermssion('delete3') == 'yes') 
                        <button class="btn btn-outline-danger btn-sm remove-produit" 
                        data-id="${produit.id}"
                        data-action=${url_destroy} > 
                        <i class="fas fa-trash"></i>
                        </button>
                        @endif
                    `;
                    lignes += `<tr>
                        <td>${i+1}</td>
                        <td>${produit.code_produit}</td>
                        <td>${produit.nom_produit}</td>
                        <td>${produit.TVA}%</td>
                        <td>${parseFloat(produit.prix_produit_HT).toFixed(2)}</td>
                        <td>${parseFloat(produit.prix_produit_TTC).toFixed(2)}</td>
                        <td>${produit.categorie.nom_categorie}</td>
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
    $("body").on("click",".remove-produit",function(){
        var current_object = $(this);
        Swal.fire({
            title: "Un produit est sur le point d'??tre d??truite",
            text: "Est-ce que vous ??tes d'accord ?",
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
                //    Swal.fire(
                //    'Deleted!',
                //    'Your file has been deleted.',
                //    'success'
                //    )
                }
            })
            // end swal2
    });
</script>
{{-- ################## --}}
@endsection



