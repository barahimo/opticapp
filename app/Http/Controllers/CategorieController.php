<?php

namespace App\Http\Controllers;

use App\Produit;
use App\Categorie;
use App\Lignecommande;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategorieController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('statususer');
    }

    public function getPermssion($string)
    {
        $list = [];
        $array = explode("','",$string);
        foreach ($array as $value) 
            foreach (explode("['",$value) as $val) 
                if($val != '')
                    array_push($list, $val);
        $array = $list;
        $list = [];
        foreach ($array as $value) 
            foreach (explode("']",$value) as $val) 
                if($val != '')
                    array_push($list, $val);
        return $list;
    }

    public function hasPermssion($string)
    {
        $permission = $this->getPermssion(Auth::user()->permission);
        $permission_ = $this->getPermssion(User::find(Auth::user()->user_id)->permission);
        $result = 'no';
        if(
            (Auth::user()->is_admin == 2) ||
            (Auth::user()->is_admin == 1 && in_array($string,$permission)) ||
            (Auth::user()->is_admin == 0 && in_array($string,$permission) && in_array($string,$permission_))
        )
        $result = 'yes';
        return $result;
    }
    
    public function index()
    {
        $permission = $this->getPermssion(Auth::user()->permission);
        // $categories = Categorie::orderBy('id', 'desc')->get();
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $categories = Categorie::orderBy('id', 'desc')->where('user_id',$user_id)->get();
        // return view('managements.categories.index', compact('categories'));
        if($this->hasPermssion('list2') == 'yes')
            return view('managements.categories.index', compact(['categories','permission']));
        else
            return view('application');
    }

    public function create()
    {
        $permission = $this->getPermssion(Auth::user()->permission);
        // if(in_array('create2',$permission) || Auth::user()->is_admin == 2)
        if($this->hasPermssion('create2') == 'yes')
        return view('managements.categories.create');
        else
        return redirect()->back();
    }

    
    public function store(Request $request)
    {  
            // $validateData = $request->validate([
            //     'nom_client' => 'required',
            //     'telephone' => 'required',
            //     'adresse' => 'required' ,
            //     'solde' => 'required',
            //     'code_client' => 'required|min:4|max:100' 
                        
            // ]);
        $user_id = Auth::user()->id;
            if(Auth::user()->is_admin == 0)
                $user_id = Auth::user()->user_id;
        $categorie = new Categorie();
        $categorie ->nom_categorie = $request->input('nom_categorie');
        $categorie ->description = $request->input('description');
        $categorie->user_id = $user_id;

        $categorie->save();

        $request->session()->flash('status','La catégorie a été bien enregistrée !');
        return redirect()->route('categorie.index');
    }


    
    public function show(Categorie $categorie)
    {
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
        $user_id = Auth::user()->user_id;
        $categorie = categorie::where('user_id',$user_id)->findOrFail($categorie->id);
        $produits =  Produit::where('categorie_id', '=', $categorie->id)->get();
        $permission = $this->getPermssion(Auth::user()->permission);
        // if(in_array('show2',$permission) || Auth::user()->is_admin == 2)
        if($this->hasPermssion('show2') == 'yes')
        return view('managements.categories.show', [
            "categorie" => $categorie,
            "produits" => $produits 
        ]);
        else
        return redirect()->back();
    }

    
    public function edit(Categorie $categorie)
    {
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
        $user_id = Auth::user()->user_id;
        $categorie = categorie::where('user_id',$user_id)->findOrFail($categorie->id);
        $permission = $this->getPermssion(Auth::user()->permission);
        // if(in_array('edit2',$permission) || Auth::user()->is_admin == 2)
        if($this->hasPermssion('edit2') == 'yes')
        return view('managements.categories.edit')->with([
            "categorie" => $categorie
        ]);
        else
        return redirect()->back();
    }

    
    public function update(Request $request, Categorie $categorie)
    {
        // $this->validate($request, [

        //     'code_client' => 'required|min:4|max:100',     
        //     'nom_client' => 'required',
        //     'telephone' => 'required',
        //     'adresse' => 'required',
        //     'solde' => 'required',

        // ]);
        $user_id = Auth::user()->id;
            if(Auth::user()->is_admin == 0)
                $user_id = Auth::user()->user_id;
        $categorie ->nom_categorie = $request->input('nom_categorie');
        $categorie ->description = $request->input('description');
        $categorie->user_id = $user_id;

        $categorie->save();


        $request->session()->flash('status','La catégorie a été bien modifiée !');


        return redirect()->route('categorie.index');

    }

    public function searchCategorie(Request $request)
    {
        $search = $request->search;
        // $categories = Categorie::where('nom_categorie','like',"%$search%")
        //     ->orWhere('description','like',"%$search%")
        //     ->orderBy('id','desc')
        //     ->get();
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $categories = Categorie::where([
            [function ($query) use ($search) {
                    $query->where('nom_categorie','like',"%$search%")
                    ->orWhere('description','like',"%$search%");
            }],
            ['user_id',$user_id]
        ])
        ->orderBy('id','desc')
        ->get();
        return $categories;
    }

    public function destroy(Categorie $categorie)
    {
        $produits = Produit::where('categorie_id','=',$categorie->id)->get();
        if($produits->count()){
            $existe = false;
            foreach ($produits as $produit) {
                $lgcommande = Lignecommande::where('produit_id', '=', $produit->id )->first();
                if($lgcommande){
                    $existe = true;
                    break;
                }
            }
            if($existe){
                $msg = "La catégorie ne peut pas être supprimée car ses produits sont déja appartient à une commande";
            }
            else{
                $msg = "La catègorie et ses produits sont supprimées avec succès !";
                foreach ($produits as $produit) {
                    $produit->delete();
                }
                $categorie->delete();
            }
        }
        else{
            $categorie->delete();
            $msg = "La catégorie a été supprimée avec succès !";
        }

        // Post::destroy($id); supression directement

        return redirect()->route('categorie.index')->with([
            "status" => $msg
        ]); 
    }
    public function search(Request $request){
        $q = $request->input('q');

        $categories =  Categorie::where('nom_categorie', 'like', "%$q%")
        ->paginate(5);

        return view('managements.categories.search')->with('categories', $categories);  
    
    }

    public function ajouteProduit(Request $request,$id){
        $categorie=Categorie::find($id);
        return view('managements.categories.createProduit', [
            'categorie' => $categorie
        ]);

    }

    public function storeP(Request $request )
    {
        $produit = new Produit();
        $produit->nom_produit = $request->input('nom_produit');
        $produit->code_produit = $request->input('code_produit');
        $produit->TVA = $request->input('TVA');
        $produit->prix_produit_HT = $request->input('prix_produit_HT');
        $produit->description = $request->input('description');
        $produit->nom_categorie =  $request->input('nom_categorie');

        // dd($produit);

        $categorieligne = Categorie::where('nom_categorie','like', $produit->nom_categorie)->first();
        $produit->categorie_id = $categorieligne->id;
        

        $produit->save();

        $request->session()->flash('status','le produit a été ajouter à cette catégorie !');
        return redirect()->route('categorie.index');

    }
}
