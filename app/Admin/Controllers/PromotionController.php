<?php

namespace App\Admin\Controllers;

use App\Models\Promotion;
use App\Models\Produit;
use App\Models\Categorie;
use Encore\Admin\Controllers\AdminController;
use Illuminate\Http\Request;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;


class PromotionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Promotions';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Promotion());

        $grid->model()->orderBy('id', 'DESC');
        $grid->column('id', 'ID')->sortable()->filter('like');
        $grid->column('nom', __('Nom'))->sortable()->filter('like');
        $grid->column('date_debut', __('Date début'))->sortable()->filter('like');
        $grid->column('date_fin', __('Date fin'))->sortable()->filter('like');
        $grid->column('type', __('Type'))->sortable()->filter('like');
        $grid->column('valeur', __('Valeur'))->sortable()->filter('like');
        $grid->column('etat', __('Etat'))->sortable()->filter('like');
        $grid->column('created_at', __('Créé à'))->display(function(){
            return $this->created_at->format('d/m/Y');
        })->sortable()->filter('like');
        $grid->column('updated_at', __('Modifé à'))->display(function(){
            return $this->updated_at->format('d/m/Y');
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
        $show = new Show(Promotion::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('nom', __('Nom'));
        $show->field('date_debut', __('Date début'));
        $show->field('date_fin', __('Date fin'));
        $show->field('type', __('Type'));
        $show->field('valeur', __('Valeur'));
        $show->field('etat', __('Etat'));
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
        $form = new Form(new Promotion());
        $form->text('nom', __('Nom'))->placeholder('Entrez le nom')->required();
       
        $types = [
            1 =>'pourcentage' ,
            2 =>'solde' ,
        ];
        
        $form->select('type', __('Type'))->options($types)->required();
        $form->text('etat', __('Etat'))->required();
        $form->text('valeur', __('Valeur'))->placeholder('Entrez la valeur')->required(); 
        $form->date('date_debut', __('Date début'))->placeholder('Date début')->required()->format('DD/MM/YYYY');
        $form->date('date_fin', __('Date fin'))->placeholder('Date fin')->required()->format('DD/MM/YYYY');

        $form->divider();

        $form->table('produits','Associations', function (Form\NestedForm $form) {
            
            $form->select('categorie_id','Catégorie')
                ->options(Categorie::all()->pluck('libelle','id'))
                ->load('produit_id', '/admin/api/produit');
            $form->select('produit_id','Produit');
              
        });
          
         
        

        return $form;
    }
}
