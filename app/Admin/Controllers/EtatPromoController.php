<?php

namespace App\Admin\Controllers;

use App\Models\EtatPromo;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EtatPromoController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Etats de promotions';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new EtatPromo());

        $grid->model()->orderBy('id', 'DESC');

        $grid->column('id', __('ID'))->sortable()->filter('like');
        $grid->column('libelle', __('Libelle'))->sortable()->filter('like');
        $grid->column('created_at', __('Créé à'))->display(function(){
            return $this->created_at->format('d/m/Y');
        })->sortable()->filter('range','date');
        $grid->column('updated_at', __('Modifé à'))->display(function(){
            return $this->updated_at->format('d/m/Y');
        })->sortable()->filter('range','date');

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
        $show = new Show(EtatPromo::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('libelle', __('Libelle'));
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
        $form = new Form(new EtatPromo());

        $form->text('libelle', __('Libelle'))->placeholder('Entrez le libelle')->required();

        return $form;
    }
}
