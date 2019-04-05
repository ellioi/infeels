<!DOCTYPE html>
<html lang="fi">

<head>
<meta charset="UTF-8">
<meta name="author" content="Elli O">
<meta name="keywords" content="larp, larppi, liveroolipeli, roolipeli, digitaalinen, peliohje, app, sovellus">
<meta name="description" content="IN-Feels: web-sovellus larppien peliohjeisiin.">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#24a09c">
<meta property="og:image" content="infeels_some.jpg">
<meta property="og:title" content="IN-Feels peliohjesovellus">
<title>IN-Feels peliohjesovellus</title>
<link type="text/css" rel="stylesheet" href="peliohje.css">
<link rel="manifest" href="manifest.json">
<script src="jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="main.js" type="text/javascript"></script>

<!-- favicons -->
<link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon-180x180.png">
<link rel="icon" type="image/x-icon" href="favicons/favicon.ico">
<link rel="icon" type="image/png" href="favicons/icon-16.png" sizes="16x16">
<link rel="icon" type="image/png" href="favicons/icon-32.png" sizes="32x32">
<link rel="icon" type="image/png" href="favicons/icon-192.png" sizes="192x192">
<link rel="icon" type="image/png" href="favicons/icon-512.png" sizes="512x512">
</head>
<body>

<div id="container">

<h1>Peliohjeet</h1>

<?php

error_reporting(0);
include 'pj/dbconfig.php';

// Määritellään rekursiivinen funktio jatkopeliohjeiden tulostamiseen
function tulostaJatko($taul) {
	echo '<p class="kuvaus"><b>'.$taul[0][5].'</b> '.$taul[0][6].'</p>';
	echo '<a class="showSingle" target="'.$taul[0][2].'">Näytä</a><br /><br />';
	echo '<div id="po'.$taul[0][2].'" class="poContentJatko"><p>'.$taul[0][7].'</p><br />';
	
	array_shift($taul);

	if (!empty($taul) && $taul[0][3] == 1) {
		tulostaJatko($taul);
	}
	
	echo "</div>";
	
}

// Määritellään funktio vaihtoehtopeliohjeiden tulostamiseen
function tulostaVaihto($taul2) {
	echo '<p class="kuvausVaihto"><b>'.$taul2[0][5].'</b> '.$taul2[0][6].'</p>';
	echo '<a class="showSingle" target="'.$taul2[0][2].'">Näytä</a><br /><br />';
	echo '<div id="po'.$taul2[0][2].'" class="poContentVaihto"><p>'.$taul2[0][7].'</p><br />';
	
	array_shift($taul2);
	
	if (!empty($taul2) && $taul2[0][3] == 1) {
		echo '<div class="containerJatko">';
		tulostaJatko($taul2);
		echo '</div><br />';
	}
	
	echo "</div>";
}

// Jos käyttäjä on painanut "hae"-nappulaa, suoritetaan tämä
if(isset($_POST['submitButton'])){

	// avataan yhteys tietokantaan
	try {
		$pdo = new PDO("mysql: host=$servername; dbname=$dbname", $username, $password);
	} catch (PDOException $e) {
		echo "Tietokantaan yhdistäminen epäonnistui.<br/>";
		die();
	}
	
	// haetaan pyydetyn hahmon tiedot tietokannasta
	$sql = "SELECT * FROM $potaulukko WHERE hahmo_koodi = :hkoodi ORDER BY po_jarjestys";
	$hkoodi = $_POST['hkoodi'];

	// siirretään tietokannan sisältö multidimensional arrayyn
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':hkoodi', $hkoodi);
	$stmt->execute();
	$result = $stmt->fetchAll();

	// jos tietokannasta ei löytynyt mitään hakusanalla, näytetään virheilmoitus
	if (empty($result)) {
		echo '<div class="peliohje"><br/><p class="error">Virheellinen hahmokoodi tai hahmolla ei peliohjeita.</p>
		<p><button class="lomakenappula" onclick="goBack()">Takaisin hakuun</button></p></div>';
	}

	// niin kauan kuin array ei tyhjä, printataan peliohjeita näkyviin
	while (!empty($result)) {
		
		if ($result[0][4] != 'ei') { // tulostetaan väliotsikko jos määritelty
			echo '<h2>'.$result[0][4].'</h2>';
		}
		
		echo '<div class="peliohje">';
		echo '<p class="kuvaus"><b>'.$result[0][5].'</b> '.$result[0][6].'</p>';
		echo '<a class="showSingle" target="'.$result[0][2].'">Näytä</a>';
		echo '<div id="po'.$result[0][2].'" class="poContent"><p>'.$result[0][7].'</p><br />';
	
		array_shift($result); // poistetaan printattu rivi taulukosta
		
		// tulostetaan jatkopeliohjeet
		if (!empty($result) && $result[0][3] == 1) {
			echo '<div class="containerJatko">';
			tulostaJatko($result);
			echo '</div>';
		}
		
		// tulostetaan vaihtoehtopeliohjeet
		while (!empty($result) && $result[0][3] == 2) {
			tulostaVaihto($result);
			array_shift($result);
			
			while (!empty($result) && $result[0][3] == 1) {
				array_shift($result);
			}
		}
		
		// poistetaan yllä tulostetut jatko- ja vaihtoehto-ohjeet
		while (!empty($result) && ($result[0][3] == 1 || $result[0][3] == 2)) {
			array_shift($result);
		}
		
		echo "</div></div>";
	}

	//suljetaan tietokanta
	$stmt = null;
	$pdo = null;

} else { // Jos käyttäjä ei vielä painanut "hae"-nappulaa, näytetään hakukenttä
	echo '<div class="peliohje"><p>
	<form method="post" action="index.php">
	Peliohjekoodi: <input type="text" maxlength="30" name="hkoodi" required />
	<input class="lomakenappula" type="submit" name="submitButton" value="Hae" />
	<br/></p></form>
	</div>';
}

?> 

</div><!------- container ends ----------->

<!-- Näytä/Piilota nappulan script -->
<script>
$(document).ready(function(){
  
  
	$('.showSingle').click(function() {
   

	 $('#po' + $(this).attr('target')).toggle();

	 $(this).toggleClass('showSingle');
	 $(this).toggleClass('poVisible'); 
   
	 if ($(this).text() == "Näytä" ) {
		$(this).text("Piilota");
	 }
	 else {
		$ (this).text("Näytä")
	 }
  
	});

});
</script>

<!-- Takaisin-nappi -->
<script>
function goBack() {
  window.history.back();
}
</script>

</body>
</html> 