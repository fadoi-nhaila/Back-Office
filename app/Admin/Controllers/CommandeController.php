<?php

namespace App\Admin\Controllers;

use App\Models\Commande;
use App\Models\Produit;
use App\Models\Client;
use App\Models\Categorie;
use App\Models\ModePaiement;
use App\Models\LigneCommande;
use App\Models\Etat;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
Use Encore\Admin\Admin;
use App\Admin\Actions\BatchRestore;
use App\Admin\Chiffres;
use Carbon\Carbon;
use App\Admin\Actions\Imprimer;
use Illuminate\Support\Facades\DB;


use Route;
use Barryvdh\DomPDF\Facade as PDF;
use App;

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
        
        $grid->column('id', __('ID'))->sortable()->filter('like');
        $grid->column('date', __('Date'))->sortable()->filter('range','date');
        $grid->column('reference', __('Référence'))->sortable()->filter('like');
        $grid->column('client.nom', __('Client'))->sortable()->filter('like');
        $grid->column('mode_paiement.libelle', __('Mode de Paiement'))->sortable()->filter('like');
        $grid->column('etat.libelle', __('Etat'))->sortable()->filter('like');
        $grid->column('created_at', __('Créé à'))->display(function(){
            return $this->created_at->format('d/m/Y');
        })->sortable()->filter('range','date')->hide();
        $grid->column('updated_at', __('Modifé à'))->display(function(){
            return $this->updated_at->format('d/m/Y');
        })->sortable()->filter('range','date')->hide();

        $tables = ["mode_paiement","etat"];
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

        $tablee = "client";
        if(request($tablee."_nom"))
        {
            $grid->model()->whereHas($tablee, function ($query) use ($tablee) {
                $query->where('nom', 'like', "%".request($tablee."_nom")."%");
            });
            $url = Route::current()->uri;
            Admin::script('setSearch("'.$tablee.'-nom", "'.request($tablee."_nom").'", "/'.$url.'");');
        }

        
        $grid->actions (function ($actions) {

            $actions->disableView();
            $actions->append('<a target="_blank" href="'.$this->getResource().'/'.$this->getKey().'/print"><i class="fa fa-print"></i></a>');

        
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
        
        $form->text('reference', __('Référence'))->required()->default(Commande::commandeReference())->width('110px');
        $form->date('date', __('Date'))->placeholder('mm/dd/yyyy')->format('DD/MM/YYYY')->required();
        $form->select('client_id', __('Client'))->options(Client::all()->pluck('nom','id'))->required()->setWidth(5, 2);
        $form->select('paiement_id', __('Mode Paiement'))->options(ModePaiement::all()->pluck('libelle','id'))->required()->setWidth(5, 2);
        $form->select('etat_id', __('Etat'))->options(Etat::all()->pluck('libelle','id'))->required()->setWidth(5, 2);

       
        $form->divider();
        

        $form->table('ligne_commandes','', function (Form\NestedForm $form) {
            
            $form->select('categories_id','Catégorie')
                 ->options(Categorie::all()->pluck('libelle','id'))
                 ->load('produits_id', '/admin/api/produit');
            $form->select('produits_id','Produit')->options(function ($id) {
                return Produit::where('id', $id)->pluck('nom', 'id');
            });
            $form->decimal('prix_unite', __('Prix unité'))->placeholder('Prix unité')->required()->prepend(false)->width('80px');
            $form->decimal('quantite', __('Quantité'))->placeholder('Quantité')->prepend(false)->width('80px');
            $form->decimal('prix_total', __('Prix total'))->placeholder('Prix total')->required()->prepend(false)->width('80px');
                
        });

        $form->saving(function (Form $form) {
            foreach($form->model()->ligne_commandes as $ligne)
                $ligne->delete();
        });


        $form->saved(function (Form $form) {
            
            foreach($form->model()->ligne_commandes as $ligne){

            $quantitie = DB::table('produits')->where('id', 37)->pluck('quantite')->first();
            $newQuantitie = $quantitie - $ligne->quantite;
            DB::table('produits')->where('id', 37)->update(['quantite' => $newQuantitie]);
        
        }

        });

        Admin::script('$(function(){initCommande()})');
  
        return $form;

    }

    public function print($id)
    {
        $commande = Commande::find($id);
        $chiffres = new Chiffres(round($commande->total,2),'MAD');
        $chiffre = $chiffres->convert("fr-FR");
        
        $pdf = PDF::loadView("facture.imprimer", compact('commande','chiffre'))->setOptions(['isPhpEnabled' => true, 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,'defaultFont' => 'sans-serif']);
        return $pdf->stream();
        //return $pdf->download($commande->reference.'.pdf');
    }

 
}
