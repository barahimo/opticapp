<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = ["nom","descreption"];

    public function produit() 
    {
        return $this->hasMany(Produit::class);
    }
}
