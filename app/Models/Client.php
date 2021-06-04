<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'clients';
    

    public function adresses()
    {
        return $this->hasMany(Adresse::class,'client_id');
    }
    
    public function commandes()
    {
        return $this->hasMany(Commande::class,'client_id');
    }

    

    public function liste_courses()
    {
        return $this->hasMany(ListeCourse::class,'client_id');
    }

    public function parametres()
    {
        return $this->hasMany(Parametre::class,'client_id');
    }

}

