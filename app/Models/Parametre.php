<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Parametre extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function client()
    {
        
        return $this->belongsTo(Client::class,'client_id');
        
    }

    public function option()
    {
        
        return $this->belongsTo(Option::class,'option_id');
        
    }
}
