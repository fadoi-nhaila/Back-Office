<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\InfoBox;
use App\Models\Client;


class HomeController extends Controller
{
    

    public function index(Content $content)
    {   

        $content->title('Tableau de bord');
        $content->description('Description...');

        $content->row(function ($row) {
            $row->column(3, new InfoBox('Utilisateurs', 'users', 'aqua', '/admin/auth/users', '1'));
            $row->column(3, new InfoBox('Commandes', 'shopping-cart', 'green', '/admin/commandes', '3'));
            $row->column(3, new InfoBox('Produits', 'product-hunt', 'yellow', '/admin/produits', '3'));
            $row->column(3, new InfoBox('Clients', 'user-plus', 'red', '/admin/clients','2'));

        });
        
        return $content;

        /*return $content
            ->title('Dashboard')
            ->description('Description...')
            ->row(Dashboard::title())
            ->row(function (Row $row) {

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::extensions());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::dependencies());
                });
            });*/
    }
}
