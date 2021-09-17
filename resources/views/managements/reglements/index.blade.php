

 @extends('layout.dashboard')

 @section('contenu')
 
 <div class="row justify-content-center">
     <div class="col-md-10">
         <div class="row">
             <div class="col-md-3">
                 <h4>Panneau de Réglements</h4>
 
             </div>
            
           
 
 
 
             <div class="col-md-9 text-right">
                 <a href="{{route('reglement.create')}}" class="btn btn-primary m-b-10 "><i class="fa fa-user-plus"> Nouveau réglement</i></a>
             </div> 
 
             
                     @if(session()->has('status'))
                     <script>
                        Swal.fire('{{ session('status')}}')
                      </script>
   
                     @endif
                   
     
                 
 
                   <table class="table">
                     
                       <tr>
                         <td scope="col">
 
 
                             @include('partials.searchreglement')
 
                         </td>
                         
                     </tr>
                     
                   </table>
 
             
 
         </div>
         <div class="card" style="background-color: rgba(241, 241, 241, 0.842)">
             <div class="card-body">
                 <table class="table">
                     <thead>
                         <tr>
                             <th>#</th>
                             
                             <th>Nom Client</th>
                             <th>commande_id</th>
                             <th> mode réglement</th>
                             <th> avance</th>
                             <th> reste</th>
                             <th> réglement</th>

                            
                             <th>Actions</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach($reglements as $reglement)
                           <tr>
 
                             <td>{{$reglement->id}}</td>
                             <td> {{$reglement->nom_client}}</td>
                             <td>{{$reglement->commande_id}}</td>
                               <td>{{$reglement->mode_reglement}}</td>
                               <td>{{$reglement->avance}}</td>
                               <td>{{$reglement->reste}}</td>
                               <td>{{$reglement->status}}</td>
                              
 
                               <td>
                                  
                                   @csrf {{-- génère un toke pur protéger le formulaie--}}
                                 
                                  <a href="{{ action('ReglementController@show',['reglement'=> $reglement])}}" class="btn btn-secondary btn-md"><i class="fas fa-info"></i></a>
                                  @if( Auth::user()->is_admin )
                                  <a href="{{route('reglement.edit',['reglement'=> $reglement])}}"class="btn btn-success btn-md"><i class="fas fa-edit"></i></a>
                                    
                                  <button class="btn btn-danger btn-flat btn-md remove-reglement" 
                                  data-id="{{ $reglement->id }}" 
                                  data-action="{{ route('reglement.destroy',$reglement->id) }}"> 
                                  <i class="fas fa-trash"></i>
                                 </button>
                                 @endif
   
                              </td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
   <script type="text/javascript">
    
    
    $("body").on("click",".remove-reglement",function(){
        var current_object = $(this);
        
        Swal.fire({
            title: 'Un reglement est sur le point de être DÉTRUITE ',
            text: "vous voulez vraiment la supprimer !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'oui, je suis sur!'
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
        </div>
        {{ $reglements->links()}}
    </div>
</div>
 
 @endsection
 
 
 