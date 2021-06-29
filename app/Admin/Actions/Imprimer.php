<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Imprimer extends RowAction
{
    public $name = 'Imprimer';


    public function href()
    {
        return "{$this->getResource()}/{$this->getKey()}/print";
    }

}