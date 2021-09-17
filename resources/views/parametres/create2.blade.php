@extends('layout.dashboard')
@section('contenu')
<!-- ##################################################################### -->
<!-- {!! Html::style( asset('/css/style.css')) !!} -->
<div  class="container">
    <div class="card" style="background-color : #dff3d5;border : 1px solid black;width:70%;margin-right: auto;margin-left: auto">
        <div class="card-body">
            <form  method="POST" action="{{route('company.store')}}">
                @csrf 
                <!-- ########################################## -->
                @include('parametres.form')
                <!-- ########################################## -->
                <div class="form-group">
                    <button class="btn btn-info" type="submit">Ajouter</button>
                    <a href="{{action('CompanyController@index')}}" class="btn btn-info">retour</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection