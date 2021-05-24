<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Carbon\Carbon;

class Promotion extends Model
{
    use HasFactory;
    
    public function produits()
    {
        return $this->belongsToMany(Produit::class);
    }

    public function getDateDebutAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }

    public function setDateDebutAttribute($value)
    {
        $this->attributes['date_debut'] = \Carbon\Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getDateFinAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    
    }

    public function setDateFinAttribute($value)
    {
        $this->attributes['date_fin'] = \Carbon\Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    
}
