<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo(Client::class,'id_client');   
    }

    public function listeAchats()
    {
        return $this->belongsToMany(Produit::class)->withPivot(['categorie_id','prix_unite','quantite','prix_total']);
    }
}
