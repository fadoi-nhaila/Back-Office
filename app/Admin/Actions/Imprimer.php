<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Imprimer extends RowAction
{
    public $name = 'Imprimer';


    public function render()
    {
        return '<a target="_blank" href="'.$this->getResource().'/'.$this->getKey().'/print"><i class="fa fa-paper-plane"></i></a>';
    }

}