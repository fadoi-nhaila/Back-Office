<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\PromotionAssociation;
use App\Models\Promotion;
use App\Models\Categorie;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;




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
        $produit = Produit::where('id', $produit_id)->get(['id', 'categorie_id', 'nom','prix'])->first();
        $promotion = Promotion::where('date_debut', '<=', Carbon::now()->format('Y-m-d'))
                ->where('date_fin', '>=', Carbon::now()->format('Y-m-d'))
                ->join('promotion_associations', 'promotion_associations.promotions_id', 'promotions.id')
                ->where(function($query) use ($produit){
                    $query->where('promotion_associations.produits_id',$produit->id)
                    ->orWhere('promotion_associations.categories_id',$produit->categorie_id);
                })
                ->where('etat_id', 1)
                ->orderBy("promotions.date_debut", "desc")
                ->first();
        
        // if(!empty ($promotion) &&  $promotion->type == "solde")
        //       {
        //       $produit->prix -= $promotion->valeur;
        //     }
        // else{
            
        //     $produit->prix -= $produit->prix*$promotion->valeur/100;
        // }
       
		    
		// }
        //  dd(!is_null($promotion));
        if (!is_null($promotion)){
            switch ($promotion->type) {
                case "solde":
                $produit->prix -= $promotion->valeur;
                break;
                case "pourcentage":
                $produit->prix -= $produit->prix * $promotion->valeur/100;
                break;
            }
            }
        
        return $produit;
    }



    
}


