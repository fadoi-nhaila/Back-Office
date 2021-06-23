<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PromotionAssociation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['categories_id','produits_id'];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotions_id');
    }


}
