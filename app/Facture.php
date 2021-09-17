<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $fillable = ["cadre","avance","reste","solde"];

    public function Commande() 
    {
        // return $this->hasOne(Commande::class);
        return $this->belongsTo(Commande::class);
    }
}

