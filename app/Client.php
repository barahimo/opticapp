<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = ["adresse","telephone","ICE","solde"];

    public function commande() 
    {
        return $this->hasMany(Commande::class);
    }

    protected $date = ['deleted_at'];
}
