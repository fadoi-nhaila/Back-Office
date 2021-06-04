<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Marque extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function produits()
    {
        return $this->hasMany(Produit::class,'marque_id');
    }
}
