<!DOCTYPE html>
<html>
<head>
	<title>Facture | {{ $commande->reference }}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style type="text/css">

		@page {
            margin: 200px 25px 100px;
        }

		body, #wrapper, #content {
		font-family:sans-serif;
		font-size: 15px;
		}
		table{
		font-family:sans-serif;
		}     
		table tr{
		font-family:sans-serif;
		}    
		table td{
		font-family:sans-serif;
		}   
		table th{
		font-family:sans-serif;
		font-size: 13px;
		font-weight: bold;
		}        
		a:link, a:visited {
		font-family:sans-serif;
		}
		p {
		font-family:sans-serif;
		}

        header {
            position: fixed;
            top: -170px;
            left: 0px;
            right: 0px;
            height: 50px;
        }

        footer {
            position: fixed; 
            bottom: -100px; 
            left: 0px; 
            right: 0px;
            height: 100px; 
        }

        .gris{
        	background-color:wheat;
        }

        .center{
        	text-align: center;
        }

        .border{
        	border: 1px solid #000;
        }

        .space{
        	height: 3px;
        	border: none;
        }

        .padding{
        	padding: 4px 5px;
        }

		.page-number:before {
			content: "Page " counter(page);
		}
	</style>
</head>
<body>

<script type="text/php">
    if (isset($pdf)) {
        $text = "{PAGE_NUM} / {PAGE_COUNT}";
        $size = 10;
        $font = $fontMetrics->getFont("Verdana");
        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
        
        $pdf->page_text($pdf->get_width() - 70, 65, $text, $font, $size);
    }
</script>

<header>
	<table style="width: 100%;">
	    <tr>
	        <td style="text-align: left; width: 50%;">
				<!--<img width="160" src="http://facturation.test/a52b0e4905e97939131ff02388326686.png" />-->
	        </td>
	        <td style="text-align: right; vertical-align: top; width: 50%;" >
	            <table style="width: 100%;" cellpadding="0" cellspacing="0">
	                <tr>
	                    <td colspan="3" class="center border">FACTURE en MAD N° {{ $commande->reference }}</td>
	                </tr>
	                <tr>
	                    <td class="space" colspan="3"></td>
	                </tr>
	                <tr>
	                    <th class="gris center border padding">Date</th>
	                    <th class=" gris center border padding">Code Client</th>
	                    <th class="gris center border padding">Page</th>
	                </tr>
	                <tr>
	                    <td class="center border">{{ date("d/m/Y",  strtotime($commande->date)) }}</td>
	                    <td class="center border">{{ $commande->client->code_barre }}</td>
	                    <td class="center border"></td>
	                </tr>
	            </table>
	        </td>
	    </tr>
	</table>
</header>

<table cellpadding="0" cellspacing="0" class="contenu" style="width: 100%;">
	<tr>
		<td style="width: 50%; vertical-align: top;">
		  	<table cellpadding="0" cellspacing="0" style="width: 100%;" class="infos_societe">
		        <tr>
		        	<td colspan="2">
						Lots Ouafae Rce imane N°205 Appt 3<br>
						Rte Sefrou Fès<br>
						Tél : 0535525252 <br>
						Email : bennounahicham@gmail.com<br><br>
		   			</td>
				</tr>

		   		<tr><td style="width: 60px;">RC</td><td>: 46891</td></tr>
		        <tr><td style="width: 60px;">IF</td><td>: 15261147</td></tr>
		        <tr><td style="width: 60px;">TP</td><td>: 14265014</td></tr>
		        <tr><td style="width: 60px;">CNSS</td><td>: 4475853</td></tr> 
				<tr><td style="width: 60px;">ICE</td><td>: 000137343000049</td></tr>  
				<tr><td style="width: 60px;">RIB</td><td>: 190787212110125251000997</td></tr> 
				<tr><td style="width: 60px;">SWIFT</td><td>: BCPOMAMC</td></tr> 
				<tr><td style="width: 60px;">IBAN</td><td>: MA190787212110125251000997</td></tr> 
			</table>
	    </td>
  	</tr>
</table>

<?php	
	$nbr_pages = 0;
	$nbr = 9;
	$min = 0;
	$max = $nbr;
	while($min < count($commande->ligne_commandes)):
?>
<table style="width: 100%; margin-top: 80px;">
  	<tr>
  		<td colspan="2">
      		<table style="width: 100%;" cellpadding="0" cellspacing="0" class="lignes">
          		<tr>
          			<th class="gris padding border center">Catégorie</th>
          			<th class="gris padding border center">Produit</th>
					<th class="gris padding border center">Prix produit</th>
          			<th class="gris padding border center">Quantité</th>
          			<th class="gris padding border center">Prix total</th>
          		</tr>
          		<tr>
          			<td colspan="5" class="space"></td>
          		</tr>
          		@foreach($commande->ligne_commandes as $k => $ligne)
				@if($k >= $min && $k < $max)
  				<tr>
	              	<td class="padding border" style="text-align: left;">{{ $ligne->categorie->libelle }}</td>
	              	<td class="padding border"  style="text-align: left;">{{ $ligne->produit->nom }}</td>
	              	<td class="padding border"  style="text-align: right;">{{ number_format($ligne->prix_unite,2,"."," ") }}</td>
					<td class="padding border"  style="text-align: right;">{{ $ligne->quantite }}</td>  
	              	<td class="padding border"  style="text-align: right;">{{ number_format(($ligne->prix_unite * $ligne->quantite),2,"."," ") }}</td>
	            </tr>
				@endif
	            @endforeach
      		</table>

      		<!--<table cellpadding="0" cellspacing="0" align="right" style="margin-top: 100px;">
        		<tr><td><img width="150" src="http://promos.test/1b6a5436577bae07b5c8ecd0109cde82.jpg" /></td><td width="30"></td></tr>
      		</table>--> 

      	</td>
  	</tr>
</table>
<?php
	$nbr_pages ++;
	$min += $nbr;
	$max += $nbr;
	endwhile;
?>

<footer>
	<table align="right" class="infos_foot">
	    <tr>
    		<th class="gris center border padding">Mode de règlement</th>
    		<th class="gris center border padding">Total</th>
    	</tr>
    	<tr>
    		<td class="center border padding">{{ $commande->mode_paiement->libelle }}</td>
    		{{-- <td class="center border padding">{{ number_format($commande->total,2,"."," ") }}</td> --}}
    	</tr>
    	<tr>
	  		<td colspan="4" style="text-align: right; padding-right: 10px;">Arrêté la présente facture &agrave; la somme de {{ $chiffre }}</td>
	  	</tr>
	</table>
</footer>
</body>
</html>