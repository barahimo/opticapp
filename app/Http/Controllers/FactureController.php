<?php

namespace App\Http\Controllers;

use App\Facture;
use App\Commande;
use App\Company;
use App\Lignecommande;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FactureController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('statususer');
    }

    /** 
    *--------------------------------------------------------------------------
    * Mes fonctions
    *--------------------------------------------------------------------------
    **/
    public function getPermssion($string){
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

    public function hasPermssion($string){
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

    public function getAdresse($company){
        // ############################################################### //
        $adresse1 = '';
        // ############################################################### //
        ($company && ($company->nom || $company->nom != null)) ? $adresse1 .= 'Siège social : '.$company->nom.' - ' : $adresse1 .= 'Siège social : nom_societé';
        // -------------------------------------//
        ($company && ($company->adresse || $company->adresse != null)) ? $adresse1 .= $company->adresse.' , ' : $adresse1 .= '';
        // -------------------------------------//
        ($company && ($company->code_postal || $company->code_postal != null)) ? $adresse1 .= $company->code_postal.' , ' : $adresse1 .= '';
        // -------------------------------------//
        ($company && ($company->ville || $company->ville != null)) ?  $adresse1 .= $company->ville.' , ' : $adresse1 .= '';
        // -------------------------------------//
        ($company && ($company->pays || $company->pays != null)) ? $adresse1 .= $company->pays : $adresse1 .= '';
        // ############################################################### //
        $adresse2 = '';
        // ############################################################### //
        ($company && ($company->capital || $company->capital != null)) ? $adresse2 .= 'Capital : '.$company->capital.' - ' : $adresse2 .= '';
        // -------------------------------------//
        ($company && ($company->ice || $company->ice != null)) ? $adresse2 .= 'ICE : '.$company->ice.' - ' : $adresse2 .= '';
        // -------------------------------------//
        ($company && ($company->iff || $company->iff != null)) ? $adresse2 .= 'I.F. : '.$company->iff.' - ' : $adresse2 .= '';
        // ############################################################### //
        $adresse3 = '';
        // ############################################################### //
        ($company && ($company->rc || $company->rc != null)) ? $adresse3 .= 'R.C. : '.$company->rc.' - ' : $adresse3 .= '';
        // -------------------------------------//
        ($company && ($company->patente || $company->patente != null)) ? $adresse3 .= 'Patente : '.$company->patente.' - ' : $adresse3 .= '';
        // -------------------------------------//
        ($company && ($company->cnss || $company->cnss != null)) ? $adresse3 .= 'CNSS : '.$company->cnss.' - ' : $adresse3 .= '';
        // ############################################################### //
        $adresse4 = '';
        // ############################################################### //
        ($company && ($company->tel || $company->tel != null)) ? $adresse4 .= 'Tél : '.$company->tel.' - ' : $adresse4 .= '';
        // -------------------------------------//
        ($company && ($company->site || $company->site != null)) ? $adresse4 .= 'Site : '.$company->site.' - ' : $adresse4 .= '';
        // -------------------------------------//
        ($company && ($company->email || $company->email != null)) ? $adresse4 .= 'Email : '.$company->email.' - ' : $adresse4 .= '';
        // ############################################################### //
        $adresse5 = '';
        // ############################################################### //
        ($company && ($company->banque || $company->banque != null)) ? $adresse5 .= 'BANQUE : '.$company->banque.' - ' : $adresse5 .= '';
        // -------------------------------------//
        ($company && ($company->rib || $company->rib != null)) ? $adresse5 .= 'RIB : '.$company->rib.' - ' : $adresse5 .= '';
        // ############################################################### //
        $adresse = '';
        if($adresse1 != '')
            $adresse .= $adresse1.'<br>';
        if($adresse2 != '')
            $adresse .= $adresse2.'<br>';
        if($adresse3 != '')
            $adresse .= $adresse3.'<br>';
        if($adresse4 != '')
            $adresse .= $adresse4.'<br>';
        if($adresse5 != '')
            $adresse .= $adresse5.'<br>';
        return $adresse;
    }
    /** 
    *--------------------------------------------------------------------------
    * searchFacture
    *--------------------------------------------------------------------------
    **/
    public function searchFacture(Request $request){
        $search = $request->search;
        
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $factures = Facture::with(['commande' => function ($query) {
                $query->with('client')->get();
            }])
            ->where([
                [function ($query) use ($search) {
                    $query->where('code','like',"%$search%")
                    ->orWhere('date','like',"%$search%")
                        ->orWhere('total_HT','like',"%$search%")
                        ->orWhere('total_TVA','like',"%$search%")
                        ->orWhere('total_TTC','like',"%$search%");
                }],
                ['user_id',$user_id]
            ])
            ->orWhereHas('commande',function($query) use($search,$user_id){
                $query->where([['code','like',"%$search%"],['user_id',$user_id]])
                    ->orWhereHas('client',function($query) use($search,$user_id){
                    $query->where([['nom_client','like',"%$search%"],['user_id',$user_id]]);
                });
            })
            ->orderBy('id','desc')
            ->get();
        return $factures; 
    }
    /** 
    *--------------------------------------------------------------------------
    * Ressources
    *--------------------------------------------------------------------------
    **/
    public function index(){
        $permission = $this->getPermssion(Auth::user()->permission);
        
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $factures = Facture::with(['commande' => function ($query) {
            $query->with('client')->get();
        }])
        ->where('user_id',$user_id)
        ->orderBy('id','desc')->get();
        
        if($this->hasPermssion('list6') == 'yes')
        return view('managements.factures.index', compact(['factures','permission']));
        else
        return view('application');
    }

    public function create(){
        //
    }

    public function store(Request $request){
        //
    }
    
    public function show(Request $request, Facture $facture){
        $permission = $this->getPermssion(Auth::user()->permission);
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $companies = Company::where('user_id',$user_id)->get();
        $count = count($companies);
        ($count>0)  ? $company = Company::where('user_id',$user_id)->first(): $company = null;
        $adresse = $this->getAdresse($company);
        $facture = Facture::where('user_id',$user_id)->findOrFail($facture->id);
        $commande = Commande::with('client')->where('id', "=", $facture->commande_id)->first();
        $lignecommandes =  Lignecommande::with('produit')->where('commande_id', '=', $commande->id)->get();
        $prix_HT = 0;
        foreach($lignecommandes as $q){
           $prix_HT = $prix_HT +  ($q->produit->prix_produit_HT * $q->quantite);
        }
        $TVA = 0;
        foreach($lignecommandes as $q){
           $TVA = $TVA +  ($q->produit->prix_produit_HT * $q->quantite * $q->produit->TVA) ;
        }
        $priceTotal = 0;
        foreach($lignecommandes as $p){
            $priceTotal = floatval($priceTotal  + $p->total_produit) ;
        }
        $permission = $this->getPermssion(Auth::user()->permission);
        if($this->hasPermssion('show6') == 'yes')
        return view('managements.factures.show', [
            'lignecommandes' =>  $lignecommandes,
            'priceTotal'  => $priceTotal,
            'prix_HT' => $prix_HT,
            'TVA' => $TVA,
            'commande' => $commande,
            'facture' => $facture,
            'company' => $company,
            'count' => $count,
            'adresse' => $adresse,
            'permission' => $permission
        ]);
        else
        return redirect()->back();
    }

    public function edit(Facture $facture){
        $commande = Commande::with('client')->where('id', "=", $facture->commande_id)->first();
        $lignecommandes =  Lignecommande::with('produit')->where('commande_id', '=', $commande->id)->get();
        
        $prix_HT = 0;
        foreach($lignecommandes as $q){
           $prix_HT = $prix_HT +  ($q->produit->prix_produit_HT * $q->quantite);
        }

    
        $TVA = 0;
        foreach($lignecommandes as $q){
           $TVA = $TVA +  ($q->produit->prix_produit_HT * $q->quantite * $q->produit->TVA) ;
        }

        $priceTotal = 0;
        foreach($lignecommandes as $p){
            $priceTotal = floatval($priceTotal  + $p->total_produit) ;
            $p->nom_produit = $p->produit->nom_produit;
        }

        return view('managements.factures.edit')->with([
            "facture" => $facture,
            'lignecommandes' =>  $lignecommandes,
            'priceTotal'  => $priceTotal,
            'prix_HT' => $prix_HT,
            'TVA' => $TVA,
            'commande' => $commande
        ]);
    }
    
    public function update(Request $request, Facture $facture){
        $user_id = Auth::user()->id;
        $facture->total_HT = $request->input('total_HT');
        $facture->total_TVA = $request->input('total_TVA');
        $facture->total_TTC = $request->input('total_TTC');
        $facture->commande_id = $request->input('commande_id');
        $facture->reglement = $request->input('reglement');
        $facture->user_id = $user_id;
        $facture->save();


        return redirect()->route('reglement.index')->with([
            "status" => "la facture a été bien modifier !! veuillez modifier le reglement de la commande N°" .$facture->commande_id
        ]); 
    }
    
    public function destroy(Facture $facture){
        $facture->commande->facture = 'nf';
        $facture->commande->save();
        $facture->delete();
        return redirect()->route('facture.index')->with(["status" => "La facture a été supprimée avec succès !"]) ; 
    }
    /** 
    *--------------------------------------------------------------------------
    * Autres fonctions
    *--------------------------------------------------------------------------
    **/ 
// ----------------------------------------------
}
