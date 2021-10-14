<?php

namespace App\Http\Controllers;

use App\Client;
use App\Facture;
use App\Produit;
use App\Commande;
use App\Categorie;
use App\Company;
use App\Reglement;
use App\Lignecommande;
use Faker\Core\Number;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use NumberToWords\NumberToWords;



class CommandeController extends Controller
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
    // ------------ BEGIN INDEX COMMANDE ------------------------------
    public function index(Request $request){
        $permission = $this->getPermssion(Auth::user()->permission);
        // $commandes = Commande::with(['client','reglements'])->get();
        // $lignecommandes = Lignecommande::get();
        // $reglements = reglement::get();
        // $clients = Client::get();
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $commandes = Commande::with(['client','reglements'])->where('user_id',$user_id)->get();
        $lignecommandes = Lignecommande::where('user_id',$user_id )->get();
        $reglements = reglement::where('user_id',$user_id )->get();
        $clients = Client::where('user_id',$user_id )->get();
        if(in_array('list4',$permission) || Auth::user()->is_admin == 2)
        return view('managements.commandes.index', [
            'commandes'=>$commandes,
            'lignecommandes'=>$lignecommandes,
            'reglements'=>$reglements,
            'clients' =>$clients,
            'permission' =>$permission,
        ]);
        else
        return view('application');
    }
    // ------------ END INDEX COMMANDE ------------------------------
    // ------------ BEGIN CREATE COMMANDE ---------------------------
    public function create(Request $request){
        $date = Carbon::now();
        // $categories=Categorie::all();//get data from table
        // $clients = Client::all();
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $categories=Categorie::where('user_id',$user_id)->get();//get data from table
        $clients = Client::where('user_id',$user_id)->get();
        $permission = $this->getPermssion(Auth::user()->permission);
        if(in_array('create4',$permission) || Auth::user()->is_admin == 2)
        return view('managements.commandes.create', [
            'clients' =>$clients,
            'categories' => $categories,
            'date' => $date,
        ]);
        else
        return redirect()->back();
    }
    // ------------ END CREATE COMMANDE ------------------------------
    // ------------ BEGIN STORE COMMANDE ---------------------------
    public function store(Request $request){ 
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        // return ['status'=>"error",'message'=>"user_id : ".$user_id];
        $lignes = $request->input('lignes');
        $date = $request->input('date');
        $client = $request->input('client');
        $gauche = $request->input('gauche');
        $droite = $request->input('droite');
        $total = $request->input('total');
        $mode = $request->input('mode');
        $avance = $request->input('avance');
        $reste = $request->input('reste');
        $status = $request->input('status');
        // -----------------------------------------------------
        if(!empty($lignes)){
            // -----------------------------------------------------
            $time = strtotime($date);
            $year = date('y',$time);
            $month = date('m',$time);
            // -----------------------------------------------------
            // $commandes = Commande::get();
            $commandes = Commande::where('user_id',$user_id)->get();
            (count($commandes)>0) ? $lastcode = $commandes->last()->code : $lastcode = null;
            $str = 1;
            if(isset($lastcode)){
                // ----- BON-2108-0001 ----- //
                $list = explode("-",$lastcode);
                $y = substr($list[1],0,2);
                $n = $list[2];
                ($y == $year) ? $str = $n+1 : $str = 1;
            } 
            $pad = str_pad($str,4,"0",STR_PAD_LEFT);
            $code = 'BON-'.$year.''.$month.'-'.$pad;
            // -----------------------------------------------------
            if(!empty($date) && !empty($client) && $client != "0"){
                if($avance>0 && $mode == ""){
                    return ['status'=>"error",'message'=>"Veuillez saisir le mode de règlement !"];
                }
                // ------------ Begin Commande -------- //
                $commande = new Commande();
                $commande->date = $date;
                $commande->client_id = $client;
                // $commande->nom_client = Client::find($client)->nom_client;
                $commande->oeil_gauche = $gauche;
                $commande->oeil_droite = $droite;
                $commande->facture = "nf"; 
                $commande->avance = $avance;
                $commande->reste = $reste;
                $commande->total = $total;
                $commande->code = $code;
                $commande->user_id = $user_id;
                $commande->save();
                // ------------ End Commande -------- //
                if($commande->id){
                    // ------------ Begin LigneCommande -------- //
                    foreach ($lignes as $ligne) {
                        $lignecommande = new Lignecommande();
                        $lignecommande->commande_id = $commande->id;
                        $lignecommande->produit_id = $ligne['prod_id'];
                        // $lignecommande->nom_produit = $ligne['libelle'];
                        $lignecommande->quantite = $ligne['qte'];
                        $lignecommande->total_produit = $ligne['total'];
                        $lignecommande->user_id = $user_id;
                        $lignecommande->save();
                    }
                    // ------------ End LigneCommande -------- //
                    // -----------------------------------------------------
                    $time = strtotime($date);
                    $year = date('y',$time);
                    $month = date('m',$time);
                    // -----------------------------------------------------
                    $getReg = Reglement::where('user_id',$user_id)->get();
                    (count($getReg)>0) ? $lastcode = $getReg->last()->code : $lastcode = null;
                    $str = 1;
                    if(isset($lastcode)){
                        // ----- REG-2108-0001 ----- //
                        $list = explode("-",$lastcode);
                        $y = substr($list[1],0,2);
                        $n = $list[2];
                        ($y == $year) ? $str = $n+1 : $str = 1;
                    } 
                    $pad = str_pad($str,4,"0",STR_PAD_LEFT);
                    $code = 'REG-'.$year.''.$month.'-'.$pad;
                    // -----------------------------------------------------
                    // ------------ Begin Reglement -------- //
                    if($avance>0){
                        $reglement= new Reglement();
                        $reglement->commande_id = $commande->id;
                        $reglement->date = $date;
                        // $reglement->nom_client = Client::find($client)->nom_client ;
                        $reglement->mode_reglement = $mode;
                        $reglement->avance = $avance;
                        $reglement->reste = $reste;
                        $reglement->status = $status;
                        $reglement->code = $code;
                        $reglement->user_id = $user_id;
                        $reglement->save();
                    }
                    // ------------ End Reglement -------- //
                }
                else{
                    return ['status'=>"error",'message'=>"Problème d'enregistrement de la commande !"];
                }
            } 
            else{
                return ['status'=>"error",'message'=>"Veuillez remplir les champs vides !"];
            }
        }
        else {
            return ['status'=>"error",'message'=>"Veuillez d'ajouter des lignes des commandes"];
        }
    
        return ['status'=>"success",'message'=>"La commande a été bien enregistrée !!"];
    }
    // ------------ END STORE COMMANDE ------------------------------
    // ------------ BEGIN SHOW COMMANDE ---------------------------
    public function show($cmd_id){
        $permission = $this->getPermssion(Auth::user()->permission);
        // $companies = Company::get();
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $companies = Company::where('user_id',$user_id)->get();
        $count = count($companies);
        // ($count>0)  ? $company = Company::first(): $company = null;
        ($count>0)  ? $company = Company::where('user_id',$user_id)->first(): $company = null;
        $adresse = $this->getAdresse($company);
        // $adresse = $this->get_siege_tel($company);

        $commande = Commande::with('client')->find($cmd_id);
        $lignecommandes = Lignecommande::with('produit')->where('commande_id', '=', $cmd_id)->get();

        $prix_HT = 0;
        $TVA = 0;
        $priceTotal = 0;
        foreach($lignecommandes as $ligne){
            $prix_HT = $prix_HT +  ($ligne->produit->prix_produit_HT * $ligne->quantite);
            $TVA = $TVA +  ($ligne->produit->prix_produit_HT * $ligne->quantite * $ligne->produit->TVA) ;
            $priceTotal =  floatval($priceTotal  + $ligne->total_produit) ;
        }
        return view('managements.commandes.show', [
            'cmd_id' =>  $cmd_id, 
            'commande' =>  $commande, 
            'lignecommandes' =>  $lignecommandes,
            'priceTotal'  => $priceTotal,
            'prix_HT' => $prix_HT,
            'TVA' => $TVA,
            'company' => $company,
            'adresse' => $adresse,
            'permission' => $permission,
        ]);
    }
    // ------------ END SHOW COMMANDE ------------------------------
    // ------------ BEGIN EDIT COMMANDE ---------------------------
    public function edit($id){
        // $commande = Commande::with(['client','reglements'])->where('user_id',Auth::user()->id)->find($id);
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $commande = Commande::with(['client','reglements'])->where('user_id',$user_id)->findOrFail($id);
        $date = Carbon::now();
        // $clients = Client::get();
        // $categories=Categorie::all();
        $clients = Client::where('user_id',$user_id)->get();
        $categories=Categorie::where('user_id',$user_id)->get();
        $permission = $this->getPermssion(Auth::user()->permission);
        if(in_array('edit4',$permission) || Auth::user()->is_admin == 2)
        return view('managements.commandes.edit', [
            'commande' =>$commande,
            'clients' =>$clients,
            'date' =>$date,
            'categories' =>$categories,
        ]);
        else
        return redirect()->back();
    }
    // ------------ END EDIT COMMANDE ------------------------------
    // ------------ BEGIN UPDATE COMMANDE ---------------------------
    public function update(Request $request){ 
        // $id = $request->input('id');
        // return ['status'=>"error",'message'=>$id];
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $lignes = $request->input('lignes');
        if(!empty($lignes)){
            $id = $request->input('id');
            $date = $request->input('date');
            $client = $request->input('client');
            $gauche = $request->input('gauche');
            $droite = $request->input('droite');


            $reglements = $request->input('reglements');
            $count_reglements = $request->input('count_reglements');
            $cmd_avance = $request->input('cmd_avance');
            $cmd_total = $request->input('cmd_total');
            $cmd_reste = $request->input('cmd_reste');

            if(!empty($date) && !empty($client)){
                // ------------ Begin Commande -------- //
                $commande = Commande::find($id);
                $commande->date = $date;
                $commande->client_id = $client;
                // $commande->nom_client = Client::find($client)->nom_client;
                $commande->oeil_gauche = $gauche;
                $commande->oeil_droite = $droite;
                $commande->facture = "nf"; 

                $commande->avance = $cmd_avance;
                $commande->reste = $cmd_reste;
                $commande->total = $cmd_total;
                $commande->user_id = $user_id;
                $commande->save();
                // ------------ End Commande -------- //
                if($commande->id){
                    // ------------ Begin LigneCommande -------- //
                    $lignecommandes = Lignecommande::where('commande_id',$id)->get();
                    foreach ($lignecommandes as $ligne) {
                        $ligne->delete();
                    }
                    foreach ($lignes as $ligne) {
                        $lignecommande = new Lignecommande();
                        $lignecommande->commande_id = $id;
                        $lignecommande->produit_id = $ligne['prod_id'];
                        // $lignecommande->nom_produit = $ligne['libelle'];
                        $lignecommande->quantite = $ligne['qte'];
                        $lignecommande->total_produit = $ligne['total'];
                        $lignecommande->user_id = $user_id;
                        $lignecommande->save();
                    }
                    // ------------ End LigneCommande -------- //
                    // ------------ Begin Reglement -------- //
                    if($count_reglements>0){
                        foreach ($reglements as $reg) {
                            $reglement = reglement::find($reg['reg_id']);
                            $reglement->reste = $reg['reste'];
                            $reglement->status = $reg['status'];
                            $reglement->user_id = $user_id;
                            $reglement->save();
                        }
                    }
                    // ------------ End Reglement -------- //
                }
                else{
                    return ['status'=>"error",'message'=>"Problème d'enregistrement de la commande !"];
                }
            } 
            else{
                return ['status'=>"error",'message'=>"Veuillez remplir les champs vides !"];
            }
        }
        else {
            return ['status'=>"error",'message'=>"Veuillez d'ajouter des lignes des commandes"];
        }
        return ['status'=>"success",'message'=>"La commande a été bien modifiée !!"];
    }
    // ------------ END UPDATE COMMANDE ------------------------------
    // ------------ BEGIN DESTROY COMMANDE ---------------------------
    public function destroy($id){
        $commande = Commande::find($id);
        $facture = Facture::where('commande_id','=',$commande->id)->first();
        $reglements = Reglement::where('commande_id','=',$commande->id)->get();
        $lignecommandes = LigneCommande::where('commande_id','=',$commande->id)->get();
        if($lignecommandes->count() != 0){
            foreach ($lignecommandes as $lignecommande) {
                $lignecommande->delete();
            }
        }
        if($reglements->count() != 0){
            foreach ($reglements as $reglement) {
                $reglement->delete();
            }
        }
        if($facture)
            $facture->delete();
        $commande->delete();
        return redirect()->route('commande.index')->with([
            "status" => "La commande, facture et règlement ont été supprimé avec succès!"
        ]);
    }
    // ------------ END DESTROY COMMANDE ------------------------------

    var $commande;

	public function findProductName(Request $request){
        $data=Produit::select('nom_produit','id')->where('categorie_id',$request->id)->take(100)->get();
        return response()->json($data);//then sent this data to ajax success
	}


	

    public function findPrice(Request $request){

        $produit=Produit::where('id',$request->id)->first();

        return response()->json($produit);
    }


    public function affiche(){  //index commande

        $commandes = Commande::orderBy('id', 'desc')->paginate(3);
        return view('managements.commandes.affiche', compact('commandes'));
    }
    


    public function storeL(Request $request)
    {
        //     $commande =Commande::where('id','=', $request->input('commande_id'))->first();
            
        //     $lignecommandes = Lignecommande::where('commande_id', '=', $commande->id)->get();
        //      dd($lignecommandes->count());
        
        $lignecommande = new Lignecommande();
        $lignecommande->commande_id = $request->input('commande_id');
        $lignecommande->produit_id = $request->input('prod_id');
        $lignecommande->quantite = $request->input('quantite');
        
        $lignecommande->nom_produit = $request->input('nom_produit');
        $lignecommande->total_produit = $request->input('amount');
        
        
        $lignecommande->save();
        
        $commande =Commande::where('id','=', $request->input('commande_id'))->first();
        $lignecommandes = Lignecommande::where('commande_id', '=', $commande->id)->get();
        // dd($lignecommandes->count());

            if($lignecommandes->count() == 1){
                
            $request->session()->flash('status','la ligne de commande a été bien enregistré ! veuillez valider  la facture de la commande N°' .$lignecommande->commande_id) ;
              return redirect()->route('commande.index');
            }
            
            else{
                
                $request->session()->flash('status','la ligne de commande a été bien enregistré ! veuillez modifier  la facture de la commande N°' .$lignecommande->commande_id) ;
                return redirect()->route('facture.index');
   
        }
       
         }

        //  public function storeLP(Request $request)

        //  {  
   
        //     $lignecommande = new Lignecommande();
        //     $lignecommande->commande_id = $request->input('commande_id');
        //     $lignecommande->produit_id = $request->input('produit_id');
        //     $lignecommande->nom_produit = $request->input('nom_produit');
        //     $lignecommande->quantite = $request->input('qt');
        //     $lignecommande->total_produit = $request->input('ttc');
        
    
          
           
        
        //     $lignecommande->save();

            
   
          
        //  }
         public function storeLR(Request $request)

         { $reglement= new Reglement();
            // $reglement->commande_id = $request->commande_id;
            $reglement->commande_id = $request->input('commande_id');
            // $reglement->nom_client = $request->input('nom_client');
            $reglement->mode_reglement = $request->input('mode_reglement');
            $reglement->avance = $request->input('avc');
            $reglement->reste = $request->input('rst');
            $reglement->date = $request->input('date');
            $reglement->status = $request->input('reglement');
    // dd($reglement->commande_id);
            $reglement->save();
            $request->session()->flash('status','le réglement a été bien enregistré !');
            return redirect()->route('reglement.index');
        }

    public function editL(Lignecommande $lignecommande)
    {
        $Produitligne = Produit::where('id','=', $lignecommande->produit_id)->get();
        foreach($Produitligne as $var)
        {   

            $name = $var->nom_produit;
            $tva =  $var->TVA;
            $pu = $var->prix_produit_HT;
        } 
    
        return view('managements.commandes.editL', [

            "lignecommande" => $lignecommande,
            "tva" => $tva,
            "pu" => $pu,
            "nom" => $name
        ]);
    }



    public function updateL(Request $request, Lignecommande $lignecommande)
    {
        $lignecommande->commande_id = $request->input('commande_id');
        $lignecommande->produit_id = $request->input('produit_id');
        $lignecommande->quantite = $request->input('quantite');
    
       $lignecommande->nom_produit = $request->input('nom_produit');
       $lignecommande->total_produit = $request->input('amount');
 
    
        $lignecommande->save();

        // $facture =Facture::where('commande_id', '=', $lignecommande->commande_id)->get();

    //    dd($facture);
     
    $request->session()->flash('status','la ligne de commande a été bien modifié ! veuillez modifier la facture de la commande N°'.$lignecommande->commande_id);
        return redirect()->route('facture.index');
       

    }
    // {-------START---------}
    public function savecmd(){
        $this->commande->save();

        $lastOne = DB::table('commandes')->latest('id')->first();
    }
    // {---------END-------}

    public function search(Request $request){
        $q = $request->input('q');

     $commandes =  Commande::where('nom_client', 'like', "%$q%")
         ->orWhere('id', 'like', "%$q%")
         ->paginate(5);

         return view('managements.commandes.search')->with('commandes', $commandes);  
      
      }

    


    public function reglement()
    {
        return view('managements.commandes.reglement');
    }

    

    public function storefacture( Request $request)
    {
        // $validateData = $request->validate([
        //     'total_HT' => 'required',
        //     'total_TVA ' => 'required',
        //     'total_TTC' => 'required' ,
        //     'commande_id ' => 'required|unique:factures,commande_id',
        //     'clients_id' => 'required|min:4|max:100' 
        // ]);

        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $facture = new Facture();
            $factures = Facture::where('commande_id','=',$request->input('commande_id'))->get();
            if($factures->count()>0)
                $msg= "La commande é été déja facturée! ";
            else{
                // dd('ok');
                $facture->total_HT = $request->input('total_HT');
                $facture->total_TVA = $request->input('total_TVA');
                $facture->total_TTC = $request->input('total_TTC');
                $facture->commande_id = $request->input('commande_id');
                // $facture->clients_id = $request->input('client_id');
                $facture->reglement = $request->input('reglement');
                $facture->user_id = $user_id;
                $facture->save();
                $msg= "la facture a été bien enregistré vous devez ajouter le règlement de la commande N° .$facture->command_id ";
            }
            
            return redirect()->route('commande.index')->with([
                "status" => $msg
            ]); 

            
    }
    
    public function updateF(Request $request, Facture $facture)
    {
        $facture->total_HT = $request->input('total_HT');
        $facture->total_TVA = $request->input('total_TVA');
        $facture->total_TTC = $request->input('total_TTC');
        $facture->commande_id = $request->input('commande_id');
        $facture->clients_id = $request->input('client_id');
        $facture->reglement = $request->input('reglement');
        
        dd($facture);
        $facture->save();

        return redirect()->route('facture.index')->with([
            "status" => "la facture a été bien enregistré !!"
        ]); 
    }

    // ########################################################################
    

    public function editCommande(Request $request){
        $lignecommandes = Lignecommande::with('produit')->where('commande_id',$request->id)->get();
        $reglement = reglement::where('commande_id',$request->id)->first();

        return [
            'lignecommandes'=>$lignecommandes,
            'reglement'=>$reglement,
        ];
    }

    public function index22(Request $request){
        $commandes = Commande::get();
        $lignecommandes = Lignecommande::get();
        $reglements = reglement::get();
        $clients = Client::get();
        return view('managements.commandes.index22', [
            'commandes'=>$commandes,
            'lignecommandes'=>$lignecommandes,
            'reglements'=>$reglements,
            'clients' =>$clients,
        ]);
    }

    public function index222(Request $request){
        $commandes = Commande::get();
        $lignecommandes = Lignecommande::get();
        $reglements = reglement::get();
        $clients = Client::get();
        return view('managements.commandes.index222', [
            'commandes'=>$commandes,
            'lignecommandes'=>$lignecommandes,
            'reglements'=>$reglements,
            'clients' =>$clients,
        ]);
    }

    ##################################################################################################

    //get commandes pour la page commande
    public function getCommandes(Request $request){
        $search = $request->search;
        $client = $request->client;
        if($search){
            if($search == "f" || $search == "nf")
                $commandes = Commande::where('facture',$request->search)->get();
            else if($search == "r")
                $commandes = Commande::where('reste','<=',0)->get();
            else if($search == "nr")
                $commandes = Commande::where('reste','>',0)->get();
        }
        else if($client)
            $commandes = Commande::where('client_id',$request->client)->get();
        else
            $commandes = Commande::get();
        $lignecommandes = Lignecommande::get();
        $reglements = reglement::get();
        $clients = Client::get();
        return response()->json([
            'commandes'=>$commandes,
            'lignecommandes'=>$lignecommandes,
            'reglements'=>$reglements,
            'clients' =>$clients,
        ]);
    }

    //get commandes v2 pour la page commande
    public function getCommandes2(Request $request){
        // ------------------------------------
        $facture = $request->facture;//f - nf - all - null
        $status = $request->status;//r - nr - all - null
        $client = $request->client;
        // ------------------------------------
        $r = Commande::where('reste','<=',0);
        $nr = Commande::where('reste','>',0);
        $f = Commande::where('facture','f');
        $nf = Commande::where('facture','nf');
        $fr = Commande::where('facture','f')->where('reste','<=',0);
        $fnr = Commande::where('facture','f')->where('reste','>',0);
        $nfr = Commande::where('facture','nf')->where('reste','<=',0);
        $nfnr = Commande::where('facture','nf')->where('reste','>',0);
        if($client){
            if(!$facture && !$status)  //echo '[]';
                $commandes = [];
            else if((!$facture && $status=='r') || ($facture=='all' && $status=='r'))  //echo 'r';
                $commandes = $r->where('client_id',$client)->get();
            else if((!$facture && $status=='nr') || ($facture=='all' && $status=='nr'))  //echo 'nr';
                $commandes = $nr->where('client_id',$client)->get();
            else if((!$facture && $status=='all') || ($facture=='all' && !$status) || ($facture=='all' && $status=='all')) //echo 'all';
                $commandes = Commande::where('client_id',$client)->get();
            else if(($facture=='f' && !$status) || ($facture=='f' && $status=='all')) //echo 'f';
                $commandes = $f->where('client_id',$client)->get();
            else if($facture=='f' && $status=='r') //echo 'fr';
                $commandes = $fr->where('client_id',$client)->get();
            else if($facture=='f' && $status=='nr') //echo 'fnr';
                $commandes = $fnr->where('client_id',$client)->get();
            else if(($facture=='nf' && !$status) || ($facture=='nf' && $status=='all')) //echo 'nf';
                $commandes = $nf->where('client_id',$client)->get();
            else if($facture==' nf' && $status=='r') //echo 'nfr';
                $commandes = $nfr->where('client_id',$client)->get();
            else if($facture=='nf' && $status=='nr') //echo 'nfnr';
                $commandes = $nfnr->where('client_id',$client)->get();
            else //echo '[]';
                $commandes = [];
        }
        else{
            if(!$facture && !$status)  //echo '[]';
                $commandes = [];
            else if((!$facture && $status=='r') || ($facture=='all' && $status=='r'))  //echo 'r';
                $commandes = $r->get();
            else if((!$facture && $status=='nr') || ($facture=='all' && $status=='nr'))  //echo 'nr';
                $commandes = $nr->get();
            else if((!$facture && $status=='all') || ($facture=='all' && !$status) || ($facture=='all' && $status=='all')) //echo 'all';
                $commandes = Commande::get();
            else if(($facture=='f' && !$status) || ($facture=='f' && $status=='all')) //echo 'f';
                $commandes = $f->get();
            else if($facture=='f' && $status=='r') //echo 'fr';
                $commandes = $fr->get();
            else if($facture=='f' && $status=='nr') //echo 'fnr';
                $commandes = $fnr->get();
            else if(($facture=='nf' && !$status) || ($facture=='nf' && $status=='all')) //echo 'nf';
                $commandes = $nf->get();
            else if($facture==' nf' && $status=='r') //echo 'nfr';
                $commandes = $nfr->get();
            else if($facture=='nf' && $status=='nr') //echo 'nfnr';
                $commandes = $nfnr->get();
            else //echo '[]';
                $commandes = [];
        }
        // ------------------------------------
        return response()->json($commandes);
    }

    //get commandes v2 pour la page commande
    public function getCommandes5(Request $request){

        // ------------------------------------
        $facture = $request->facture;//f - nf - all - null
        $status = $request->status;//r - nr - all - null
        $client = $request->client;
        $search = $request->search;//f - nf - all - null
        // ------------------------------------
        // ------------------------------------
        // $r = Commande::with(['client','reglements'])->where('reste','<=',0)->orderBy('id','desc');
        // $nr = Commande::with(['client','reglements'])->where('reste','>',0)->orderBy('id','desc');
        // $f = Commande::with(['client','reglements'])->where('facture','f')->orderBy('id','desc');
        // $nf = Commande::with(['client','reglements'])->where('facture','nf')->orderBy('id','desc');
        // $fr = Commande::with(['client','reglements'])->where('facture','f')->where('reste','<=',0)->orderBy('id','desc');
        // $fnr = Commande::with(['client','reglements'])->where('facture','f')->where('reste','>',0)->orderBy('id','desc');
        // $nfr = Commande::with(['client','reglements'])->where('facture','nf')->where('reste','<=',0)->orderBy('id','desc');
        // $nfnr = Commande::with(['client','reglements'])->where('facture','nf')->where('reste','>',0)->orderBy('id','desc');
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $r = Commande::with(['client','reglements'])->where('reste','<=',0)->orderBy('id','desc')->where('user_id',$user_id);
        $nr = Commande::with(['client','reglements'])->where('reste','>',0)->orderBy('id','desc')->where('user_id',$user_id);
        $f = Commande::with(['client','reglements'])->where('facture','f')->orderBy('id','desc')->where('user_id',$user_id);
        $nf = Commande::with(['client','reglements'])->where('facture','nf')->orderBy('id','desc')->where('user_id',$user_id);
        $fr = Commande::with(['client','reglements'])->where('facture','f')->where('reste','<=',0)->orderBy('id','desc')->where('user_id',$user_id);
        $fnr = Commande::with(['client','reglements'])->where('facture','f')->where('reste','>',0)->orderBy('id','desc')->where('user_id',$user_id);
        $nfr = Commande::with(['client','reglements'])->where('facture','nf')->where('reste','<=',0)->orderBy('id','desc')->where('user_id',$user_id);
        $nfnr = Commande::with(['client','reglements'])->where('facture','nf')->where('reste','>',0)->orderBy('id','desc')->where('user_id',$user_id);
        if($search){
            // $commandes = Commande::with(['client','reglements'])
            //     ->where('code','like','%'.$search.'%')
            //     // ->orWhere('nom_client','like','%'.$search.'%')
            //     ->orWhereHas('client', function($query) use ($search)  {
            //         $query->where('nom_client','like','%'.$search.'%');
            //     })
            //     ->orWhere('date','like','%'.$search.'%')
            //     ->orWhere('date','like','%'.$search.'%')
            //     ->orWhere('total','like','%'.$search.'%')
            //     ->orWhere('avance','like','%'.$search.'%')
            //     ->orWhere('reste','like','%'.$search.'%')
            //     ->orderBy('id','desc')
            //     ->get(); 
            $commandes = Commande::with(['client','reglements'])
                ->where([
                    [function ($query) use ($search) {
                        $query->where('code','like','%'.$search.'%')
                        ->orWhere('date','like','%'.$search.'%')
                        ->orWhere('total','like','%'.$search.'%')
                        ->orWhere('avance','like','%'.$search.'%')
                        ->orWhere('reste','like','%'.$search.'%');
                    }],
                    ['user_id',$user_id]
                ])
            ->orWhereHas('client', function($query) use ($search,$user_id)  {
                $query->where([['nom_client','like','%'.$search.'%'],['user_id',$user_id]]);
            })
            ->orderBy('id','desc')
            ->get();
        }
        else{
            if($client){
                if(!$facture && !$status)  //echo '[]';
                    $commandes = [];
                else if((!$facture && $status=='r') || ($facture=='all' && $status=='r'))  //echo 'r';
                    $commandes = $r->where('client_id',$client)->get();
                else if((!$facture && $status=='nr') || ($facture=='all' && $status=='nr'))  //echo 'nr';
                    $commandes = $nr->where('client_id',$client)->get();
                else if((!$facture && $status=='all') || ($facture=='all' && !$status) || ($facture=='all' && $status=='all')) //echo 'all';
                    $commandes = Commande::with(['client','reglements'])->where('client_id',$client)->orderBy('id','desc')->where('user_id',$user_id)->get();
                else if(($facture=='f' && !$status) || ($facture=='f' && $status=='all')) //echo 'f';
                    $commandes = $f->where('client_id',$client)->get();
                else if($facture=='f' && $status=='r') //echo 'fr';
                    $commandes = $fr->where('client_id',$client)->get();
                else if($facture=='f' && $status=='nr') //echo 'fnr';
                    $commandes = $fnr->where('client_id',$client)->get();
                else if(($facture=='nf' && !$status) || ($facture=='nf' && $status=='all')) //echo 'nf';
                    $commandes = $nf->where('client_id',$client)->get();
                else if($facture==' nf' && $status=='r') //echo 'nfr';
                    $commandes = $nfr->where('client_id',$client)->get();
                else if($facture=='nf' && $status=='nr') //echo 'nfnr';
                    $commandes = $nfnr->where('client_id',$client)->get();
                else //echo '[]';
                    $commandes = [];
            }
            else{
                if(!$facture && !$status)  //echo '[]';
                    $commandes = [];
                else if((!$facture && $status=='r') || ($facture=='all' && $status=='r'))  //echo 'r';
                    $commandes = $r->get();
                else if((!$facture && $status=='nr') || ($facture=='all' && $status=='nr'))  //echo 'nr';
                    $commandes = $nr->get();
                else if((!$facture && $status=='all') || ($facture=='all' && !$status) || ($facture=='all' && $status=='all')) //echo 'all';
                    $commandes = Commande::with(['client','reglements'])->orderBy('id','desc')->where('user_id',$user_id)->get();
                else if(($facture=='f' && !$status) || ($facture=='f' && $status=='all')) //echo 'f';
                    $commandes = $f->get();
                else if($facture=='f' && $status=='r') //echo 'fr';
                    $commandes = $fr->get();
                else if($facture=='f' && $status=='nr') //echo 'fnr';
                    $commandes = $fnr->get();
                else if(($facture=='nf' && !$status) || ($facture=='nf' && $status=='all')) //echo 'nf';
                    $commandes = $nf->get();
                else if($facture==' nf' && $status=='r') //echo 'nfr';
                    $commandes = $nfr->get();
                else if($facture=='nf' && $status=='nr') //echo 'nfnr';
                    $commandes = $nfnr->get();
                else //echo '[]';
                    $commandes = [];
            }
        }
        
        // ------------------------------------
        return response()->json($commandes);
    }

    public function productsCategory(Request $request){
        $data=Produit::select('id','code_produit','nom_produit','prix_produit_TTC')->where('categorie_id',$request->id)->get();
        return response()->json($data);
	}

    public function infosProducts(Request $request){
        $data=Produit::find($request->id);
        return response()->json($data);
	}


    // ------- Create a facture ------- //
    public function facture2(Request $request){
        $companies = Company::get();
        $count = count($companies);
        ($count>0)  ? $company = Company::first(): $company = null;
        $adresse = $this->getAdresse($company);

        $datetime = Carbon::now();
        $date = $datetime->isoFormat('YYYY-MM-DD');
        $year = $datetime->isoFormat('YY');
        $month = $datetime->isoFormat('MM');
        // -------- test la date -------- //
        // $time = strtotime('02/16/2023');
        // $date = date('Y-m-d',$time);
        // $year = date('y',$time);
        // $month = date('m',$time);
        // ---------------------        
        $count = Facture::get();
        (count($count)>0) ? $lastcode = Facture::get()->last()->code : $lastcode = null;
        $str = 1;
        if(isset($lastcode)){
            $list = explode("-",$lastcode);
            // $f = $list[0];
            $y = substr($list[1],0,2);
            // $m = substr($list[1],2,2);
            $n = $list[2];
            ($y == $year) ? $str = $n+1 : $str = 1;
        } 
        $pad = str_pad($str,4,"0",STR_PAD_LEFT);
        $code = 'FA-'.$year.''.$month.'-'.$pad;
        // ---------------------        

        $cmd_id = $request->commande;
        $commande = Commande::with('client')->find($cmd_id);
        $lignecommandes = Lignecommande::with('produit')->where('commande_id', '=', $cmd_id)->get();
        $prix_HT = 0;
        $TVA = 0;
        $priceTotal = 0;
        foreach($lignecommandes as $ligne){
            $prix_HT = $prix_HT +  ($ligne->produit->prix_produit_HT * $ligne->quantite);
            $TVA = $TVA +  ($ligne->produit->prix_produit_HT * $ligne->quantite * $ligne->produit->TVA) ;
            $priceTotal =  floatval($priceTotal  + $ligne->total_produit) ;
        }
        return view('managements.commandes.facture2', [
            'cmd_id' =>  $cmd_id, 
            'date' =>  $date, 
            'year' =>  $year, 
            'month' =>  $month, 
            'code' =>  $code, 
            'lignecommandes' =>  $lignecommandes,
            'priceTotal'  => $priceTotal,
            'prix_HT' => $prix_HT,
            'TVA' => $TVA,
            'commande' => $commande,
            'company' => $company,
            'count' => $count,
            'adresse' => $adresse
        ]);
    }

    public function facture(Request $request){
        $datetime = Carbon::now();
        $date = $datetime->isoFormat('YYYY-MM-DD');
        $year = $datetime->isoFormat('YY');
        $month = $datetime->isoFormat('MM');
        // -------- test la date -------- //
        // $time = strtotime('02/16/2023');
        // $date = date('Y-m-d',$time);
        // $year = date('y',$time);
        // $month = date('m',$time);
        // ---------------------        
        // $factures = Facture::where('code', 'like', "FA-$year%")->get();
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $factures = Facture::where('code', 'like', "FA-$year%")->where('user_id',$user_id)->get();
        // (count($factures)>0) ? $fcode = Facture::get()->last()->code : $fcode = null;
        // ---------------------------------------
        if(count($factures)>0) {
            $tab=array();
            foreach ($factures as $key=>$facture) {
                $fcode = $facture->code;
                $list = explode("-",$fcode);
                $n = $list[2];
                array_push($tab,$n);
            }
            $index = -1;
            foreach ($factures as $key=>$facture) {
                $fcode = $facture->code;
                $list = explode("-",$fcode);
                $n = $list[2];
                if(max($tab) == $n){
                    $index = $key;
                    break;
                }
            }
            $fcode =  $factures[$index]->code;
        } 
        else {
            $fcode = null;
        }
        // ---------------------------------------
        $str = 1;
        if(isset($fcode)){
            $list = explode("-",$fcode);
            // $f = $list[0];
            $y = substr($list[1],0,2);
            // $m = substr($list[1],2,2);
            $n = $list[2];
            ($y == $year) ? $str = $n+1 : $str = 1;
        } 
        $pad = str_pad($str,4,"0",STR_PAD_LEFT);
        $code = 'FA-'.$year.''.$month.'-'.$pad;
        // ---------------------        

        $cmd_id = $request->commande;
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
        $user_id = Auth::user()->user_id;
        $commande = Commande::with('client')->where('user_id',$user_id)->findOrFail($cmd_id);
        $lignecommandes = Lignecommande::with('produit')->where('commande_id', '=', $cmd_id)->get();
        $HT = 0;
        $TTC = 0;
        // foreach($lignecommandes as $ligne){
        //     $prix_HT = $prix_HT +  ($ligne->produit->prix_produit_HT * $ligne->quantite);
        //     $TVA = $TVA +  ($ligne->produit->prix_produit_HT * $ligne->quantite * $ligne->produit->TVA) ;
        //     $priceTotal =  floatval($priceTotal  + $ligne->total_produit) ;
        // }
        foreach($lignecommandes as $ligne){
            $HT += $ligne->total_produit / (1 + $ligne->produit->TVA/100);
            $TTC += $ligne->total_produit;
        }

        $TVA = $TTC - $HT;
        $permission = $this->getPermssion(Auth::user()->permission);
        if(in_array('create6',$permission) || Auth::user()->is_admin == 2)
        return view('managements.commandes.facture', [
            'cmd_id' =>  $cmd_id, 
            'date' =>  $date, 
            'year' =>  $year, 
            'month' =>  $month, 
            'code' =>  $code, 
            'lignecommandes' =>  $lignecommandes,
            'TTC'  => $TTC,
            'HT' => $HT,
            'TVA' => $TVA,
            'commande' => $commande,
            // 'factures' => $factures,
        ]);
        else
        return redirect()->back();
    }

    public function storefacture2( Request $request){
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $cmd_id = $request->input('commande_id');
        $factures = Facture::where('commande_id','=',$cmd_id)->get();
        if($factures->count()>0){
            $msg= "La commande a été déja facturée! ";
        }
        else{
            $code = $request->input('code');
            // $getFactures = Facture::get();
            $getFactures = Facture::where('user_id',$user_id)->get();
            // --------------------------------------
            $list = explode("-",$code);
            $y1 = substr($list[1],0,2);
            $n1 = $list[2];
            $txt1 = $y1.'-'.$n1;
            $existe = false;
            foreach ($getFactures as $key=>$facture) {
                $fcode = $facture->code;
                $list = explode("-",$fcode);
                $y2 = substr($list[1],0,2);
                $n2 = $list[2];
                $txt2 = $y2.'-'.$n2;
                if($txt1 == $txt2){
                    $existe = true;
                    break;
                }
            }
            // --------------------------------------
            // $codeFactures = Facture::where('code',$code)->get();
            // if($codeFactures->count()>0){
            if($existe){
                $msg= "Le code de la facture existe déja ! ";
            }
            else{
                $facture = new Facture();
                $facture->total_HT = $request->input('total_HT');
                $facture->total_TVA = $request->input('total_TVA');
                $facture->total_TTC = $request->input('total_TTC');
                $facture->commande_id = $request->input('commande_id');
                $facture->reglement = $request->input('reglement');
                $facture->date = $request->input('date');
                $facture->code = $code;
                $facture->user_id = $user_id;
                $facture->save();
                $msg= "La facture a été bien enregistrée";
                if($facture->id){
                    $commande = Commande::find($facture->commande_id);
                    $commande->facture = "f";
                    $commande->user_id = $user_id;
                    $commande->save();
                }
            }
        }
        return redirect()->route('commande.index')->with([
            "status" => $msg
        ]); 
    }

    

    public function getAdresse($company){
        // ############################################################### //
        // Siège social : ITIC SOLUTION - 3 ,immeuble Karoum, Av Alkhansaa, Cité Azmani , 83350 , OULED TEIMA , MAROC<br>
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
        // Capital : 100000 - ICE : 123456789012345  - I.F. : 12345678 - <br>
        $adresse2 = '';
        // ############################################################### //
        ($company && ($company->capital || $company->capital != null)) ? $adresse2 .= 'Capital : '.$company->capital.' - ' : $adresse2 .= '';
        // -------------------------------------//
        ($company && ($company->ice || $company->ice != null)) ? $adresse2 .= 'ICE : '.$company->ice.' - ' : $adresse2 .= '';
        // -------------------------------------//
        ($company && ($company->iff || $company->iff != null)) ? $adresse2 .= 'I.F. : '.$company->iff.' - ' : $adresse2 .= '';
        // ############################################################### //
        // R.C. : 1234 -Patente : 12345678 - CNSS : 87654321 <br>
        $adresse3 = '';
        // ############################################################### //
        ($company && ($company->rc || $company->rc != null)) ? $adresse3 .= 'R.C. : '.$company->rc.' - ' : $adresse3 .= '';
        // -------------------------------------//
        ($company && ($company->patente || $company->patente != null)) ? $adresse3 .= 'Patente : '.$company->patente.' - ' : $adresse3 .= '';
        // -------------------------------------//
        ($company && ($company->cnss || $company->cnss != null)) ? $adresse3 .= 'CNSS : '.$company->cnss.' - ' : $adresse3 .= '';
        // ############################################################### //
        // Tél : 0857854354 - site : https://itic-solution.com/ - email : Contact@itic-solution.com<br>
        $adresse4 = '';
        // ############################################################### //
        ($company && ($company->tel || $company->tel != null)) ? $adresse4 .= 'Tél : '.$company->tel.' - ' : $adresse4 .= '';
        // -------------------------------------//
        ($company && ($company->site || $company->site != null)) ? $adresse4 .= 'Site : '.$company->site.' - ' : $adresse4 .= '';
        // -------------------------------------//
        ($company && ($company->email || $company->email != null)) ? $adresse4 .= 'Email : '.$company->email.' - ' : $adresse4 .= '';
        // ############################################################### //
        // BANQUE : BMCE - RIB : 12345678912345<br>
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

    public function get_siege_tel($company){
        // ############################################################### //
        // Siège social : ITIC SOLUTION - 3 ,immeuble Karoum, Av Alkhansaa, Cité Azmani , 83350 , OULED TEIMA , MAROC<br>
        $siege = '';
        // ############################################################### //
        ($company && ($company->nom || $company->nom != null)) ? $siege .= 'Siège social : '.$company->nom.' - ' : $siege .= 'Siège social : nom_societé';
        // -------------------------------------//
        ($company && ($company->adresse || $company->adresse != null)) ? $siege .= $company->adresse.' , ' : $siege .= '';
        // -------------------------------------//
        ($company && ($company->code_postal || $company->code_postal != null)) ? $siege .= $company->code_postal.' , ' : $siege .= '';
        // -------------------------------------//
        ($company && ($company->ville || $company->ville != null)) ?  $siege .= $company->ville.' , ' : $siege .= '';
        // -------------------------------------//
        ($company && ($company->pays || $company->pays != null)) ? $siege .= $company->pays : $siege .= '';
        // ############################################################### //
        $tel = '';
        ($company && ($company->tel || $company->tel != null)) ? $tel .= 'Tél : '.$company->tel : $tel .= '';
        // -------------------------------------//
        // ############################################################### //
        $adresse = '';
        if($siege != '')
            $adresse .= $siege.'<br>';
        if($tel != '')
            $adresse .= $tel.'<br>';
        return $adresse;
    }

    public function codeFacture(Request $request){
        // $datetime = Carbon::now();
        // $date = $datetime->isoFormat('YYYY-MM-DD');
        // $year = $datetime->isoFormat('YY');
        // $month = $datetime->isoFormat('MM');
        // -------- test la date -------- //
        // $time = strtotime('02/16/2023');
        $time = strtotime($request->date);
        $date = date('Y-m-d',$time);
        $year = date('y',$time);
        $month = date('m',$time);
        // ---------------------  
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;      
        $factures = Facture::where('code', 'like', "FA-$year%")->where('user_id',$user_id)->get();
        // (count($count)>0) ? $lastcode = Facture::get()->last()->code : $lastcode = null;
        // ---------------------------------------
        if(count($factures)>0) {
            $tab=array();
            foreach ($factures as $key=>$facture) {
                $fcode = $facture->code;
                $list = explode("-",$fcode);
                $n = $list[2];
                array_push($tab,$n);
            }
            $index = -1;
            foreach ($factures as $key=>$facture) {
                $fcode = $facture->code;
                $list = explode("-",$fcode);
                $n = $list[2];
                if(max($tab) == $n){
                    $index = $key;
                    break;
                }
            }
            $fcode =  $factures[$index]->code;
        } 
        else {
            $fcode = null;
        }
        // ---------------------------------------
        $str = 1;
        if(isset($fcode)){
            $list = explode("-",$fcode);
            // $f = $list[0];
            $y = substr($list[1],0,2);
            // $m = substr($list[1],2,2);
            $n = $list[2];
            ($y == $year) ? $str = $n+1 : $str = 1;
        } 
        $pad = str_pad($str,4,"0",STR_PAD_LEFT);
        $code = 'FA-'.$year.''.$month.'-'.$pad;

        return $code;
    }

    public function balance(){
        $permission = $this->getPermssion(Auth::user()->permission);
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $companies = Company::where('user_id',$user_id)->get();
        $count = count($companies);
        ($count>0)  ? $company = Company::where('user_id',$user_id)->first(): $company = null;
        $date = Carbon::now();
        if(in_array('list7',$permission) || Auth::user()->is_admin == 2)
        return view('managements.commandes.balance',compact('date','company','permission'));
        else
        return view('application');
    }

    public function getBalance(Request $request){
        // $from = date('2021-08-09');
        // $to = date('2021-08-10');

        $from = $request->from;
        $to = $request->to;

        // $commandes = Commande::with('client')->whereBetween('date', [$from, $to])->get();
        // $reglements = Reglement::with(['commande' => function($query){$query->with('client');}])->whereBetween('date', [$from, $to])->get();
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $commandes = Commande::with('client')
            ->whereBetween('date', [$from, $to])
            ->where('user_id',$user_id)
            ->get();
        $reglements = Reglement::with(['commande' => function($query){$query->with('client');}])
            ->whereBetween('date', [$from, $to])
            ->where('user_id',$user_id)
            ->get();
        return compact('commandes','reglements');
    }


    //REMOVE
    public function facture_remove(){
        $lastOne = DB::table('commandes')->latest('id')->first();
        $commande = Commande::with('client')->find($lastOne->id);
        //dd($commande->id);
        // $lignecommandes = lignecommande::orderBy('id');
        $lignecommandes =  Lignecommande::with('produit')->where('commande_id', '=', $lastOne->id)
        ->paginate(100);
        // foreach($lignecommandes as $ligne){
        // //   $produit = Produit::where('id', '=' , $ligne->produit_id)->first();
        //     dump($ligne->produit->prix_produit_HT);
        // }
        $prix_HT = 0;
        foreach($lignecommandes as $q){
           $prix_HT = $prix_HT +  ($q->produit->prix_produit_HT * $q->quantite);
            $q->nom_produit = $q->produit->nom_produit;  
        }

    
        $TVA = 0;
        foreach($lignecommandes as $q){
        
           $TVA = $TVA +  ($q->produit->prix_produit_HT * $q->quantite * $q->produit->TVA) ;
        }

    
        $priceTotal = 0;
        foreach($lignecommandes as $p){
            $priceTotal =  floatval($priceTotal  + $p->total_produit) ;
        
        }
        return view('managements.commandes.facture_remove', [

            'lastOne' =>  $lastOne, 
            'lignecommandes' =>  $lignecommandes,
            'priceTotal'  => $priceTotal,
            'prix_HT' => $prix_HT,
            'TVA' => $TVA,
            'commande' => $commande
        ]);
    }
//-------------------
}
