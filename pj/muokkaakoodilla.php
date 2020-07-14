<!DOCTYPE html>
<html lang="fi">

<head>
<meta charset="UTF-8">
<meta name="author" content="Elli O">
<meta name="keywords" content="larppi, peliohje">
<meta name="description" content="Peliohjeiden hallinta.">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#24a09c">
<meta property="og:image" content="../infeels_some.jpg">
<meta property="og:title" content="IN-Feels peliohjesovellus">
<title>Muokkaa peliohjeita</title>
<link type="text/css" rel="stylesheet" href="../peliohje.css">
<link rel="manifest" href="../manifest.json">

<!-- favicons -->
<link rel="apple-touch-icon" sizes="180x180" href="../favicons/apple-touch-icon-180x180.png">
<link rel="icon" type="image/x-icon" href="../favicons/favicon.ico">
<link rel="icon" type="image/png" href="../favicons/icon-16.png" sizes="16x16">
<link rel="icon" type="image/png" href="../favicons/icon-32.png" sizes="32x32">
<link rel="icon" type="image/png" href="../favicons/icon-192.png" sizes="192x192">
<link rel="icon" type="image/png" href="../favicons/icon-512.png" sizes="512x512">
</head>
<body>

<div id="container_muokkaapo">

<h1>Muokkaa peliohjeita</h1>

<div class="lomake">

<?php	

	include 'dbconfig.php';
	
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
		echo '<div class="peliohje"><br/><p class="error">Virheellinen peliohjekoodi tai hahmolla ei peliohjeita.</p>
		<p><button class="lomakenappula" onclick="goBack()">Takaisin pj-etusivulle</button></p></div>';
	}
	
	// jos hakusanalla löytyi asioita, näytetään peliohjekoodi
	if (!empty($result)) {
		echo '<p>Alapuolella näet kaikki peliohjeet, joita tietokannasta löytyy koodilla <b><i>'.$hkoodi.'</i></b>.</p>';
		echo '<p><table class="muokkaapo"><tr><th class="muokkaapo">Järjestysnro</th><th class="muokkaapo">Tyyppi</th>
		<th class="muokkaapo">Otsikko</th><th class="muokkaapo">Avausohje 1</th>
		<th class="muokkaapo">Avausohje 2</th><th class="muokkaapo">Muokkaa</th><th class="muokkaapo">Poista</th><th>Kopioi</th></tr>';
	}

	// niin kauan kuin array ei tyhjä, printataan peliohjeita näkyviin
	while (!empty($result)) {
		
		echo '<tr class="muokkaapo"><td class="muokkaapo">'.$result[0][2].'</td><td class="muokkaapo">';
		if ($result[0][3] == 0){
			echo 'Normaali';
		}
		if ($result[0][3] == 1){
			echo 'Jatkopeliohje';
		} 		
		if ($result[0][3] == 2){
			echo 'Vaihtoehto';
		} 
		echo '</td><td class="muokkaapo">'.$result[0][4].'</td><td class="muokkaapo">'.$result[0][5].'</td>
		<td class="muokkaapo">'.$result[0][6].'</td>
		<td class="muokkaapo"><a href="muokkaapo_form.php?po_id='.$result[0][0].'">Muokkaa</a></td>
		<td class="muokkaapo"><a href="poistapo.php?po_id='.$result[0][0].'">Poista</a></td>
		<td class="muokkaapo"><a href="kopioipo_form.php?po_id='.$result[0][0].'">Kopioi</a></td></tr>';
	
		array_shift($result); // poistetaan printattu rivi taulukosta
	
		// kun taulukko tyhjä, suljetaan table
		if (empty($result)) {
		echo '</table></p>';
		}
	
	}

	//suljetaan tietokanta
	$stmt = null;
	$pdo = null;
?> 

</div>

<p><br/></p><p align="center"><button class="palaaTakaisin" onclick="goBack()">Takaisin pj-etusivulle</button></p>

</div>

<!-- Takaisin-nappi -->
<script>
function goBack() {
  window.history.back();
}
</script>

</body>
</html>