<?php

namespace App\Admin\Controllers;

use App\Models\ListeCourse;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ListeCourseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'ListeCourse';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ListeCourse());

        $grid->column('id', __('Id'));
        $grid->column('libelle', __('Libelle'));
        $grid->column('contenu', __('Contenu'));
        $grid->column('client_id', __('Client id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(ListeCourse::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('libelle', __('Libelle'));
        $show->field('contenu', __('Contenu'));
        $show->field('client_id', __('Client id'));
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
        $form = new Form(new ListeCourse());

        $form->text('libelle', __('Libelle'));
        $form->textarea('contenu', __('Contenu'));
        $form->number('client_id', __('Client id'));

        return $form;
    }
}
