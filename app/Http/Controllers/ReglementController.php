<?php

namespace App\Http\Controllers;

use App\Client;
use App\Commande;
use App\Reglement;
use App\Company;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class ReglementController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $reglements = Reglement::orderBy('id','desc')->paginate(3);
        
        // $clients = Commande::where('id', '=', $reglements->$commande_id);
        
        // dd($clients);     
        // return view('managements.reglements.index', compact('reglements','nom_client'));
        return view('managements.reglements.index', compact('reglements'));
    }

    public function search(Request $request){
        $q = $request->input('q');

        //  $reglements =  Reglement::where('nom_client', 'like', "%$q%")
        $reglements =  Reglement::paginate(5);

        return view('managements.reglements.search')->with('reglements');  
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function show_remove(Reglement $reglement)
    {
        // $commande= Commande::with('client')->where('id',$reglement->commande_id )->first();
        $commande= Commande::with('client')->find($reglement->commande_id);

        // dd($commande->client);
        return view('managements.reglements.show', [
        
            'commande' => $commande,
            'reglement' => $reglement

        ]);
    }

    
    public function edit(Reglement $reglement)
    {
        return view('managements.reglements.edit')->with([
            "reglement" => $reglement,
            'clients' => Client::all()
        ]);
    }

    
    public function update(Request $request, Reglement $reglement)
    {
    
        // $reglement->nom_client= $request->input('nom_client');
        $reglement->mode_reglement = $request->input('mode_reglement');
        $reglement->avance = $request->input('avance');
        $reglement->reste = $request->input('reste');
        $reglement->date = $request->input('date');
        $reglement->status = $request->input('reglement');
        $reglement->commande_id = $request->input('commande_id');
        

        $reglement->save();
        $request->session()->flash('status','le règlement a été bien modifié !');


        return redirect()->route('reglement.index');

    }

    public function destroy(Reglement $reglement)
    {
        
        $reglement->delete();

        // Post::destroy($id); supression directement

        return redirect()->route('reglement.index')->with([
            "success" => "le réglement a été supprimer avec succès!"
        ]); 
    }

    // *****************************************************
    public function index22(){
        $commandes = Commande::with('reglements')->get();
        $clients = Client::get();
        
        return view('managements.reglements.index22', [
            'commandes' => $commandes,
            'clients'=>$clients
        ]);
    }

    public function index2(){
        $reglements = Reglement::get();
        $clients = Client::get();
        
        return view('managements.reglements.index2', [
            'reglements' => $reglements,
            'clients'=>$clients
        ]);
    }

    public function getReglements(Request $request){
        $client = $request->client;
        $status = $request->status;
        if($client){
            $nom_client = Client::find($client)->nom_client;
            if($status){
                if($status == 'nr'){
                    $reglements = Reglement::with('commande')
                        ->whereHas('commande' , function($query){$query->where('reste', '>', 0);})
                        ->where('nom_client',$nom_client)->get();
                }
                else if($status == 'r'){
                    $reglements = Reglement::with('commande')
                        ->whereHas('commande' , function($query){$query->where('reste', '<=', 0);})
                        ->where('nom_client',$nom_client)->get();
                }
                else if($status == 'all'){
                    $reglements = Reglement::with('commande')->where('nom_client',$nom_client)->get();
                }
            }
            else 
                $reglements = [];
        }
        else{
            if($status){
                if($status == 'nr'){
                    $reglements = Reglement::with('commande')
                            ->whereHas('commande' , function($query){$query->where('reste', '>', 0);})
                        ->get();
                }
                else if($status == 'r'){
                    $reglements = Reglement::with('commande')
                        ->whereHas('commande' , function($query){$query->where('reste', '<=', 0);})
                        ->get();
                }
                else if($status == 'all'){
                    $reglements = Reglement::with('commande')->get();
                }
            }
            else 
                $reglements = [];
        }        
        return response()->json($reglements);
    }

    public function getReglements2(Request $request){
        $client = $request->client;
        $status = $request->status;
        if($client){
            $nom_client = Client::find($client)->nom_client;
            if($status){
                if($status == 'nr'){
                    $commandes = Commande::with(['client','reglements'])
                        ->whereHas('client',function($query) use ($nom_client){
                            $query->where('nom_client',$nom_client);
                        })
                        ->where('reste', '>', 0)
                        ->get();
                }
                else if($status == 'r'){
                    $commandes = Commande::with(['client','reglements'])
                        ->whereHas('client',function($query) use ($nom_client){
                            $query->where('nom_client',$nom_client);
                        })
                        ->where('reste', '<=', 0)
                        ->get();
                }
                else if($status == 'all'){
                    $commandes = Commande::with(['client','reglements'])
                    ->whereHas('client',function($query) use ($nom_client){
                        $query->where('nom_client',$nom_client);
                    })
                    ->get();
                }
            }
            else 
                $commandes = [];
        }
        else{
            if($status){
                if($status == 'nr'){
                    $commandes = Commande::with('reglements')
                        ->where('reste', '>', 0)
                        ->get();
                }
                else if($status == 'r'){
                    $commandes = Commande::with('reglements')
                        ->where('reste', '<=', 0)
                        ->get();
                }
                else if($status == 'all'){
                    $commandes = Commande::with('reglements')->get();
                }
            }
            else 
                $commandes = [];
        }        
        return response()->json($commandes);
    }

    public function getReglements3(Request $request){
        $client = $request->client;
        if($client){
            $nom_client = Client::find($client)->nom_client;
            $commandes = Commande::with(['client','reglements'])
                        ->whereHas('client',function($query) use ($nom_client){
                            $query->where('nom_client',$nom_client);
                        })
                        ->where('reste', '>', 0)
                        ->orderBy('id','desc')
                        ->get();
        }
        else{
            $commandes = Commande::with(['client','reglements'])
                        ->where('reste', '>', 0)
                        ->orderBy('id','desc')
                        ->get();
        }
        return response()->json($commandes);
    }
    
    //regler plusieurs commandes 
    public function create2(Request $request){
        $clients = Client::get();
        $client = $request->client;
        $date = Carbon::now();
        if($client){
            $nom_client = Client::find($client)->nom_client;
            // $commandes = Commande::where('reste', '>', 0)->where('nom_client',$nom_client)->get();
            // $commandes = Commande::where('reste', '>', 0)
            //     ->whereHas('client',function($query) use ($nom_client){
            //         $query->where('nom_client',$nom_client);
            //     })->get();
            // $commandes = Commande::with(['client'=>function($query) use ($nom_client){
            //         $query->where('nom_client',$nom_client);
            //     }])->where('reste', '>', 0)->get();
            // $commandes = Commande::with(['client'=>function($query) use ($nom_client){
            //         $query->where('nom_client',$nom_client);
            //     }])->get();
            $commandes = Commande::with('client')->whereHas('client',function($query) use ($nom_client){
                        $query->where('nom_client',$nom_client);
                    })->where('reste', '>', 0)->get();
        }
        else{
            $commandes = Commande::with('client')->where('reste', '>', 0)->get();
            // $commandes = Commande::with('client')->get();
        }
        return view('managements.reglements.create2',compact('clients','client','commandes','date'));
    }

    //Regler une seule commande
    public function create3(Request $request){
        $commande_id = $request->commande;
        $date = Carbon::now();
        $commande = Commande::with('client')->find($commande_id);
        return view('managements.reglements.create3',compact('commande','date'));
    }

    // Enregistrer plusieurs reglements
    public function store2(Request $request){ 
        $lignes = $request->input('lignes');
        if(!empty($lignes)){
            $date = $request->input('date');
            $client = $request->input('client');
            $mode = $request->input('mode');
            // -----------------------------------------------------
            $time = strtotime($date);
            $year = date('y',$time);
            $month = date('m',$time);
            // -----------------------------------------------------
            if(!empty($date) && !empty($client) && $mode != ""){
                // ------------ Begin reglement -------- //
                foreach ($lignes as $ligne) {
                    $reglement = new Reglement();
                    $reglement->date = $date;
                    // $reglement->nom_client = Client::find($client)->nom_client;
                    $reglement->mode_reglement = $mode;
                    $reglement->avance = $ligne['avance'];
                    $reglement->reste = $ligne['reste'];
                    $reglement->status = $ligne['status'];
                    // -----------------------------------------------------
                    $reglements = Reglement::get();
                    (count($reglements)>0) ? $lastcode = $reglements->last()->code : $lastcode = null;
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
                    $reglement->code = $code;
                    $reglement->commande_id = $ligne['cmd_id'];
                    $reglement->save();
                    
                    $commande = Commande::find($ligne['cmd_id']);
                    $commande->avance = $commande->avance+$ligne['avance'];
                    $commande->reste = $ligne['reste'];
                    $commande->save();
                }
                // ------------ End Reglement -------- //
            } 
            else{
                return ['status'=>"error",'message'=>"Veuillez remplir les champs vides !"];
            }
        }
        else {
            return ['status'=>"error",'message'=>"Veuillez d'ajouter des règlements"];
        }
    
        return ['status'=>"success",'message'=>"Le règlement a été bien enregistré !!"];
    }

    // enregistrer une seule reglement
    public function store3(Request $request){ 
        $lignes = $request->input('lignes');
        if(!empty($lignes)){
            $date = $request->input('date');
            $mode = $request->input('mode');
            // -----------------------------------------------------
            $time = strtotime($date);
            $year = date('y',$time);
            $month = date('m',$time);
            // -----------------------------------------------------
            $reglements = Reglement::get();
            (count($reglements)>0) ? $lastcode = $reglements->last()->code : $lastcode = null;
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
            if(!empty($date) && $mode != ""){
                // ------------ Begin reglement -------- //
                foreach ($lignes as $ligne) {
                    $reglement = new Reglement();
                    $reglement->date = $date;
                    $reglement->mode_reglement = $mode;
                    // $reglement->nom_client = $ligne['client'];
                    $reglement->avance = $ligne['avance'];
                    $reglement->reste = $ligne['reste'];
                    $reglement->status = $ligne['status'];
                    $reglement->code = $code;
                    $reglement->commande_id = $ligne['cmd_id'];
                    $reglement->save();
                    
                    $commande = Commande::find($ligne['cmd_id']);
                    $commande->avance = $commande->avance+$ligne['avance'];
                    $commande->reste = $ligne['reste'];
                    $commande->save();
                }
                // ------------ End Reglement -------- //
            } 
            else{
                return ['status'=>"error",'message'=>"Veuillez remplir les champs vides !"];
            }
        }
        else {
            return ['status'=>"error",'message'=>"Veuillez d'effectuer le règlement"];
        }
    
        return ['status'=>"success",'message'=>"Le règlement a été bien enregistré !!"];
    }

    public function show(Reglement $reglement){
        $companies = Company::get();
        $count = count($companies);
        ($count>0)  ? $company = Company::first(): $company = null;
        $adresse = $this->getAdresse($company);

        $reglement = Reglement::with(['commande' => function($query){$query->with('client');}])->find($reglement->id);
        // return $reglement;
        // return view('managements.reglements.show2', [
        //     'reglement' => $reglement
        // ]);
        // return view('managements.reglements.view1', [
        return view('managements.reglements.show', [
            'reglement' => $reglement,
            'company' => $company,
            'adresse' => $adresse,
        ]);
    }

    public function avoir(Request $request){ 
        $data = $request->input('obj');

        $reg_id = $data['reg_id']; 
        $reg_avance = $data['reg_avance'];
        $reg_reste = $data['reg_reste'];
        $cmd_id = $data['cmd_id'];
        $cmd_avance = $data['cmd_avance'];
        $cmd_reste = $data['cmd_reste'];

        $reglement = Reglement::find($reg_id);
        $reglement->avance = $reg_avance + $reg_reste;
        $reglement->reste = $reg_reste - $reg_reste;
        $reglement->status = 'R';
        $reglement->save();
        $commande = Commande::find($cmd_id);
        $commande->avance = $cmd_avance + $reg_reste;
        $commande->reste = $cmd_reste - $reg_reste;;
        $commande->save();

        return ['status'=>"success",'message'=>"Opération effectuée avec succés !!!"];
    }

    // // Generate PDF
    // public function createPDF() {
    //     // retreive all records from db
    //     $data = Reglement::all();
    //     // $data = ["a","b","c"];
    //     // $data = [];
    //     // return $data;
    //     // share data to view
    //     view()->share('reglement',$data);
    //     // $pdf = PDF::loadView('pdf_view', $data);
    //     // $pdf = PDF::loadView('managements.reglements.view', $data);
    //     $pdf = PDF::loadView('managements.reglements.view2');
    //     // download PDF file with download method
    //     return $pdf->download('pdf_file.pdf');
    // }
    // public function preview()
    // {
    //     $data = array("a","b","c");
    //     // $data = "aa";
    //     // $data = [];
    //     // return $data;
    //     // $data = Reglement::all();
    //     view()->share('reglement',json_encode($data));
    //     return view('managements.reglements.view2');
    //     // return view('preview');
    //     // $pdf = PDF::loadView('managements.reglements.view');    
    //     // return $pdf->download('demo.pdf');
    // }
    // // public function generatePDF()
    // // {
    // //     // $pdf = PDF::loadView('preview');    
    // //     $pdf = PDF::loadView('managements.reglements.view2');    
    // //     return $pdf->download('demo.pdf');
    // // }
    // public function generatePDF($reg_id)
    // {
    //     $reglement = Reglement::with(['commande' => function($query){$query->with('client');}])->find($reg_id);
    //     // return $reglement;
    //     view()->share(['reglement'=>$reglement]);
    //     //Preview
    //     // return view('managements.reglements.view0');
    //     // download PDF file
    //     PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
    //     $pdf = PDF::loadView('managements.reglements.view0')->setPaper('A5', 'landscape');
    //     // PDF::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf');
    //     // ->setWarnings(false)
    //     // ->save('ALUMNI-LIST-AS-OF-'. Carbon::now()
    //     // ->format('d-M-Y') .'.pdf');
    //     return $pdf->download('demo.pdf');
    // }

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

    // public function delete(Reglement $reglement)
    public function delete($id)
    {
        $reglement = Reglement::find($id);
        $commande = Commande::find($reglement->commande_id);
        $commande->avance = $commande->avance - $reglement->avance;
        $commande->reste = $commande->total - $commande->avance;
        $commande->save();
        $reglement->delete();
        $count = $commande->total;
        $reglements = Reglement::where('commande_id',$commande->id)->get();
        foreach ($reglements as $reglement) {
            $reglement->reste = $count - $reglement->avance;
            ($reglement->reste > 0) ? $reglement->status = 'NR' : $reglement->status = ' R' ;
            $count = $reglement->reste;
            $reglement->save();
        }

        return redirect()->route('commande.index')->with([
            "success" => "Le règlement a été supprimé avec succès !"
        ]); 
    }
// ----------------------------
}
