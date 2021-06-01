<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModePaiement extends Model
{
    use HasFactory;
    
    public function commandes()
    {
        return $this->hasMany(Commande::class,'paiement_id');
    }
}
