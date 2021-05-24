<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $table = 'commandes';

    
    
    public function client()
    {
        return $this->belongsTo(Client::class,'client_id');   
    }

    public function listeAchats()
    {
        return $this->belongsToMany(Produit::class)->withPivot(['categorie_id','prix_unite','quantite','prix_total']);
    }

    public function getDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }


}
