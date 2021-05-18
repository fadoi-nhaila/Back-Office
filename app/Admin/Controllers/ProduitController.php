<?php

namespace App\Admin\Controllers;

use App\Models\Produit;
use App\Models\Marque;
use App\Models\Categorie;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProduitController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Produits';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Produit());

       
        $grid->model()->orderBy('id', 'DESC');

        $grid->column('id', 'ID')->sortable()->filter();
        $grid->column('categorie.libelle', __('Catégorie'))->sortable()->filter();
        $grid->column('marque.libelle', __('Marque'))->sortable()->filter();
        $grid->column('nom', __('Nom'))->sortable()->filter();
        $grid->column('description', __('Description'))->hide();
        $grid->column('prix', __('Prix'))->sortable()->filter()->display(function($prix){
            return number_format($prix, 2, ',', '');
        });
        $grid->column('point_fidelite', __('Point fidélité'))->sortable()->filter();
        $grid->column('quantite', __('Quantité'))->sortable()->filter();
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
        $show = new Show(Produit::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('nom', __('Nom'));
        $show->field('marque', __('Marque'));
        $show->field('prix', __('Prix'));
        $show->field('point_fidelite', __('Point fidélité'));
        $show->field('quantite', __('Quantité'));
        $show->field('image', __('Image'));
        $show->field('description', __('Description'));
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
        $form = new Form(new Produit());

       
        $form->select('categorie_id', __('Catégorie'))->options(Categorie::all()->pluck('libelle','id'))->required();
        $form->select('marque_id', __('Marque'))->options(Marque::all()->pluck('libelle','id'))->required();
        $form->text('nom', __('Nom'))->placeholder('Entrez le nom')->required();
        $form->currency('prix', __('Prix'))->placeholder('Entrez le prix')->required()->prepend(false);
        $form->decimal('point_fidelite', __('Point fidélité'))->placeholder('Entrez les points')->required();
        $form->number('quantite', __('Quantité'))->placeholder('Entrez la qantité')->required();
        $form->image('image', __('Image'))->required();
        $form->textarea('description', __('Description'))->placeholder('Entrez la description')->required();
      

        return $form;
    }
}
