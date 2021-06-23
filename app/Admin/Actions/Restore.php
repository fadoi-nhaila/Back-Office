<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Restore extends RowAction
{
    public $name = 'Restaurer';

    public function handle (Model $model)
    {
        $model->restore();

        return $this->response()->success('Restauré avec succès')->refresh();
    }

    public function dialog()
    {
        $this->confirm('Êtes-vous sûr de vouloir reprendre?');
    }
}