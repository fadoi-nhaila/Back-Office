<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Categorie extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function produits()
    {
        return $this->hasMany(Produit::class,'categorie_id');
    }

    
}
