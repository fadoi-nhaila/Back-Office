<?php

namespace App\Admin\Controllers;

use App\Models\Magasin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Actions\BatchRestore;


class MagasinController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Magasins';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Magasin());

        $grid->model()->orderBy('id', 'DESC');

        $grid->column('id', 'ID')->sortable()->filter('like');
        $grid->column('nom', __('Nom'))->sortable()->filter('like');
        $grid->column('ville', __('Ville'))->sortable()->filter('like');
        $grid->column('telephone', __('Téléphone'))->sortable()->filter('like');
        $grid->column('description', __('Description'))->hide()->filter('like');
        $grid->column('latitude_gps', __('Latitude'))->sortable()->filter('like');
        $grid->column('longitude_gps', __('Longitude'))->sortable()->filter('like');
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
        $show = new Show(Magasin::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('nom', __('Nom'));
        $show->field('ville', __('Ville'));
        $show->field('telephone', __('Téléphone'));
        $show->field('description', __('Description'));
        $show->field('latitude_gps', __('Latitude'));
        $show->field('longitude_gps', __('Longitude'));
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
        $form = new Form(new Magasin());

        $form->text('nom', __('Nom'))->placeholder('Entrez le nom')->required();
        $form->text('ville', __('Ville'))->placeholder('Entrez la ville')->required();
        $form->mobile('telephone', __('Téléphone'))->options(['mask' => '9999999999'])->placeholder('Entrez le téléphone')->required();
        $form->text('latitude_gps', __('Latitude'))->placeholder('Entrez la latitude')->required();
        $form->text('longitude_gps', __('Longitude'))->placeholder('Entrez la longitude')->required();
        $form->textarea('description', __('Description'))->placeholder('Entrez la description')->required();
       

        return $form;
    }
}
