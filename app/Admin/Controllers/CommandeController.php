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
        $grid->column('reference', __('Référence'))->sortable()->filter();
        $grid->column('etat', __('Etat'))->sortable()->filter();
        $grid->column('date', __('Date'))->sortable()->filter();
        $grid->column('id_client', __('Id_client'))->sortable()->filter();;
        $grid->column('created_at', __('Created at'))->display(function(){
            return $this->created_at->format('d/m/Y');
        })->sortable()->filter();
        $grid->column('updated_at', __('Updated at'))->display(function(){
            return $this->created_at->format('d/m/Y');
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

        
        $form->select('id_client', __('Nom Client'))->options(Client::all()->pluck('nom','id'));
        $form->text('reference', __('Référence'))->placeholder('Entrez la référence')->required();
        $form->text('etat', __('Etat'))->placeholder('Entrez l\'état')->required();
        $form->date('date', __('Date'))->placeholder('Entrez la date')->required();
       
        $form->divider();
        

        $form->table('listeAchats','Liste d\'achats', function (Form\NestedForm $form) {
            
        $form->select('categorie_id','Catégorie')->options(Categorie::all()->pluck('libelle','id'))->load('produit_id', '/admin/api/produit');
        $form->select('produit_id','Produit');
        $form->decimal('prix_unite', __('Prix unité'))->placeholder('Prix unité')->required()->prepend(false);
        $form->decimal('quantite', __('Quantité'))->placeholder('Quantité')->prepend(false);
        $form->decimal('prix_total', __('Prix total'))->placeholder('Prix total')->required()->prepend(false);
              
        });

        Admin::script('initAchat()');
          
        return $form;

    }

 
}
