<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\InfoBox;
use App\Models\Client;
use App\Models\Promotion;
use App\Models\Commande;
use App\Models\Produit;




class HomeController extends Controller
{
    

    public function index(Content $content)
    {   

        $content->title('Tableau de bord');
        $content->description('Description...');

        $content->row(function ($row) {
            $row->column(3, new InfoBox('Clients', 'user-plus', 'red', '/admin/clients',$this->getClients()));
            $row->column(3, new InfoBox('Promotions', 'percent', 'aqua', '/admin/promotions',$this->getPromotions()));
            $row->column(3, new InfoBox('Commandes', 'shopping-cart', 'green', '/admin/commandes',$this->getCommandes()));
            $row->column(3, new InfoBox('Produits', 'product-hunt', 'yellow', '/admin/produits', $this->getProduits()));

        });
        
        return $content;

       
    }

    public function getPromotions(){

        $promotion_count = Promotion::all()->count();

        return $promotion_count;
    }
    public function getClients(){

        $client_count = Client::all()->count();

        return $client_count;
    }

    public function getCommandes(){

        $commande_count = Commande::all()->count();

        return $commande_count;
    }

    public function getProduits(){

        $produit_count = Produit::all()->count();

        return $produit_count;
    }
}
