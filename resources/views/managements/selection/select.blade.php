<html lang="en">
<head>
    
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.5/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.5/chosen.min.css">
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script> -->
 </head>
<body>
<center>
        {{-- <select   class=" chosen form-control" style="width: 500px ; background"   name="nom_categorie" value="{{ old('nom_categorie', $produit->nom_categorie?? null) }}" > --}}
        {{-- <select  class="chosen form-control"  name="nom_categorie" value="{{ old('nom_categorie', $produit->nom_categorie?? null) }}" > --}}
        <select  class="chosen form-control"  name="nom_categorie">
            @foreach($categories as $categorie)
                <option value="{{$categorie->id }}" @if ($categorie->id == old('nom_categorie',$produit->categorie_id ?? null)) selected="selected" @endif> {{ $categorie->nom_categorie}}</option>
            @endforeach
         </select>
    
</center>
</body>
<script type="text/javascript">$(".chosen").chosen();
</script>
</html>