@extends('layout.dashboard')
@section('contenu')
{{-- ################## --}}
<!-- Content Header (Page header) -->
<div class="content-header sty-one">
    <h1>Panneau des utilisateurs</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('app.home')}}">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Utilisateurs</li>
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
                    <a href="{{route('user.create')}}" class="btn btn-primary m-b-10 "><i class="fa fa-user-circle"></i>  Utilisateur</a>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8">
                    
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
                            <th>Nom</th>
                            <th>Email</th>
                            {{-- <th>Type</th> --}}
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                        $i = 0 ;
                        @endphp
                        @foreach($users as $user)
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            {{-- <td>
                                @if($user->is_admin == 0)
                                User
                                @endif
                                @if($user->is_admin == 1)
                                Admin
                                @endif
                            </td> --}}
                            <td>
                                @if($user->status == 0)
                                InActive
                                @endif
                                @if($user->status == 1)
                                Active
                                @endif
                            </td>
                            <td>
                                {{-- <a href="{{ action('UserController@show',['user'=> $user->id])}}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-info"></i></a> --}}
                                @if( Auth::user()->is_admin )
                                <a href="{{route('user.edit',['user'=> $user->id])}}" class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i></a>
                                <button class="btn btn-outline-danger btn-sm remove-user" 
                                    data-id="{{ $user->id }}" 
                                    data-action="{{ route('user.destroy',$user->id) }}"> 
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
    $("body").on("click",".remove-user",function(){
        var current_object = $(this);
        Swal.fire({
            title: "Un utilisateur est sur le point d'être détruite",
            text: "Est-ce que vous êtes d'accord ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Annuler',
            confirmButtonText: 'Oui, supprimez-le!'
        }).then((result) => {
            if (result.isConfirmed) {
                var action = current_object.attr('data-action');
                var token = jQuery('meta[name="csrf-token"]').attr('content');
                var id = current_object.attr('data-id');
                $('body').html("<form class='form-inline remove-form' method='post' action='"+action+"'></form>");
                $('body').find('.remove-form').append('<input name="_method" type="hidden" value="delete">');
                $('body').find('.remove-form').append('<input name="_token" type="hidden" value="'+token+'">');
                $('body').find('.remove-form').append('<input name="id" type="hidden" value="'+id+'">');
                $('body').find('.remove-form').submit();
            }
        })
    });
</script>
@endsection