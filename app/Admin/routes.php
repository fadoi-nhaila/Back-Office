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
    $router->resource('adresses', AdresseController::class);
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
    $router->resource('parametres', ParametreController::class);
    $router->resource('liste-courses', ListeCourseController::class);
    $router->resource('mode-paiements', ModePaiementController::class);
    $router->resource('etats', EtatController::class);
    $router->resource('options', OptionController::class);
    $router->resource('parametres', ParametreController::class);
    $router->resource('etat-promos', EtatPromoController::class);
    $router->get('commandes/{id}/print', 'CommandeController@print');

Route::group([
        'prefix' => 'api'
    ], function (Router $router) {
        $router->get('produit', 'ApiController@produitParCategorieId');
        $router->get('produit-detail', 'ApiController@produitDetail');

    });

});
