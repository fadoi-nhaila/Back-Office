<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class Promotion extends Model
{
    use HasFactory;
    use SoftDeletes;

    
    public function promotion_associations()
    {
        return $this->hasMany(PromotionAssociation::class, 'promotions_id');
    }

    public function etat_promo()
    {
        return $this->belongsTo(EtatPromo::class,'etat_id');   
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
