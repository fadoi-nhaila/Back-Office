var $this,calculate;
var total = 0;


function initCommande()
{
    if($(".has-many-ligne_commandes-form").length == 0)
        $("#has-many-ligne_commandes .add").click();

    $(".has-many-ligne_commandes").append($("<tfoot><tr><td colspan='4' class='title' align ='right'>Total : </td><td class='somme_total' align ='right'></td><td></td></tr></tfoot>"));


    sommeTotalCommande();
    
    $(document).on('select2:select', '.has-many-ligne_commandes select.produits_id', function (event) {
        id= event.params.data.id;
        $this = $(this);
        $.ajax({
            url: "/admin/api/produit-detail",
            type: 'GET',
            "data": {
                "id": id
            },
            success: function (result) {
                $this.closest(".has-many-ligne_commandes-form").find(".prix_total").val(0);
                $this.closest(".has-many-ligne_commandes-form").find(".quantite").val(0);
                $this.closest(".has-many-ligne_commandes-form").find(".prix_unite").val(result.prix);
                
            }
        });
    });


    $(document).on('keyup','#has-many-ligne_commandes .prix_unite',function() {
        if ($(this).val() != '') {
            calculerTotalCommande($(this));
        }
    });

    $(document).on('keyup','#has-many-ligne_commandes .quantite',function() {
        if ($(this).val() != '') {
            calculerTotalCommande($(this));
        }
    });

    $(document).on("click","#has-many-ligne_commandes .remove", function(){
        sommeTotalCommande();
    });
   
}

function calculerTotalCommande(elem)
{
    console.log(elem)
    let quantite = elem.val();
    if(quantite == "" || quantite == 0)
    {
        elem.closest(".has-many-ligne_commandes-form").find(".prix_total").val(0);
    }
    else
    {
        
        let prix =  elem.closest(".has-many-ligne_commandes-form").find(".prix_unite").val();
        let total = quantite * prix;
        elem.closest(".has-many-ligne_commandes-form").find(".prix_total").val(total);
    }

    sommeTotalCommande();
}

function sommeTotalCommande()
{
    let somme_total = 0;

    $(".has-many-ligne_commandes-form .prix_total").each(function(){
        var total = parseFloat($(this).val());
        if(!isNaN(total))
            somme_total += total;
    });

    $(".has-many-ligne_commandes tfoot .somme_total").html(somme_total.toFixed(2));

    $(".title").css({"color": "blue", "font-size": "15px", "font-weight":"bold"});

    $(".somme_total").css({"color": "blue", "font-size": "15px", "font-weight":"bold"});
    
}



