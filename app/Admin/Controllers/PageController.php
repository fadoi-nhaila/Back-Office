<?php

namespace App\Admin\Controllers;

use App\Models\Page;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Pages';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Page());

        $grid->model()->orderBy('id', 'DESC');
        $grid->column('id', 'ID')->sortable()->filter();
        $grid->column('nom', __('Nom'))->sortable()->filter();
        $grid->column('url', __('Url'))->sortable()->filter();
        $grid->column('contenu', __('Contenu'))->sortable()->filter();
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
        $show = new Show(Page::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('nom', __('Nom'));
        $show->field('url', __('Url'));
        $show->field('contenu', __('Contenu'));
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
        $form = new Form(new Page());

        $form->text('nom', __('Nom'))->required()->placeholder('Entrez le nom');
        $form->url('url', __('Url'))->required()->placeholder('Entrez l\'url');
        $form->textarea('contenu', __('Contenu'))->required()->placeholder('Entrez le contenu');

        return $form;
    }
}
