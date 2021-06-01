<?php

namespace App\Admin\Controllers;

use App\Models\Client;
use App\Models\Ville;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
Use Encore\Admin\Widgets\Table;


class ClientController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Clients';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Client());
        
        $grid->model()->orderBy('id', 'DESC');

        $grid->column('id', 'ID')->sortable()->filter('like');
        $grid->column('nom', __('Nom'))->sortable()->filter('like')->expand(function ($model) {

            $adresses = $model->adresses()->take(5)->get()->map(function ($adresse) {
                return $adresse->only(['id','ville', 'quartier','rue','numero']);
            });
        
            return new Table(['ID', 'Ville', 'Quartier','Rue','Numéro'], $adresses->toArray());
        });;
        $grid->column('prenom', __('Prénom'))->sortable()->filter('like');
        $grid->column('sexe', __('Sexe'))->sortable()->filter('like');
        $grid->column('telephone', __('Téléphone'))->sortable()->filter('like');
        $grid->column('email', __('Email'))->sortable()->filter('like');
        $grid->column('code_barre', __('Code barre'))->sortable()->filter('like');
        $grid->column('solde_fidelite', __('Solde fidélité'))->sortable()->filter('like');
        $grid->column('created_at', __('Créé à'))->display(function(){
            return $this->created_at->format('d/m/Y');
        })->sortable()->filter('range','date');
        $grid->column('updated_at', __('Modifé à'))->display(function(){
            return $this->updated_at->format('d/m/Y');
        })->sortable()->filter('range','date')->hide();

        $grid->actions(function ($actions) {
           
            $actions->disableView();
            
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
        $show = new Show(Client::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('nom', __('Nom'));
        $show->field('prenom', __('Prénom'));
        $show->field('sexe', __('Sexe'));
        $show->field('telephone', __('Téléphone'));
        $show->field('email', __('Email'));
        $show->field('code_barre', __('Code barre'));
        $show->field('solde_fidelite', __('Solde fidélité'));
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
        $form = new Form(new Client());

        $form->text('nom', __('Nom'))->placeholder('Entrez nom')->required();
        $form->text('prenom', __('Prénom'))->placeholder('Entrez prénom')->required();
        $form->radio('sexe', __('Sexe'))->options(['H'=> 'Homme','F' => 'Femme'])->default('H')->required();
        $form->mobile('telephone', __('Téléphone'))->options(['mask' => '9999999999'])->placeholder('Entrez téléphone')->required();
        $form->email('email', __('Email'))->placeholder('Entrez email')->required();
        $form->text('code_barre', __('Code barre'))->placeholder('Entrez code barre')->required();
        $form->decimal('solde_fidelite', __('Solde fidélité'))->default('0')->prepend(false);
        
        $form->divider();

        $form->table('adresses', function (Form\NestedForm $form) {
            $form->select('ville_id', __('Ville'))->options(Ville::all()->pluck('nom','id'))->required();
            $form->text('quartier', __('Quartier'))->placeholder('Quartier')->required()->prepend(false);
            $form->text('rue', __('Rue'))->placeholder('Rue')->required()->prepend(false);
            $form->decimal('numero', __('Numéro'))->placeholder('Numéro')->required()->prepend(false);
        });

        $form->saving(function (Form $form) {
            foreach($form->model()->adresses as $adresse)
                $adresse->delete();
        });
          

        return $form;
    }
}
