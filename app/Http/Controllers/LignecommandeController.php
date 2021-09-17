<?php

namespace App\Http\Controllers;

use App\Client;
use App\Produit;
use App\Commande;
use App\Categorie;
use App\Lignecommande;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LignecommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index() 
    {
       $lignecommandes = lignecommande::orderBy('id', 'desc')->paginate(3);
       return view('managements.lignecommande.index', compact('lignecommandes'));
    }

   
    public function create(Request $request, Commande $commande)
    {

        $lastOne = DB::table('commandes')->latest('id')->first();


        $prod=Categorie::all();//get data from table
		
        $p = $request->input('categorie_id');
        
        $lignecommandes = lignecommande::orderBy('id')->paginate(3);
        $lignecommandes =  Lignecommande::where('commande_id', '=', $lastOne->id)
         ->paginate(100);
        
        $priceTotal = 0;
        foreach($lignecommandes as $p){
        
            $priceTotal = $priceTotal + $p->total_produit ;
            }
        //    dd($priceTotal);
    
        
        return view('managements.lignecommande.create', [

            'prod' => $prod,
            'clients' =>Client::all(),
            'produits' => Produit::all(),
            'commandes' => Commande::all(),
            'categories' => Categorie::all(),
            'lastOne' =>  $lastOne, 
            'lignecommandes' =>  $lignecommandes,
            'priceTotal'  => $priceTotal,
            'commande' => $commande
        ]);
    

       
    }
    // public function ajoute(Request $request, Commande $commande){
        public function ajoute(Request $request,$id){

        // $lastOne = DB::table('commandes')->latest('id')->first();


        $prod=Categorie::all();//get data from table
        $commande=Commande::find($id);//get data from table
		
        $p = $request->input('categorie_id');
        
        $lignecommandes = lignecommande::orderBy('id')->paginate(3);
        $lignecommandes =  Lignecommande::with('produit')->where('commande_id', '=', $commande->id)->paginate(100);
        
        $priceTotal = 0;
        foreach($lignecommandes as $p){
            // $p->nom_produit = $p->produit->nom_produit;
            $priceTotal = $priceTotal + $p->total_produit ;
        }
        //    dd($priceTotal);
    
        
        return view('managements.lignecommande.create', [

            'prod' => $prod,
            'clients' =>Client::all(),
            'produits' => Produit::all(),
            'commandes' => Commande::all(),
            'categories' => Categorie::all(),
            //'lastOne' =>  $lastOne, 
            'lignecommandes' =>  $lignecommandes,
             'priceTotal'  => $priceTotal,
             'commande' => $commande
        ]);



    }

    
    public function store(Request $request)

      {  
        

        $lignecommande = new Lignecommande();
        $lignecommande->commande_id = $request->input('commande_id');
        $lignecommande->produit_id = $request->input('nom_produit');
        // $lignecommande->nom_produit = $request->input('nom_produit');
        $lignecommande->quantite = $request->input('quantite');
        $lignecommande->total_produit = $request->input('yarbi');
        
       
    
        $lignecommande->save();
        

        $request->session()->flash('status','le client a été bien modifié !');


        return redirect()->route('lignecommande.index');


    
      }

      public function createProduit()
      {
          return view('managements.lignecommande.createProduit',[
              'commandes' => Commande::all(),
              'produits' => Produit::all()
          ]);
      }

     
  
      
      public function storeProduit(Request $request)
  
        {  
         
  
          $lignecommande = new Lignecommande();
          $lignecommande->commande_id = $request->input('commande_id');
          $lignecommande->produit_id = $request->input('nom_produit');
        //   $lignecommande->nom_produit = $request->input('nom_produit');
          $lignecommande->quantite = $request->input('quantite');
          
  
        //   $Produitligne = Produit::where('id','=', $lignecommande->produit_id)->get();
        //   foreach($Produitligne as $var)
        //   {   
        //       $name = $var->nom_produit;
        //   } 
     
        //   $lignecommande->nom_produit = $name;
        
         
      
          $lignecommande->save();
          
  
        //   $request->session()->flash('status','le client a été bien modifié !');
  
  
        $lgcommande = Commande::all();

          return redirect()->route('commande.index');
  

        }

    

    
    public function show(Lignecommande $lignecommande)
    {
        

        $Produitligne = Produit::where('id','=', $lignecommande->produit_id)->get();
        foreach($Produitligne as $var)
        {   
   
            // $name = $var->nom_produit;
            $tva =  $var->TVA;
            $pu = $var->prix_produit_HT;
        } 
    
        return view('managements.lignecommande.show', [

            "lignecommande" => $lignecommande,
            "tva" => $tva,
            "pu" => $pu,
            "nom" => $name
        ]);
    }

    
    public function edit(Lignecommande $lignecommande)
    {
        return view('managements.lignecommande.edit')->with([
           "lignecommande" => $lignecommande,
           'produits' => Produit::all(),
           'commandes' => Commande::all()
         ]);
    }

    
    public function update(Request $request, Lignecommande $lignecommande)
    {

        $lignecommande->commande_id = $request->input('commande_id');
        $lignecommande->produit_id = $request->input('nom_produit');
        // $lignecommande->nom_produit = $request->input('nom_produit');
        $lignecommande->quantite = $request->input('quantite');
       

        // $Produitligne = Produit::where('id','=', $lignecommande->produit_id)->get();
        // foreach($Produitligne as $var)
        // {   
   
        //     $name = $var->nom_produit;

        // } 
   
        // $lignecommande->nom_produit = $name;
      
       
    
        $lignecommande->save();

        $request->session()->flash('status','le client a été bien modifié !');


        return redirect()->route('lignecommande.index');

    }

    
    public function destroy(Lignecommande $lignecommande)
    {
        $lignecommande->delete();

        // Post::destroy($id); supression directement

        
        return redirect()->route('facture.index')->with([
            "status" => "la ligne de commande a été bien supprimer ! veuillez valider les modifications dans  la facture!!"
        ]); 
    }

    public function search(Request $request){
        $q = $request->input('q');

     $lignecommandes =  Lignecommande::where('commande_id', '=', $q)
         ->paginate(5);

         return view('managements.lignecommande.search')->with('lignecommandes', $lignecommandes);  
      
      }

    public function affecte( Lignecommande $lignecommande, Request $request)
    {
        // $lignecommande->id =  $request->input('lignecommande_id');
        $lignecommande->commande_id = $request->input('commande_id');
        $lignecommande->produit_id = $request->input('produit_id');
        // $lignecommande->nom_produit = $request->input('nom_produit');
        $lignecommande->quantite = $request->input('qt');
        $lignecommande->total_produit = $request->input('amount'); 
    
    
        $lignecommande->save();



        return redirect()->route('lignecommande.index');


    }

     
}
