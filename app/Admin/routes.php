<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('clients', ClientController::class);
    $router->resource('produits', ProduitController::class);
    $router->resource('promotions', PromotionController::class);
    $router->resource('sliders', SliderController::class);
    $router->resource('magasins', MagasinController::class);
    $router->resource('pages', PageController::class);
    $router->resource('villes', VilleController::class);
    $router->resource('marques', MarqueController::class);
    $router->resource('categories', CategorieController::class);
    $router->resource('commandes', CommandeController::class);
    $router->resource('besoin-aides', BesoinAideController::class);
    $router->resource('promotion-associations', PromoAssociationController::class);

Route::group([
        'prefix' => 'api'
    ], function (Router $router) {
        $router->get('produit', 'ApiController@produitParCategorieId');
        $router->get('produit-detail', 'ApiController@produitDetail');
    });

});
