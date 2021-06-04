<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ModePaiement extends Model
{
    use HasFactory;
    use SoftDeletes;

    
    public function commandes()
    {
        return $this->hasMany(Commande::class,'paiement_id');
    }
}
