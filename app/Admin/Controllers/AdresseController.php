<?php

namespace App\Admin\Controllers;

use App\Models\Adresse;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Admin;

use Route;

class AdresseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Adresses';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Adresse());

        $grid->id('ID')->sortable();
        $grid->column('ville.nom', __('Ville'))->sortable()->filter('like');
        $grid->column('quartier', __('Quartier'))->sortable()->filter('like');
        $grid->column('rue', __('Rue'))->sortable()->filter('like');
        $grid->column('numero', __('Numéro'))->sortable()->filter('like');
        $grid->column('client.nom', __('Client'))->sortable()->filter('like');
        $grid->column('created_at', __('Créé à'))->display(function(){
            return $this->created_at->format('d/m/Y');
        })->filter('range','date')->sortable();
        $grid->column('updated_at', __('Modifé à'))->display(function(){
            return $this->updated_at->format('d/m/Y');
        })->filter('range','date')->sortable();


        $grid->disableCreateButton();

        $tables = ["ville","client"];
        foreach($tables as $table)
        {
            if(request($table."_nom"))
            {
                $grid->model()->whereHas($table, function ($query) use ($table)  {
                    $query->where('nom', 'like', "%".request($table."_nom")."%");
                });
                $url = Route::current()->uri;
                Admin::script('setSearch("'.$table.'-nom", "'.request($table."_nom").'", "/'.$url.'");');
            }
        }
        

        $grid->disableActions();



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
        $show = new Show(Adresse::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('quartier', __('Quartier'));
        $show->field('rue', __('Rue'));
        $show->field('numero', __('Numéro'));
        $show->field('created_at', __('Créé à'));
        $show->field('updated_at', __('Modifé à'));

        $show->panel()
            ->tools(function ($tools) {
                $tools->disableEdit();
        });
        return $show;
    }

    
}
