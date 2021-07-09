<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Adresse extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'adresses';


    protected $fillable = ['ville_id','quartier','rue','numero'];

    public function client()
    {
        
        return $this->belongsTo(Client::class,'client_id')->withTrashed();
        
    }

    public function ville()
    {
        
        return $this->belongsTo(Ville::class,'ville_id');
        
    }
}
