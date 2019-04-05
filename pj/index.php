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
<title>Pelinjohdon työkalut</title>
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

<div id="container">

<h1>Pelinjohdon työkalut</h1>

<?php	

include 'dbconfig.php';

// suoritetaan tämä jos "luo taulukko" nappia painettu
if(isset($_POST['submitButton'])){ 
	
	$ttaul = $_POST['ttaul'];

	// avataan yhteys
	try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
	// luodaan taulukko
	$sql = "CREATE TABLE $ttaul (
		ID INT(30) AUTO_INCREMENT PRIMARY KEY,
		hahmo_koodi VARCHAR(30) NOT NULL,
		po_jarjestys TINYINT(4) NOT NULL,
		po_tyyppi TINYINT(10) DEFAULT 0 NOT NULL,
		v_otsikko TINYTEXT NOT NULL,
		otsikko_bold TEXT NOT NULL,
		otsikko_normal TEXT NOT NULL,
		po_sisalto MEDIUMTEXT NOT NULL,
		UNIQUE (ID)
	)";
	
	// onnistumisviestit
    $pdo->exec($sql);
	echo "<div class='lomake'><p class='success'>TAULUKKO LUOTU ONNISTUNEESTI.<br/></p></div>";
	
	} catch(PDOException $e) {
		echo "<div class='lomake'><p class='error'>Taulukon luominen epäonnistui. Tarkista:<br/>
	1. Tiedot dbconfig.php tiedostossa ovat oikein<br/>
	2. Tietokannassa ei ole jo samannimistä taulukkoa<br/>
	3. Tietokannan nimessä ei ole erikoismerkkejä</p></div>";
	}

	$pdo = null;	
}
?> 

<div class="lomake">
	<h3>Luo peliohje</h3>
	<p><a href="form.php"> --- Luo uusi peliohje</a><br/><br/><br/></p>
	<p class="error">Ennen kuin aloitat syöttämään peliohjeita ensimmäistä kertaa, 
	muista tehdä alla kuvaillut asiat!</p>
</div>

<div class="lomake">
	<h3>Tietokannan tiedot</h3>
	<p>Muista muuttaa tietokantasi kirjautumistiedot tiedostoon <i>dbconfig.php</i>.
	Avaa kyseinen tiedosto esim. Notepadilla muokataksesi sitä.<br/><br/></p>
</div>

<div class="lomake">
	<h3>Salasanasuojaus</h3>
	<p>Muista suojata tämä kansio salasanalla, jotta tuntemattomat eivät pääse
	syöttämään juttuja tietokantaasi! Kansiolle voi asettaa salasanasuojauksen esim. cPanelista.</p>
</div>

<div class="lomake">
	<h3>Luo taulukko</h3>
	<p class="plomake">Tee tämä sitten, kun olet luonut tietokannan tai sinulla on jo olemassa oleva tietokanta.
	On suositeltavaa, että jokaista eri larppia varten on oma taulukko ja oma In-Feels-asennus omassa kansiossaan.
	Taulukko tarvitsee luoda vain kerran yhtä larppia varten.</p>
	
	<p class="plomake">Huomaa, että erikoismerkit, esim. "-" eivät ole sallittuja. "_" on sallittu.</p>
	
	<form action="index.php" method="post">
	<p class="plomake"><b>Anna taulukolle nimi:</b> <input type="text" maxlength="30" name="ttaul" value="peliohjeet" required /></p>
	<p><input class="lomakenappula" type="submit" name="submitButton" value="Luo taulukko" /></p>
	</form>
</div>

</div>

</body>
</html>