<?php

namespace App\Admin\Controllers;

use App\Models\Ville;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Actions\BatchRestore;


class VilleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Villes';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Ville());

        $grid->model()->orderBy('id', 'DESC');

        $grid->column('id', __('ID'))->sortable()->filter('like');
        $grid->column('nom', __('Nom'))->sortable()->filter('like');
        $grid->column('created_at', __('Créé à'))->display(function(){
            return $this->created_at->format('d/m/Y');
        })->sortable()->filter('range','date');
        $grid->column('updated_at', __('Modifé à'))->display(function(){
            return $this->updated_at->format('d/m/Y');
        })->sortable()->filter('range','date');

        $grid->actions(function ($actions) {
           
            $actions->disableView();
            
        });

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
        $show = new Show(Ville::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('nom', __('Nom'));
        $show->field('created_at', __('Créé à'));
        $show->field('updated_at', __('modifié à'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Ville());

        $form->text('nom', __('Nom'))->required()->placeholder('Entrez le nom');

        return $form;
    }
}
