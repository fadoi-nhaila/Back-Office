<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class BatchRestore extends BatchAction
{
    public $name = 'Restaurer';

    public function handle (Collection $collection)
    {
        $collection->each->restore();

        return $this->response()->success('Restauré avec succès')->refresh();
    }

    public function dialog ()
    {
        $this->confirm('Êtes-vous sûr de vouloir reprendre?');
    }
}