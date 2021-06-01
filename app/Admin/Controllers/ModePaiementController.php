<?php

namespace App\Admin\Controllers;

use App\Models\ModePaiement;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ModePaiementController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Modes de paiement';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ModePaiement());
         
        $grid->model()->orderBy('id', 'DESC');

        $grid->column('id', __('ID'))->sortable()->filter('like');
        $grid->column('type', __('Type'))->sortable()->filter('like');
        $grid->column('created_at', __('Créé à'))->display(function(){
            return $this->created_at->format('d/m/Y');
        })->sortable()->filter('range','date');
        $grid->column('updated_at', __('Modifé à'))->display(function(){
            return $this->updated_at->format('d/m/Y');
        })->sortable()->filter('range','date')->hide();

        $grid->actions(function ($actions) {
           
            $actions->disableView();
            
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
        $show = new Show(ModePaiement::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('type', __('Type'));
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
        $form = new Form(new ModePaiement());

        $form->text('type', __('Type'));
        

        return $form;
    }
}
