<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commande extends Model
{
    // use SoftDeletes;
    
    // protected $fillable = ["cadre","avance","reste","solde"];

    public function client() 
    {
        return $this->belongsTo(Client::class);
    }

    public function reglement() 
    {
        return $this->belongsTo(Reglement::class);
    }

    public function Produit() 
    {
        return $this->belongsToMany(Produit::class);
    }
    public function Facture() 
    {
        // return $this->hasMany(Facture::class);
        // return $this->belongsTo(Facture::class);
        return $this->hasOne(Facture::class);
    }
    // protected $date = ['deleted_at'];


    public function reglements() 
    {
        return $this->hasMany(Reglement::class);
    }

}
