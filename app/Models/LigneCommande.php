<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LigneCommande extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = ['categories_id','produits_id','prix_unite','quantite','prix_total'];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class,'categories_id');   
    }

    public function produits()
    {
        return $this->belongsTo(Produit::class,'produits_id');   
    }

}
