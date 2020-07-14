<!DOCTYPE html>
<html lang="fi">

<head>
<meta charset="UTF-8">
<meta name="author" content="Elli O">
<meta name="keywords" content="larppi, peliohje">
<meta name="description" content="Lomake peliohjeiden syöttämiseen tietokantaan.">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Luo peliohje</title>
<link type="text/css" rel="stylesheet" href="../peliohje.css">
</head>

<body>

<div id="container">

<h1>Luo peliohje</h1>

<div class="peliohje">

<?php

include 'dbconfig.php';

// Luo variable
$hahmo_koodi=$_POST['hahmo_koodi'];
$po_jarjestys=$_POST['po_jarjestys'];
$po_tyyppi=$_POST['po_tyyppi'];
$v_otsikko=$_POST['v_otsikko'];
$otsikko_bold=$_POST['otsikko_bold'];
$otsikko_normal=$_POST['otsikko_normal'];
$po_sisalto=$_POST['po_sisalto'];

// avataan yhteys tietokantaan
try {
	$pdo = new PDO("mysql: host=$servername; dbname=$dbname", $username, $password);
} catch (PDOException $e) {
	echo "Tietokantaan yhdistäminen epäonnistui.<br/>";
	die();
}

// haetaan pyydetyn hahmon tiedot tietokannasta
$sql = "INSERT INTO $potaulukko (hahmo_koodi,po_jarjestys,po_tyyppi,v_otsikko,otsikko_bold,otsikko_normal,po_sisalto)
 VALUES (?,?,?,?,?,?,?)";
$stmt = $pdo->prepare($sql);

if($stmt->execute([$hahmo_koodi, $po_jarjestys, $po_tyyppi, $v_otsikko, $otsikko_bold, $otsikko_normal, $po_sisalto])){
	echo "<p>Peliohje luotu</p>";
	echo "<a href='form.php'>Palaa lomakkeeseen</a></br><br/>";
	echo "<a href='../pj'>Palaa pj-etusivulle</a>";
} else {
	echo "<br/><p class='error'>Peliohjeen luominen epäonnistui</p>";
	echo "<a href='form.php'>Palaa lomakkeeseen</a><br/><br/>";
	echo "<a href='../pj'>Palaa pj-etusivulle</a>";
}

//suljetaan tietokanta
$stmt = null;
$pdo = null;

?>

</div></div>

</body>
</html>