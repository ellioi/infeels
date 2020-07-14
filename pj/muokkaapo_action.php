<!DOCTYPE html>
<html lang="fi">

<head>
<meta charset="UTF-8">
<meta name="author" content="Elli O">
<meta name="keywords" content="larppi, peliohje">
<meta name="description" content="Lomake peliohjeiden syöttämiseen tietokantaan.">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Muokkaa peliohjetta</title>
<link type="text/css" rel="stylesheet" href="../peliohje.css">
</head>

<body>

<div id="container">

<h1>Muokkaa peliohjetta</h1>

<div class="peliohje">

<?php

include 'dbconfig.php';

// Luo variable
$po_id=$_POST['po_id'];
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
$sql = "UPDATE $potaulukko SET hahmo_koodi = :hahmo_koodi, 
	po_jarjestys = :po_jarjestys, 
	po_tyyppi = :po_tyyppi, 
	v_otsikko = :v_otsikko, 
	otsikko_bold = :otsikko_bold, 
	otsikko_normal = :otsikko_normal, 
	po_sisalto = :po_sisalto 
	WHERE ID = :po_id";
$stmt = $pdo->prepare($sql);

$stmt->bindParam(':hahmo_koodi', $hahmo_koodi);
$stmt->bindParam(':po_jarjestys', $po_jarjestys);
$stmt->bindParam(':po_tyyppi', $po_tyyppi);
$stmt->bindParam(':v_otsikko', $v_otsikko);
$stmt->bindParam(':otsikko_bold', $otsikko_bold);
$stmt->bindParam(':otsikko_normal', $otsikko_normal);
$stmt->bindParam(':po_sisalto', $po_sisalto);
$stmt->bindParam(':po_id', $po_id);

if($stmt->execute()){
	echo "<p>Peliohjetta muokattu</p>";
	echo "<a href='../pj'>Palaa pj-etusivulle</a>";
 } else {
	echo "<br/><p class='error'>Peliohjeen muokkaaminen epäonnistui</p></br>";
	echo "<br/><a href='../pj'>Palaa pj-etusivulle</a>";
}

//suljetaan tietokanta
$stmt = null;
$pdo = null;

?>

</div></div>

</body>
</html>