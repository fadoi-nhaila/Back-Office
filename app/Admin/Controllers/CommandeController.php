<?php

namespace App\Admin\Controllers;

use App\Models\Commande;
use App\Models\Produit;
use App\Models\Client;
use App\Models\Categorie;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
Use Encore\Admin\Admin;

class CommandeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Commandes';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {   
        
        $grid = new Grid(new Commande());

        $grid->model()->orderBy('id', 'DESC');
        
        $grid->column('id', __('ID'))->sortable()->filter();
        $grid->column('reference', __('Référence'))->sortable()->filter('like');
        $grid->column('etat', __('Etat'))->sortable()->filter('like');
        $grid->column('date', __('Date'))->sortable()->filter('like');
        $grid->column('client.nom', __('Client'))->sortable()->filter('like');
        $grid->column('created_at', __('Created at'))->display(function(){
            return $this->created_at->format('d/m/Y');
        })->sortable()->filter('like');
        $grid->column('updated_at', __('Updated at'))->display(function(){
            return $this->created_at->format('d/m/Y');
        })->sortable()->filter('like');

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
        $show = new Show(Commande::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('reference', __('Référence'));
        $show->field('etat', __('Etat'));
        $show->field('date', __('Date'));
        $show->field('id_client', __('Id client'));
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
        $form = new Form(new Commande());

        
        $form->select('client_id', __('Client'))->options(Client::all()->pluck('nom','id'))->required();
        $form->text('reference', __('Référence'))->placeholder('Entrez la référence')->required();
        $form->text('etat', __('Etat'))->placeholder('Entrez l\'état')->required();
        $form->date('date', __('Date'))->placeholder('Entrez la date')->required()->format('DD/MM/YYYY');
       
        $form->divider();
        

        $form->table('ligne_commandes','Liste d\'achats', function (Form\NestedForm $form) {
            
            $form->select('categories_id','Catégorie')
                 ->options(Categorie::all()->pluck('libelle','id'))
                 ->load('produits_id', '/admin/api/produit');
            $form->select('produits_id','Produit')->options(function ($id) {
                return Produit::where('id', $id)->pluck('nom', 'id');
            });
            $form->decimal('prix_unite', __('Prix unité'))->placeholder('Prix unité')->required()->prepend(false);
            $form->decimal('quantite', __('Quantité'))->placeholder('Quantité')->prepend(false);
            $form->decimal('prix_total', __('Prix total'))->placeholder('Prix total')->required()->prepend(false);
                
        });

        $form->saving(function (Form $form) {
            foreach($form->model()->ligne_commandes as $achat)
                $achat->delete();
        });

        Admin::script('initCommande()');
          
        return $form;

    }

 
}
