<?php

namespace App\Http\Controllers;

use App\Produit;
use App\Categorie;
use App\Lignecommande;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index()
    {
        // $produits = Produit::with('categorie')->orderBy('id')->paginate(10);
        $produits = Produit::with('categorie')->orderBy('id','desc')->get();
        $categories = Categorie::all();
        return view('managements.produits.index', compact('produits', 'categories'));
    }

    public function create()
    {
        return view('managements.produits.create',[
            'categories' => Categorie::all()
        ]);
    }

    
    public function store(Request $request)
    {  
        $validateData = $request->validate([
            'nom_produit' => 'required',
            'code_produit' => 'required',
            'TVA' => 'required' ,
            'prix_produit_HT' => 'required',
            // 'nom_categorie' => 'required' 
        ]);
        $tva = $request->input('TVA');
        $ht = $request->input('prix_produit_HT');
        $ttc = $request->input('prix_produit_TTC');
        $produit = new Produit();
        $produit->nom_produit = $request->input('nom_produit');
        $produit->code_produit = $request->input('code_produit');
        $produit->TVA = $tva;
        $produit->prix_produit_HT = $ht ;
        $produit->prix_produit_TTC = $ht + ($ht * $tva/100) ;
        $produit->description = $request->input('description');
        // $produit->nom_categorie =  $request->input('nom_categorie');
        $produit->categorie_id =  $request->input('nom_categorie');
        // $categorieligne = Categorie::where('id','=', $produit->categorie_id)->get();
        // foreach($categorieligne as $var)
        // {   
            //     $name = $var->nom_categorie;
            // } 
        // $categorieligne = Categorie::find($produit->categorie_id);
        // $name = $categorieligne->nom_categorie;
        // $produit->nom_categorie = $name;
        $produit->save();
        $request->session()->flash('status','le produit a été bien enregistré !');
        return redirect()->route('produit.index');
    }

    //   public function search(Request $request){
    //       $search = $request->get('search');
    //       $clients = DB::table('clients')->where('nom_client','like', '%'.$search.'%')->paginate(3);
    //        return view('managements.commandes.index',['clients' => $clients]);
    //   }

    
    public function show(Produit $produit)
    {
        $produit = Produit::with('categorie')->find($produit->id);
        return view('managements.produits.show', [
            "produit" => $produit
        ]);
    }

    
    public function edit(Produit $produit)
    {
        return view('managements.produits.edit')->with([
           "produit" => $produit,
           'categories' => Categorie::all()
        ]);
    }

    
    public function update(Request $request, Produit $produit)
    {
        // $this->validate($request, [

        //         'nom_produit' => 'required',
        //         'code_produit' => 'required',
        //         'TVA' => 'required' ,
        //         'prix_produit_HT' => 'required',
        //         // 'nom_categorie' => 'required|min:4|max:100' 
                        
        // ]);
        $produit->nom_produit = $request->input('nom_produit');
        $produit->code_produit = $request->input('code_produit');
        $produit->TVA = $request->input('TVA');
        $produit->prix_produit_HT = $request->input('prix_produit_HT');
        $produit->description = $request->input('description');
        // $produit->nom_categorie =  $request->input('nom_categorie');
        $produit->categorie_id =  $request->input('nom_categorie');
        // --------------------------------------------------------
        // $categorieligne = Categorie::where('id','=', $produit->categorie_id)->get();
        // foreach($categorieligne as $var)
        // {   
        //     $name = $var->nom_categorie;
        // } 
        // $categorieligne = Categorie::find($produit->categorie_id);
        // $name = $categorieligne->nom_categorie;
        // $produit->nom_categorie = $name;
        // --------------------------------------------------------
        // $categorieligne = Categorie::where('nom_categorie','like', $produit->nom_categorie)->get();
        // foreach($categorieligne as $var)
        // {   
        //     //  dd($var->id);
        //     $id= $var->id;
        // } 
        // $produit->categorie_id = $id;
        // --------------------------------------------------------
        $produit->save();
        $request->session()->flash('status','le produit a été bien modifié !');
        return redirect()->route('produit.index');
    }

    
    public function destroy(Produit $produit)
    {

            $existe = false;
            
                $lgcommande = Lignecommande::where('produit_id', '=', $produit->id )->first();
                if($lgcommande){
                    $existe = true;
                }

            if($existe){
                $msg = " Attention !! le produit ne peut pas être supprimée car déja appartient à une commande";
            }
           
        
            else{
            
            $produit->delete();
            $msg = "produit a été supprimer avec succès !";
            }

        // Post::destroy($id); supression directement

        return redirect()->route('produit.index')->with([
            "status" => $msg
        ]); 



        // Post::destroy($id); supression directement

        // return redirect()->route('produit.index')->with([
        //     "success" => "le produit a été supprimer avec succès!"
        // ]); 
    }

    public function search(Request $request){
        $q = $request->input('q');

        $produits =  Produit::where('nom_produit', 'like', "%$q%")
        ->paginate(5);

            return view('managements.produits.search')->with('produits', $produits);  
    
    }
    
    public function searchProduit(Request $request)
    {
        $search = $request->search;
        $produits = Produit::with('categorie')->where('nom_produit','like',"%$search%")
            ->orWhere('code_produit','like',"%$search%")
            ->orWhere('TVA','like',"%$search%")
            ->orWhere('prix_produit_HT','like',"%$search%")
            ->orWhere('prix_produit_TTC','like',"%$search%")
            ->orWhereHas('categorie',function($query) use($search){
                $query->where('nom_categorie','like',"%$search%");
            })
            ->orderBy('id','desc')
            ->get();
        return $produits;
    }
    // ---------------------
}
