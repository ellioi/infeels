<!DOCTYPE html>
<html lang="fi">

<head>
<meta charset="UTF-8">
<meta name="author" content="Elli O">
<meta name="keywords" content="larppi, peliohje">
<meta name="description" content="Lomake peliohjeiden syöttämiseen tietokantaan.">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Poista peliohje</title>
<link type="text/css" rel="stylesheet" href="../peliohje.css">
</head>

<body>

<div id="container_muokkaapo">

<h1>Poista peliohje</h1>

<div class="lomake">

<?php	
	include 'dbconfig.php';
	$po_id = $_GET['po_id'];

	// Jos käyttäjä on painanut "poista"-nappulaa, suoritetaan tämä
	if(isset($_POST['submitButton'])){

		try {
			$pdo = new PDO("mysql: host=$servername; dbname=$dbname", $username, $password);
		} catch (PDOException $e) {
			echo "Tietokantaan yhdistäminen epäonnistui.<br/>";
			die();
		}
		
		$sql = "DELETE FROM $potaulukko WHERE ID = :po_id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':po_id', $po_id);
		
		if($stmt->execute()){
			echo "<p>Peliohje poistettu</p>";
			echo "<a href='../pj'>Palaa pj-etusivulle</a>";
		} else {
			echo "<br/><p class='error'>Peliohjeen poistaminen epäonnistui</p>";
			echo "<a href='../pj'>Palaa pj-etusivulle</a>";
		}
		
		//suljetaan tietokanta
		$stmt = null;
		$pdo = null;
		
	} else { // Jos käyttäjä ei vielä painanut "poista"-nappulaa, näytetään poistovarmistusviesti
		echo '<p>Haluatko varmasti poistaa seuraavan peliohjeen?</p>';

		if(isset($_GET['po_id'])){
			try {
				$pdo = new PDO("mysql: host=$servername; dbname=$dbname", $username, $password);
			} catch (PDOException $e) {
				echo "Tietokantaan yhdistäminen epäonnistui.<br/>";
				die();
			}
			
			// haetaan pyydetyn hahmon tiedot tietokannasta
			$sql = "SELECT * FROM $potaulukko WHERE ID = :po_id";
			
			// siirretään tietokannan sisältö riviin
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':po_id', $po_id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_BOTH);
			
			// jos tietokannasta ei löytynyt mitään hakusanalla, näytetään virheilmoitus
			if (empty($result)) {
				echo '<div class="peliohje"><br/><p class="error">Jotain meni pieleen, yritä uudestaan tai ota yhteys ylläpitäjään.</p>
				<p><button class="lomakenappula" onclick="goBack()">Takaisin pj-etusivulle</button></p></div>';
			} else {
				echo '<p><table class="muokkaapo"><tr><th class="muokkaapo">Järjestysnro</th><th class="muokkaapo">Tyyppi</th>
				<th class="muokkaapo">Otsikko</th><th class="muokkaapo">Avausohje 1</th>
				<th class="muokkaapo">Avausohje 2</th></tr>';
				echo '<tr><td class="muokkaapo">'.$result[2].'</td><td class="muokkaapo">';
				if ($result[3] == 0){
					echo 'Normaali';
				}
				if ($result[3] == 1){
					echo 'Jatkopeliohje';
				} 		
				if ($result[3] == 2){
					echo 'Vaihtoehto';
				} 
				echo '</td><td class="muokkaapo">'.$result[4].'</td><td class="muokkaapo">'.$result[5].'</td>
				<td class="muokkaapo">'.$result[6].'</td></tr></table></p>';
			}
			
			//suljetaan tietokanta
			$stmt = null;
			$pdo = null;
			
		} else {
				echo 'Klikkaamassasi linkissä oli kenties väärä osoite tai jotain muuta meni pieleen.
				Yritä uudestaan tai ota ylläpitäjään yhteyttä.';
		}
		
		echo '<p><br/><form method="post" action="poistapo.php?po_id='.$po_id.'">
		<input class="lomakenappula" type="submit" name="submitButton" value="Poista peliohje" /></form></p>';
	}

?> 

</div></div>

</body>
</html>