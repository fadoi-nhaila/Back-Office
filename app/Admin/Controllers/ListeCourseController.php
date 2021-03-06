<?php

namespace App\Admin\Controllers;

use App\Models\ListeCourse;
use App\Models\Client;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
Use Encore\Admin\Admin;
use App\Admin\Actions\BatchRestore;


use Route;

class ListeCourseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Listes de Courses';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ListeCourse());

        $grid->model()->orderBy('id', 'DESC');

        $grid->column('id', __('ID'))->sortable()->filter();
        $grid->column('libelle', __('Libelle'))->sortable()->filter('like');
        $grid->column('contenu', __('Contenu'))->sortable()->filter('like');
        $grid->column('client.nom', __('Client'))->sortable()->filter('like');
        $grid->column('created_at', __('Créé à'))->display(function(){
            return $this->created_at->format('d/m/Y');
        })->sortable()->filter('range','date');
        $grid->column('updated_at', __('Modifé à'))->display(function(){
            return $this->updated_at->format('d/m/Y');
        })->sortable()->filter('range','date');

        $table = "client";
        if(request($table."_nom"))
        {
            $grid->model()->whereHas($table, function ($query) use ($table) {
                $query->where('nom', 'like', "%".request($table."_nom")."%");
            });
            $url = Route::current()->uri;
            Admin::script('setSearch("'.$table.'-nom", "'.request($table."_nom").'", "/'.$url.'");');
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

        $form->text('libelle', __('Libelle'))->required();
        $form->textarea('contenu', __('Contenu'))->required();
        $form->select('client_id', __('Client'))->options(Client::all()->pluck('nom','id'))->required();

        return $form;
    }
}
