<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    
    public function associations()
    {
        return $this->belongsToMany(Produit::class)->withPivot(['categorie_id']);
    }
}
