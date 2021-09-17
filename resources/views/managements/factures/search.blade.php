

 @extends('layout.dashboard')

 @section('contenu')
 
 <div class="row justify-content-center">
     <div class="col-md-10">
         <div class="row">
             <div class="col-md-3">
                 <h4>Panneau de Factures</h4> 
 
             </div>
            
           
 
 
 
             {{-- <div class="col-md-9 text-right">
                 <a href="{{route('facture.create')}}" class="btn btn-primary m-b-10 "><i class="fa fa-user-plus"> Nouveau réglement</i></a>
             </div>  --}}
 
            
                     @if(session()->has('status'))
                     {{-- <div class="alert  alert-success "> 
                         {{ session()->get('status')}}
                     </div> --}}
                     <script>
                        Swal.fire('{{ session('status')}}')
                      </script>
   
                     @endif
                  
     
                 
 
                  
 
             
 
         </div>
         <div class="card  m-t-50" style="background-color: rgba(241, 241, 241, 0.842)">
             <div class="card-body">
                 <table class="table">
                     <thead>
                         <tr>
                             <th>#</th>
                             
                             <th>N° commande</th>
                             <th>client_id</th>
                             <th> total_HT</th>
                             <th> total_TVA</th>
                             <th> total_TTC</th>
                             

                            
                             <th>Actions</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach($factures as $facture)
                           <tr>
 
                             <td>{{$facture->id}}</td>
                             <td> {{$facture->commande_id}}</td>
                             <td>{{$facture->clients_id}}</td>
                               <td>{{$facture->total_HT}}</td>
                               <td>{{$facture->total_TVA}}</td>
                               <td>{{$facture->total_TTC}}</td>
                               
                              
 
                               <td>
                                 

                                 
                                <button class="btn btn-danger btn-flat btn-md remove-facture" 
                                data-id="{{ $facture->id }}" 
                                data-action="{{ route('facture.destroy',$facture->id) }}"> 
                                <i class="fas fa-trash"></i>
                               </button>
                                   <a href="{{ action('FactureController@show',['facture'=> $facture])}}" class="btn btn-secondary btn-md"><i class="fas fa-info"></i></a>
                                  <a href="{{route('facture.edit',['facture'=> $facture])}}"class="btn btn-success btn-md"><i class="fas fa-edit"></i></a>

                             </td>
                         </tr>
                       @endforeach
                   </tbody>
               </table>
           </div>
<script type="text/javascript">
   
   
   $("body").on("click",".remove-facture",function(){
       var current_object = $(this);
      
       // begin swal2
       Swal.fire({
           title: 'Un facture est sur le point de être DÉTRUITE ',
           text: "You won't be able to revert this!",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Yes, delete it!'
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
               Swal.fire(
               'Deleted!',
               'Your file has been deleted.',
               'success'
               )
           }
           })
       // end swal2
       });
           </script>
            </div>
         {{ $factures->links()}}
     </div>
 

     {{-- @if ($errors->any())  

     <ul>
         @foreach($errors->all() as $error)
         <li>{{ $error }}</li>
         @endforeach
     </ul>
     @endif
      --}}
 </div>
 
 @endsection
 
 
 