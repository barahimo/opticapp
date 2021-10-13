@extends('layout.dashboard')
@section('contenu')
<!-- ##################################################################### -->
<!-- Content Header (Page header) -->
<div class="content-header sty-one">
  <h1>Panneau des commandes</h1>
  <ol class="breadcrumb">
      <li><a href="{{route('app.home')}}">Home</a></li>
      <li><i class="fa fa-angle-right"></i> Commandes</li>
  </ol>
</div>
{{-- ################## --}}
<div class="container">
  <br>
  <div class="row">
    <div class="col text-left">
      @if(in_array('create5',$permission))
      <a id="create" href="{{route('reglement.create2')}}" class="btn btn-primary m-b-10 ">
        <i class="fa fa-plus"></i>&nbsp;Règlements
      </a>
      @endif
    </div>
    <div class="col text-right">
      @if(in_array('create4',$permission))
      <a href="{{route('commande.create')}}" class="btn btn-primary m-b-10 ">
        <i class="fa fa-plus"></i>&nbsp;Commande
      </a>
      @endif
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-4">
      <select class="form-control" name="client" id="client">
      <option value="">--La liste des clients--</option>
        @foreach($clients as $client)
        <option value="{{$client->id }}">{{ $client->nom_client}}</option>
        @endforeach
      </select>
    </div>
    <div class="col-4">
      <div class="row">
        <div class="col-6">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" name="f" id="f" value="f" checked>
            <label for="f">facturée</label>
          </div>
        </div>
        <div class="col-6">
          <div class="form-check">
              <input type="checkbox" class="form-check-input" name="nf" id="nf" value="nf" checked>
              <label for="nf">Non facturée</label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" name="r" id="r" value="r" checked>
            <label for="r">Réglée</label>
          </div>
        </div>
        <div class="col-6">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" name="nr" id="nr" value="nr" checked>
            <label for="nr">Non réglée</label>
          </div>
        </div>
      </div>
    </div>
    <div class="col-4">
      <input type="text" class="form-control" name="search" id="search" placeholder="search ..">
    </div>
  </div>
</div>
<!-- ####################### -->
<!-- Main content -->
<div class="content">
  <!-- Main card -->
  <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table" id="table">
            <thead class="bg-primary text-white">
              <tr>
                <th>#</th>
                <th>Date</th>
                <th>Client</th>
                <th>Montant total</th>
                <th>Montant payer</th>
                <th>Reste à payer</th>
                <th style="display : none">Status</th>
                <th style="display : none">Facture</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
  </div>
</div>
<!-- ####################### -->
<!-- ---------  BEGIN SCRIPT --------- -->
@include('managements.commandes.script_cmd')
{{-- {!! Html::script( asset('js/cmd.js')) !!}  --}}
{{-- <script src="{{asset('js/index_commande.js')}}"></script> --}}
<!-- ##################################################################### -->
@endsection

