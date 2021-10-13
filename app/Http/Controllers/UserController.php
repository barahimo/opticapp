<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Client;
use App\Commande;
use App\Company;
use App\Facture;
use App\Http\Middleware\SuperAdmin;
use App\Lignecommande;
use App\Produit;
use App\Reglement;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        // $this->middleware('superAdmin');
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

    public function storePermssion(Request $request)
    {
        $permission1 = $request['permission1'];
        $permission2 = $request['permission2'];
        $permission3 = $request['permission3'];
        $permission4 = $request['permission4'];
        $array = [];
        if($permission1)
            array_push($array,$permission1);
        if($permission2)
            array_push($array,$permission2);
        if($permission3)
            array_push($array,$permission3);
        if($permission4)
            array_push($array,$permission4);
        $permission = "[";
        foreach ($array as $key => $value) {
            $permission.="'".$value."'"; 
            if($key != count($array)-1)
                $permission.=","; 
        }
        $permission .= "]";
        return $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = User::where('is_admin','!=',2)->orderBy('id','desc')->get();
        $users = User::where([['is_admin','!=',2],['user_id',Auth::user()->id]])->orderBy('id','desc')->get();
        return view('managements.users.index', compact('users'));
    }

    public function findEmail(Request $request){
        $user_id = Auth::user()->id;
        // if(Auth::user()->is_admin == 0)
        //     $user_id = Auth::user()->user_id;
        $user=User::where('email',$request->email)->where('user_id',$user_id)->first();
        $existe = false;
        if($user || $request->email===Auth::user()->email) $existe = true;
        return $existe;
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('managements.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permission = $this->storePermssion($request);
        $name = $request['name'];
        $email = $request['email'];
        $password = Hash::make($request['password']);
        // $is_admin = $request['is_admin'];
        $status = $request['status'];
        $is_admin = 0;
        if(Auth::user()->is_admin == 2)
            $is_admin = 1;
        $remember_token = Str::random(60);
        $user_id = Auth::user()->id;

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->is_admin = $is_admin;
        $user->status = $status;
        $user->remember_token = $remember_token;
        $user->user_id = $user_id;
        $user->permission = $permission;
        $user->save();

        $request->session()->flash('status','Utilisateur a été bien enregistré !');
        return redirect()->route('user.index');
    }

    public function rememberToken(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->has('remember')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
        $user_id = Auth::user()->user_id;
        $user = User::where('user_id',$user_id)->findOrFail($id);
        $permission = $this->getPermssion($user->permission);
        return view('managements.users.edit')->with([
            "user" => $user,
            "visibility" => true,
            "permission" => $permission
        ]);
    }

    public function editUser($id)
    {
        $user = User::where('id',Auth::user()->id)->findOrFail($id);
        $permission = $this->getPermssion(Auth::user()->permission);
        return view('managements.users.edit')->with([
            "user" => $user,
            "visibility" => false,
            "permission" => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = $this->storePermssion($request);
        $visibility = $request['visibility'];
        $name = $request['name'];
        $email = $request['email'];
        // $is_admin = $request['is_admin'];
        $status = $request['status'];
        $is_admin = 0;
        if(Auth::user()->is_admin == 2)
            $is_admin = 1;
        $user_id = Auth::user()->id;
        $password = Hash::make($request['password']);

        if ($visibility) {
            $user = User::where('user_id',Auth::user()->id)->find($id);
            $user->status = $status;
            $user->is_admin = $is_admin;
            $user->user_id = $user_id;
            $user->permission = $permission;
        }
        else{
            $user = User::where('id',Auth::user()->id)->find($id);
            $is_admin = Auth::user()->is_admin;
        }
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->save();

        if($visibility){
            $request->session()->flash('status',"Utlisateur a été bien modifié !");
            return redirect()->route('user.index');
        }
        else{
            $request->session()->flash('status',"Les informations sont bien modifiés !");
            return redirect()->route('app.home');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = "Utilisateur est supprimés avec succès !";
        $user_id = $id;
        $user = User::find($id);
        ####################################################
        if($user->is_admin == 1)
        {
            $factures = Facture::where('user_id',$user_id)->get();
            $reglements = Reglement::where('user_id',$user_id)->get();
            $lignecommandes = Lignecommande::where('user_id',$user_id)->get();
            $categories = Categorie::where('user_id',$user_id)->get();
            $produits = Produit::where('user_id',$user_id)->get();
            $commandes = Commande::where('user_id',$user_id)->get();
            $clients = Client::where('user_id',$user_id)->get();
            $companies = Company::where('user_id',$user_id)->get();
            $users = User::where('user_id',$user_id)->get();
            ####################################################
            if($factures->count() != 0){
                foreach ($factures as $facture) {
                    $facture->delete();
                }
            }
            if($reglements->count() != 0){
                foreach ($reglements as $reglement) {
                    $reglement->delete();
                }
            }
            if($lignecommandes->count() != 0){
                foreach ($lignecommandes as $lignecommande) {
                    $lignecommande->delete();
                }
            }
            if($categories->count() != 0){
                foreach ($categories as $categorie) {
                    $categorie->delete();
                }
            }
            if($produits->count() != 0){
                foreach ($produits as $produit) {
                    $produit->delete();
                }
            }
            if($commandes->count() != 0){
                foreach ($commandes as $commande) {
                    $commande->delete();
                }
            }
            if($clients->count() != 0){
                foreach ($clients as $client) {
                    $client->delete();
                }
            }
            if($companies->count() != 0){
                foreach ($companies as $companie) {
                    $companie->delete();
                }
            }
            if($users->count() != 0){
                foreach ($users as $user) {
                    $user->delete();
                }
            }
            $msg = "Utilisateur et ses composants sont supprimés avec succès !";
        }
        ####################################################
        $user->delete();
        return redirect()->route('user.index')->with(["status" => $msg]); 
    }
}
