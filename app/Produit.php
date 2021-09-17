<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produit extends Model
{
    use SoftDeletes;
    
    protected $fillable = ["nom_produit","descreption","prix_produits"];

    public function categorie() 
    {
        return $this->belongsTo(Categorie::class);
    }
    public function Commande() 
    {
        return $this->belongsToMany(Commande::class);
    }

    protected $date = ['deleted_at'];
}
