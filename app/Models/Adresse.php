<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adresse extends Model
{
    use HasFactory;

    protected $fillable = ['ville_id','quartier','rue','numero'];

    public function client()
    {
        
        return $this->belongsTo(Client::class,'client_id');
        
    }

    public function ville()
    {
        
        return $this->belongsTo(Ville::class,'ville_id');
        
    }
}
