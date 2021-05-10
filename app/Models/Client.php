<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public function adresses()
    {
        return $this->hasMany(Adresse::class,'client_id');
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class,'id_client');
    }
}

