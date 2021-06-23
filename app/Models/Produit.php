<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Produit extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function categorie()
    {
        return $this->belongsTo(Categorie::class,'categorie_id');
    }

    public function marque()
    {
        return $this->belongsTo(Marque::class,'marque_id');

    }

    public function promotions()
    {
        return $this->hasManyThrough('App\Models\Promotion', 'App\Models\PromotionAssociation', 'produits_id','id','id','promotions_id');
    }
  
}
