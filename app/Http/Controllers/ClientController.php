<?php

namespace App\Http\Controllers;

use Throwable;
use App\Client;
use App\Commande;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index( Request $request)
    {
        // $clients = Client::withTrashed()->get();
        // $clients = Client::onlyTrashed()->get();
        // return $clients;

        // try{ 
            // -------------------------------------- //
            // if( Auth::user()->id == 1)
            // $clients = DB::connection('mysql')->table('clients')->orderBy('id','desc')->get();
            // elseif( Auth::user()->id == 2)
            // $clients = DB::connection('mysql2')->table('clients')->orderBy('id','desc')->get();
            // dd($clients);
            // $clients = DB::SELECT('select * from clients');
            // $clients = DB::table('clients')->get();
            // $clients = Client::get();
            // dd($clients);
            // -------------------------------------- //
            $clients = Client::orderBy('id','desc')->get();
            return view('managements.clients.index', compact('clients'));
        // }
        // catch(Throwable $e)
        // {
        //     $request->session()->flash('status', $e->getMessage());
        //     return view('error');
        // }
    }

    public function create()
    {
        return view('managements.clients.create');
    }

    
    public function store(Request $request)

    {  
        // $validateData = $request->validate([
        //     'nom_client' => 'required',
        //     'telephone' => 'required',
        //     'adresse' => 'required' ,
        //     'solde' => 'required',
        //     'code' => 'required|min:4|max:100' 
        // ]);
        // --------------------------------------------------
        $clients = Client::withTrashed()->get();
        (count($clients)>0) ? $lastcode = $clients->last()->code : $lastcode = null;
        $str = 1;
        if(isset($lastcode))
            $str = $lastcode+1 ;
        $code = str_pad($str,4,"0",STR_PAD_LEFT);
        // --------------------------------------------------
        $client = new Client();
        $client->nom_client = $request->input('nom_client');
        $client->adresse = $request->input('adresse');
        $client->telephone = $request->input('telephone');
        $client->solde = $request->input('solde');
        $client->code = $code;
        $client->ICE = Str::slug($client->nom_client, '-');
        $client->save();
        $request->session()->flash('status','le client a été bien enregistré !');
        return redirect()->route('client.index');
    }

    public function search(Request $request){
        $q = $request->input('q');
        $clients =  Client::where('nom_client', 'like', "%$q%")
            ->orWhere('code', 'like', "%$q%")
            ->paginate(5);
            return view('managements.clients.search')->with('clients', $clients);  
    }

    
    public function show(Client $client)
    {
        $commandes = Commande::where('client_id', '=', $client->id)->paginate(2);
        $cmd = Commande::where('client_id', '=', $client->id)->get();
        $count = $cmd->count();
        $reste = 0;
        if($count>0){
            foreach ($cmd as $key => $commande) {
                $reste += $commande->reste;
            }
        }

        return view('managements.clients.show')->with([
            'commandes' => $commandes,
            'client' => $client,
            'count' => $count,
            'reste' => $reste
        ]);
    }

    
    public function edit(Client $client)
    {
        return view('managements.clients.edit')->with([
            "client" => $client
        ]);
    }

    
    public function update(Request $request, Client $client)
    {
        // $this->validate($request, [

        //     'code' => 'required|min:4|max:100',     
        //     'nom_client' => 'required',
        //     'telephone' => 'required',
        //     'adresse' => 'required',
        //     'solde' => 'required',

        // ]);

        $client->nom_client = $request->input('nom_client');
        $client->adresse = $request->input('adresse');
        $client->telephone = $request->input('telephone');
        $client->solde = $request->input('solde');
    
        $client->ICE = Str::slug($client->nom_client, '-');
    
        $client->save();

        $request->session()->flash('status','Le client a été bien modifié !');
        return redirect()->route('client.index');

        // return redirect()->route('client.index')->with('status','le client a été bien modifié !');

    }

    
    public function destroy(Client $client)
    {
        $commandes = Commande::where('client_id','=',$client->id)->get();
        if($commandes->count() != 0){
            // foreach ($commandes as $commande) {
            //     $commande->delete();
            // }
            $msg = "Erreur, Le client déja passer une commande !";
        }
        elseif($commandes->count() == 0){
            $client->delete();
            $msg = "Le client a été supprimé avec succès";
        }
        // Post::destroy($id); supression directement
        // return redirect()->route('client.index')->with([
        //     "status" => "le client, ses commandes et reglements  ont été supprimer avec succès!"
        // ]); 
        return redirect()->route('client.index')->with(["status" => $msg]); 
    }

    public function searchClient(Request $request)
    {
        $search = $request->search;
        $clients = Client::where('nom_client','like',"%$search%")
            ->orWhere('code','like',"%$search%")
            ->orWhere('adresse','like',"%$search%")
            ->orWhere('solde','like',"%$search%")
            ->orWhere('telephone','like',"%$search%")
            ->orderBy('id','desc')
            ->get();
        // if( Auth::user()->id == 1)
        // $clients = DB::connection('mysql')->table('clients')->where('nom_client','like',"%$search%")
        //     ->orWhere('code','like',"%$search%")
        //     ->orWhere('adresse','like',"%$search%")
        //     ->orWhere('solde','like',"%$search%")
        //     ->orWhere('telephone','like',"%$search%")
        //     ->orderBy('id','desc')
        //     ->get();
        // elseif( Auth::user()->id == 2)
        // $clients = DB::connection('mysql2')->table('clients')->where('nom_client','like',"%$search%")
        //     ->orWhere('code','like',"%$search%")
        //     ->orWhere('adresse','like',"%$search%")
        //     ->orWhere('solde','like',"%$search%")
        //     ->orWhere('telephone','like',"%$search%")
        //     ->orderBy('id','desc')
        //     ->get();
        return $clients;
    }
    // ---------------------
}
