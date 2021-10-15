<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
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
    
    /**
     * Display a listing of the resource.
     * Show the form for creating a new resource or editing the specified resource..
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $companies = Company::get();
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $companies = Company::where('user_id',$user_id)->get();
        $count = count($companies);
        ($count > 0) ? $view = 'edit': $view = 'create';
        
        $permission = $this->getPermssion(Auth::user()->permission);
        if($view == 'create'){
            // if(in_array('create9',$permission) || Auth::user()->is_admin == 2){
            if($this->hasPermssion('create9') == 'yes'){
                $company = null;
                $route = route('company.store');
                return view('parametres.form',compact('company','route','view'));
            }
        }
        if($view == 'edit'){
            // if(in_array('edit9',$permission) || Auth::user()->is_admin == 2){
            if($this->hasPermssion('edit9') == 'yes'){
                // $company = Company::first();
                $company = Company::where('user_id',$user_id)->first();
                $route = route('company.update',['company'=>$company->id]);
                return view('parametres.form',compact('company','route','view'));
            }
        }
        return view('application');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $route = route('company.store');
        // $view = 'create';
        // return view('parametres.form',compact('route','view'));
    }

    /**
     * form storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function form(Request $request,$company,$path)
    {
        $company->logo = $path;
        $company->nom = $request->nom;
        $company->adresse = $request->adresse;
        $company->code_postal = $request->code_postal;
        $company->ville = $request->ville;
        $company->pays = $request->pays;
        $company->tel = $request->tel;
        $company->site = $request->site;
        $company->email = $request->email;
        $company->note = $request->note;
        $company->iff = $request->iff;
        $company->ice = $request->ice;
        $company->capital = $request->capital;
        $company->rc = $request->rc;
        $company->patente = $request->patente;
        $company->cnss = $request->cnss;
        $company->banque = $request->banque;
        $company->rib = $request->rib;
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $company->user_id = $user_id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = new Company();
        $path = $this->imageStore($request);
        $this->form($request,$company,$path);
        $company->save();
        $request->session()->flash('status',"L'opération effectuée avec succès !");
        return redirect()->route('company.index');
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
        // $company = Company::first();
        // $route = route('company.update',['company'=>$company->id]);
        // $view = 'edit';
        // return view('parametres.form',compact('company','route','view'));
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
        // $company = Company::first();
        $user_id = Auth::user()->id;
        if(Auth::user()->is_admin == 0)
            $user_id = Auth::user()->user_id;
        $company = Company::where('user_id',$user_id)->first();
        $path = $this->imageUpdate($request, $company);
        $this->form($request,$company,$path);
        $company->save();
        $request->session()->flash('status',"L'opération effectuée avec succès !");
        return redirect()->route('company.index');
    }

    /**
     * Remove the specified resource from storage.
        *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * store the specified image.
        *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function imageStore(Request $request)
    {
        $hasFile = $request->hasFile('logo');
        $file = $request->file('logo');
        if ($hasFile)
            // $path = $file->store('company');
            $path = Storage::disk('public')->putFile('company',$file);
        else
            $path = null;
        return $path;
    }

    /**
     * update the specified image.
        *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function imageUpdate(Request $request, $company)
    {
        $hasFile = $request->hasFile('logo');
        $file = $request->file('logo');
        if ($hasFile) {
            // $path = $file->store('company');//--env('FILESYSTEM_DRIVER', 'local')--//
            $path = Storage::disk('public')->putFile('company',$file);
            Storage::delete($company->logo);
        } else
            $path = $company->logo;
        return $path;
    }
    
    public function saveImage(Request $request)
    {
        $hasFile = $request->hasFile('image');
        $file = $request->file('image');
        ($hasFile) ? $path = Storage::disk('public')->putFile('test',$file): $path = null;
        return $path;
    }
}
