<?php

namespace App\Admin\Controllers;

use App\Models\Parametre;
use App\Models\Option;
use App\Models\Client;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
Use Encore\Admin\Admin;
use App\Admin\Actions\BatchRestore;


use Route;

class ParametreController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Parametre';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Parametre());

        $grid->model()->orderBy('id', 'DESC');

        $grid->column('id', __('ID'))->sortable()->filter('like');
        $grid->column('option.libelle', __('Option'))->sortable()->filter('like');
        $grid->column('client.nom', __('Client'))->sortable()->filter('like');
        $states = [
            'on' => ['value' => 1, 'text' => 'Oui', 'color' => 'primary'],
            'off' => ['value' => 2, 'text' => 'Non', 'color' => 'default'],
        ];
        $grid->column('valeur', __('Valeur'))->switch($states);
        $grid->column('created_at', __('Créé à'))->display(function(){
            return $this->created_at->format('d/m/Y');
        })->sortable()->filter('range','date');
        $grid->column('updated_at', __('Modifé à'))->display(function(){
            return $this->updated_at->format('d/m/Y');
        })->sortable()->filter('range','date');

        $grid->actions(function ($actions) {
           
            $actions->disableView();
            
        });

        $table = "client";
        if(request($table."_nom"))
        {
            $grid->model()->whereHas($table, function ($query) use ($table) {
                $query->where('nom', 'like', "%".request($table."_nom")."%");
            });
            $url = Route::current()->uri;
            Admin::script('setSearch("'.$table.'-nom", "'.request($table."_nom").'", "/'.$url.'");');
        }

        $tablee = "option";
        if(request($tablee."_libelle"))
        {
            $grid->model()->whereHas($table, function ($query) use ($tablee) {
                $query->where('libelle', 'like', "%".request($tablee."_libelle")."%");
            });
            $url = Route::current()->uri;
            Admin::script('setSearch("'.$tablee.'-libelle", "'.request($tablee."_libelle").'", "/'.$url.'");');
        }

        $grid->filter(function($filter) {

            $filter->scope('trashed', 'Corbeille')->onlyTrashed();
            
        });


        $grid->batchActions (function($batch) {

            if (\request('_scope_') == 'trashed') {
                $batch->add(new BatchRestore());
            }
            
        });


        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Parametre::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('option_id', __('Option id'));
        $show->field('client_id', __('Client id'));
        $show->field('valeur', __('Valeur'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Parametre());
        
        $form->select('client_id', __('Client'))->options(Client::all()->pluck('nom','id'))->required();
        $form->select('option_id', __('Option'))->options(Option::all()->pluck('libelle','id'))->required();
        $states = [
            'on'  => ['value' => 1, 'text' => 'Oui', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => 'Non', 'color' => 'default'],
        ];
        
        $form->switch('valeur', __('Valeur'))->states($states);

        return $form;
    }
}
