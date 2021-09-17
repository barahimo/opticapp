@extends('layout.dashboard')

@section('contenu')


    
        @if(session('status'))
       
        {{-- <div class="alert  alert-success "> 
            {{ session()->get('status')}}
        </div> --}}
        <script>
            Swal.fire('{{ session('status')}}')
          </script>
        @endif
     

@endsection