@extends('layout.dashboard')

@section('contenu')

<div class="row justify-content-left m-l-10">
    <div class="col-md-8">
        <div class="card" style="background-color: rgba(241, 241, 241, 0.842)">
            <div class="card-body">
                <input type="text" class="form-control" placeholder="Nom Client">&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" class="form-control" placeholder="Adresse">&nbsp;&nbsp;&nbsp;&nbsp;
                <select class="form-control" placeholder="mode reglement"> 

                    <option value="0">chèque</option>
                    <option value="0">carte banquaire</option>
                    
                    
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" class="form-control" placeholder="avance">&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" class="form-control" placeholder="reste">&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="date" class="form-control" placeholder="date">&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        </div>
    </div>
</div>

@endsection