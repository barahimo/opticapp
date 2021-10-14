@extends('layout.dashboard')
@section('contenu')
{{-- ################## --}}
<!-- Content Header (Page header) -->
<div class="content-header sty-one">
    <h1>Panneau de Factures</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('app.home')}}">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Factures</li>
    </ol>
</div>
{{-- ################## --}}
<!-- Main content -->
<div class="content">
    <!-- Main card -->
    <div class="card">
        <div class="card-body">
            {{-- ---------------- --}}
            <form action="{{route('facture.search')}}" method="get" class="search-form">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-2 col-sm-1"></div>
                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-10">
                        <div class="input-group">
                            <input name="q" class="form-control" placeholder="search..." type="text">
                            <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-info btn-flat"><i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-2 col-sm-1"></div>
                </div>
            </form>
            <!-- search form --> 
            <br>
            {{-- ---------------- --}}
            <div class="table-responsive">
                <table class="table" id="table">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>Commande</th>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Total HT</th>
                            <th>Total TVA</th>
                            <th>Total TTC</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($factures as $facture)
                            <tr>
                                <td>{{$facture->code}}</td>
                                <td>{{$facture->commande->code}}</td>
                                <td>{{$facture->date}}</td>
                                <td>{{$facture->commande->client->nom_client}}</td>
                                <td>{{number_format($facture->total_HT,2)}}</td>
                                <td>{{number_format($facture->total_TVA,2)}}</td>
                                <td>{{number_format($facture->total_TTC,2)}}</td>
                                <td>
                                    @if(in_array('show6',$permission) || Auth::user()->is_admin == 2)
                                    <a href="{{ action('FactureController@show',['facture'=> $facture])}}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-info"></i></a>
                                    @endif
                                    @if(in_array('delete6',$permission) || Auth::user()->is_admin == 2)
                                    <button class="btn btn-outline-danger btn-sm remove-facture" 
                                    data-id="{{ $facture->id }}" 
                                    data-action="{{ route('facture.destroy',$facture->id) }}"> 
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
        searchFacture();
        $(document).on('keyup','input[name=q]',function(e){
            e.preventDefault();
            searchFacture();
        });
        $(document).on('click','button[type=submit]',function(e){
            e.preventDefault();
            searchFacture();
        });
    });
    function searchFacture() {
        $.ajax({
            type:'get',
            url:'{!!Route('facture.searchFacture')!!}',
            data:{'search':$('input[name=q]').val()},
            success:function(res){
                var lignes = '';
                var table = $('#table');
                table.find('tbody').html("");
                res.forEach((facture,i) => {
                    var url_show = "{{ action('FactureController@show',['facture'=> ":id"])}}".replace(':id', facture.id);
                    var url_destroy = "{{ route('facture.destroy',":id")}}".replace(':id', facture.id);
                    var action = `@if(in_array('show6',$permission) || Auth::user()->is_admin == 2)
                        <a href=${url_show} class="btn btn-outline-secondary btn-sm"><i class="fas fa-info"></i></a>
                        @endif
                        @if(in_array('delete6',$permission) || Auth::user()->is_admin == 2)
                        <button class="btn btn-outline-danger btn-sm remove-facture" 
                        data-id="${facture.id}"
                        data-action=${url_destroy} > 
                        <i class="fas fa-trash"></i>
                        </button>
                        @endif
                    `;
                    lignes += `<tr>
                        <td>${facture.code}</td>
                        <td>${facture.commande.code}</td>
                        <td>${facture.date}</td>
                        <td>${facture.commande.client.nom_client}</td>
                        <td>${parseFloat(facture.total_HT).toFixed(2)}</td>
                        <td>${parseFloat(facture.total_TVA).toFixed(2)}</td>
                        <td>${parseFloat(facture.total_TTC).toFixed(2)}</td>
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
    $("body").on("click",".remove-facture",function(){
        var current_object = $(this);
       // begin swal2
        Swal.fire({
            title: "Une facture est sur le point d'être détruite",
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
        // end swal2
    });
</script>
@endsection