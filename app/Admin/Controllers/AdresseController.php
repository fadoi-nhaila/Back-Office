<?php

namespace App\Admin\Controllers;

use App\Models\Adresse;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

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
        $grid->ville()->nom('Ville')->sortable()->filter();
        $grid->column('quartier', __('Quartier'))->sortable()->filter();
        $grid->column('rue', __('Rue'))->sortable()->filter();
        $grid->column('numero', __('Numéro'))->sortable()->filter();
        $grid->column('created_at', __('Créé à'))->display(function(){
            return $this->created_at->format('d/m/Y');
        });
        $grid->column('updated_at', __('Modifé à'))->display(function(){
            return $this->updated_at->format('d/m/Y');
        });

        $grid->actions(function ($actions) {
           
            $actions->disableEdit();
            
        });

        $grid->disableCreateButton();

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
