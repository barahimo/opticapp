<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     * Show the form for creating a new resource or editing the specified resource..
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::get();
        $count = count($companies);
        ($count > 0) ? $view = 'edit': $view = 'create';
        if($view == 'create'){
            $company = null;
            $route = route('company.store');
        }
        if($view == 'edit'){
            $company = Company::first();
            $route = route('company.update',['company'=>$company->id]);
        }
        return view('parametres.form',compact('company','route','view'));
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
        $company = Company::first();
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
