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
        // $this->middleware('superAdmin');
        $this->middleware('statususer');
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
        return view('managements.users.edit')->with([
            "user" => $user,
            "visibility" => true
        ]);
    }

    public function editUser($id)
    {
        $user = User::where('id',Auth::user()->id)->findOrFail($id);
        return view('managements.users.edit')->with([
            "user" => $user,
            "visibility" => false
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
            $request->session()->flash('status',"les informations sont bien modifiés !");
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
        $user = User::find($id);
        $user->delete();
        $msg = "Utilisateur a été supprimé avec succès !";
        return redirect()->route('user.index')->with(["status" => $msg]); 
    }
}
