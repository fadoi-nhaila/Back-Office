<?php

namespace App\Admin\Controllers;

use App\Models\Produit;
use App\Models\Marque;
use App\Models\Categorie;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Admin;
use App\Admin\Actions\BatchRestore;

use Route;

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

        $grid->column('id', 'ID')->sortable()->filter('like');
        $grid->column('categorie.libelle', __('Catégorie'))->sortable()->filter('like');
        $grid->column('marque.libelle', __('Marque'))->sortable()->filter('like');
        $grid->column('nom', __('Nom'))->sortable()->filter('like');
        $grid->column('description', __('Description'))->hide();
        $grid->column('prix', __('Prix'))->sortable()->filter('like')->display(function($prix){
            return number_format($prix, 2, ',', '');
        });
        $grid->column('point_fidelite', __('Point fidélité'))->sortable()->filter('like');
        $grid->column('quantite', __('Quantité'))->sortable()->filter('like');
        $grid->column('image', __('Image'))->gallery(['width' => 50, 'height' => 50,'zooming' => true]);
        $grid->column('created_at', __('Créé à'))->display(function(){
            return $this->created_at->format('d/m/Y');
        })->sortable()->filter('like');
        $grid->column('updated_at', __('Modifé à'))->display(function(){
            return $this->updated_at->format('d/m/Y');
        })->sortable()->filter('like')->hide();


        $tables = ["categorie", "marque"];
        foreach($tables as $table)
        {
            if(request($table."_libelle"))
            {
                $grid->model()->whereHas($table, function ($query) use ($table)  {
                    $query->where('libelle', 'like', "%".request($table."_libelle")."%");
                });
                $url = Route::current()->uri;
                Admin::script('setSearch("'.$table.'-libelle", "'.request($table."_libelle").'", "/'.$url.'");');
            }
        }

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
