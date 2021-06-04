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
use App\Admin\Actions\BatchRestore;




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
        $grid->column('date_debut', __('Date début'))->sortable()->filter('range','date');
        $grid->column('date_fin', __('Date fin'))->sortable()->filter('range','date');
        $grid->column('type', __('Type'))->sortable()->filter('like');
        $grid->column('valeur', __('Valeur'))->sortable()->filter('like');
        $grid->column('etat', __('Etat'))->sortable()->filter('like');
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
       
        
        $etats = [
            'la promotion est activée' =>'la promotion est activée' ,
            'la promotion est annulée' =>'la promotion est annulée' ,
        ];
        
        $form->select('etat', __('Etat'))->options($etats)->required();
        $types = [
            'pourcentage' =>'pourcentage' ,
            'solde' =>'solde' ,
        ];
        
        $form->select('type', __('Type'))->options($types)->required();
        $form->text('valeur', __('Valeur'))->placeholder('Entrez la valeur')->required(); 
        $form->date('date_debut', __('Date début'))->placeholder('Date début')->required()->format('DD/MM/YYYY');
        $form->date('date_fin', __('Date fin'))->placeholder('Date fin')->required()->format('DD/MM/YYYY');

        $form->divider();

        $form->table('promotion_associations','', function (Form\NestedForm $form) {
            
            $form->select('categories_id','Catégorie')
                ->options(Categorie::all()->pluck('libelle','id'))
                ->load('produits_id', '/admin/api/produit');
            $form->select('produits_id','Produit')->options(function ($id) {
                return Produit::where('id', $id)->pluck('nom', 'id');
            });
             
        });

        $form->saving(function (Form $form) {
            foreach($form->model()->promotion_associations as $association)
                $association->delete();
        });
  
        return $form;
    }
}
