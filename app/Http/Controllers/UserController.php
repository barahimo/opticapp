<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SuperAdmin;
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
        $this->middleware('superAdmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('is_admin','!=',2)->orderBy('id','desc')->get();
        return view('managements.users.index', compact('users'));
    }

    public function findEmail(Request $request){
        $user=User::where('email',$request->email)->first();
        $existe = false;
        if($user) $existe = true;
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
        $name = $request['name'];
        $email = $request['email'];
        $password = Hash::make($request['password']);
        $is_admin = $request['is_admin'];
        $remember_token = Str::random(60);
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->is_admin = $is_admin;
        $user->remember_token = $remember_token;
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
        $user = User::find($id);
        return view('managements.users.edit')->with([
            "user" => $user
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
        $name = $request['name'];
        $email = $request['email'];
        $is_admin = $request['is_admin'];
        $password = Hash::make($request['password']);
        $user = User::find($id);
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->is_admin = $is_admin;
        $user->save();
        $request->session()->flash('status',"Utlisateur a été bien modifié !");
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        $msg = "Utilisateur a été supprimé avec succès !";
        return redirect()->route('user.index')->with(["status" => $msg]); 
    }
}
