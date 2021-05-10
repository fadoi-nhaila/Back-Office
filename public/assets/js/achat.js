var $this, selected, calculate;
var total = 0;


function initAchat()
{
    if($(".has-many-listeAchats-form").length == 0)
        $("#has-many-listeAchats .add").click();

    $(".has-many-listeAchats").append($("<tfoot><tr><td colspan='4' class='title' align ='right'>Total : </td><td class='somme_total' align ='right'></td><td></td></tr></tfoot>"));

    sommeTotalPurchase();
    
    $(document).on('select2:select', '.has-many-listeAchats select.produit_id', function (event) {
        id = event.params.data.id;
        $this = $(this);
        $.ajax({
            url: "/admin/api/produit-detail",
            type: 'GET',
            "data": {
                "id": id
            },
            success: function (result) {
                $this.closest(".has-many-listeAchats-form").find(".prix_total").val(0);
                $this.closest(".has-many-listeAchats-form").find(".quantite").val(0);
                $this.closest(".has-many-listeAchats-form").find(".prix_unite").val(result.prix);
            }
        });
    });


    $(document).on('keyup','#has-many-listeAchats .prix_unite',function() {
        if ($(this).val() != '') {
            calculateTotalPurchase($(this));
        }
    });

    $(document).on('keyup','#has-many-listeAchats .quantite',function() {
        if ($(this).val() != '') {
            calculateTotalPurchase($(this));
        }
    });

    $(document).on("click","#has-many-listeAchats .remove", function(){
        sommeTotalPurchase();
    });
   
}

function calculateTotalPurchase(elem)
{
    console.log(elem)
    let quantite = elem.val();
    if(quantite == "" || quantite == 0)
    {
        elem.closest(".has-many-listeAchats-form").find(".prix_total").val(0);
    }
    else
    {
        let prix =  elem.closest(".has-many-listeAchats-form").find(".prix_unite").val();
        let total = quantite * prix;
        elem.closest(".has-many-listeAchats-form").find(".prix_total").val(total.toFixed(2));
    }

    sommeTotalPurchase();
}

function sommeTotalPurchase()
{
    let somme_total = 0;

    $(".has-many-listeAchats-form .prix_total").each(function(){
        var total = parseFloat($(this).val());
        if(!isNaN(total))
            somme_total += total;
    });

    $(".has-many-listeAchats tfoot .somme_total").html(somme_total.toFixed(2));

    $(".title").css({"color": "blue", "font-size": "15px", "font-weight":"bold"});

    $(".somme_total").css({"color": "blue", "font-size": "15px", "font-weight":"bold"});



    
}



