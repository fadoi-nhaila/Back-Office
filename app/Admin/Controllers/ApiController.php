<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produit;

class ApiController extends Controller
{
    
    public function produitParCategorieId(Request $request)
    {
        $categorie_id = $request->get('q');
        $produits = Produit::where('categorie_id', $categorie_id)->get();
        $data = [["0" => ""]];
        foreach($produits as $produit)
        {
            $data[] = ["id" => $produit->id, "text" => $produit->nom];
        }

        return $data;

    }


    public function produitDetail(Request $request)
    {
        $produit_id= $request->get('id');
        $produit = Produit::where('id', $produit_id)->get(['nom','prix'])->first();
        return $produit;
    }
}
