<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Commande extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'commandes';

    
    public function client()
    {
        return $this->belongsTo(Client::class,'client_id');   
    }

    public function mode_paiement()
    {
        return $this->belongsTo(ModePaiement::class,'paiement_id');   
    }


    public function ligne_commandes()
    {
        return $this->hasMany(LigneCommande::class, 'commandes_id');
    }

    public function etat()
    {
        return $this->belongsTo(Etat::class,'etat_id');   
    }

    public function getDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }


    public static function commandeReference()
    {
        $maxRef = Self::max('reference');
        if (!$maxRef) {
            $newRef = 1;
        } else {
           
            $partie = explode("/", $maxRef);
            $newRef = explode("C", $partie[0]);
            $newRef = intval($newRef[1]);
            $newRef++;
        }
        return  "C" . str_pad($newRef, 5, "0", STR_PAD_LEFT) . "/" . date("y");
    }
}
