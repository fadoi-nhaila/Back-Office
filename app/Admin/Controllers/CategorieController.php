<?php

namespace App\Admin\Controllers;

use App\Models\Categorie;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use Encore\Admin\Tree;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Actions\BatchRestore;
use App\Admin\Actions\Restore;



class CategorieController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Catégories';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Categorie());

        $grid->model()->orderBy('id', 'DESC');
        
        $grid->column('id', __('ID'))->sortable()->filter('like');
        $grid->column('libelle', __('Libellé'))->sortable()->filter('like');
        $grid->column('image', __('Image'))->lightbox(['width' => 50, 'height' => 50,'zooming' => true]);
        $grid->column('created_at', __('Créé à'))->display(function(){
            return $this->created_at->format('d/m/Y');
        })->sortable()->filter('range','date');
        $grid->column('updated_at', __('Modifé à'))->display(function(){
            return $this->updated_at->format('d/m/Y');
        })->sortable()->filter('range','date');

        $grid->actions(function ($actions) {
           
            $actions->disableView();

            if (\ request('_ scope_') == 'trashed') {
                $actions->add(new Restore());
            }
            
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
        $show = new Show(Categorie::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('libelle', __('Libelle'));
        $show->field('image', __('Image'));
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
        $form = new Form(new Categorie());
        
        $form->text('libelle', __('Libellé'))->required()->placeholder('Entrez le libellé');
        $form->image('image', __('Image'))->required();
       


        return $form;
    }
}
