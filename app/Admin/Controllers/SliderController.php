<?php

namespace App\Admin\Controllers;

use App\Models\Slider;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;


class SliderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Sliders';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Slider());

        $grid->model()->orderBy('id', 'DESC');
        $grid->column('id', 'ID')->sortable()->filter();
        $grid->column('nom', __('Nom'))->sortable()->filter();
        $grid->column('url', __('Url'))->sortable()->filter();
        $grid->column('image', __('Image'))->image('http://promos.test//uploads',50,50)->sortable()->filter();
        $grid->column('created_at', __('Créé à'))->display(function(){
            return $this->created_at->format('d/m/Y');
        })->sortable()->filter();
        $grid->column('updated_at', __('Modifé à'))->display(function(){
            return $this->updated_at->format('d/m/Y');
        })->sortable()->filter();

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
        $show = new Show(Slider::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('nom', __('Nom'));
        $show->field('url', __('Url'));
        $show->field('image', __('Image'));
        $show->field('created_at', __('Créé à'));
        $show->field('updated_at', __('Modifé à'));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Slider());

        $form->text('nom', __('Nom'))->placeholder('Entrez le nom')->required();
        $form->url('url', __('Url'))->placeholder('Entrez url')->required();
        $form->image('image', __('Image'))->required();

        return $form;
    }
}
