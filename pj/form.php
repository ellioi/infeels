<!DOCTYPE html>
<html lang="fi">

<head>
<meta charset="UTF-8">
<meta name="author" content="Elli O">
<meta name="keywords" content="larppi, peliohje">
<meta name="description" content="Lomake peliohjeiden syöttämiseen tietokantaan.">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#24a09c">
<meta property="og:image" content="../infeels_some.jpg">
<meta property="og:title" content="IN-Feels peliohjesovellus">
<title>Luo peliohje</title>
<link type="text/css" rel="stylesheet" href="../peliohje.css">
<link rel="manifest" href="../manifest.json">
<script src="../jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="tinymce/tinymce.min.js"></script>

<!-- favicons -->
<link rel="apple-touch-icon" sizes="180x180" href="../favicons/apple-touch-icon-180x180.png">
<link rel="icon" type="image/x-icon" href="../favicons/favicon.ico">
<link rel="icon" type="image/png" href="../favicons/icon-16.png" sizes="16x16">
<link rel="icon" type="image/png" href="../favicons/icon-32.png" sizes="32x32">
<link rel="icon" type="image/png" href="../favicons/icon-192.png" sizes="192x192">
<link rel="icon" type="image/png" href="../favicons/icon-512.png" sizes="512x512">

<script><!-- sisällytetään TinyMCE tekstieditori -->
tinymce.init({
    selector: "#po_sisalto",
    plugins: [
      'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen',
      'insertdatetime media nonbreaking save table contextmenu directionality',
      'emoticons template paste textcolor colorpicker textpattern imagetools'
    ],
    toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    toolbar2: 'print preview media | forecolor backcolor emoticons',
	image_advtab: true
});
</script>
</head>
<body>

<div id="container">

<h1>Luo peliohje</h1>

<div class="lomake">
	<form action="insertpo.php" method="post">
	
	<h3>Metatiedot</h3>
	<p class="plomake">Peliohjeiden lajitteluun ja käsittelyyn tarvitut tiedot.</p>
	
	<p class="plomake"><b>Peliohjekoodi:</b> <input type="text" maxlength="30" name="hahmo_koodi" required />
	<a class="naytaOhje" target="1">Näytä ohje</a></p>
	<div id="ohje1" class="lomakeHint">Hahmokohtainen koodi. Kaikilla tietyn hahmon peliohjeilla pitää olla sama koodi.
	Pelaaja syöttää tämän koodin kenttään, kun hakee oman hahmonsa peliohjesivun. Maksimipituus 30 merkkiä.</div>
	
	<p class="plomake"><b>Peliohjeen järjestysnumero:</b> <input type="number" maxlength="4" name="po_jarjestys" required />
	<a class="naytaOhje" target="2">Näytä ohje</a></p>
	<div id="ohje2" class="lomakeHint">Hahmokohtainen järjestysnumero, joka kertoo mihin järjestykseen peliohjeet lajitellaan
	kyseisen hahmon peliohjesivulla.
	Huomaa, että jatkopeliohjeiden pitää seurata järjestysnumerossa sitä peliohjetta, jonka jälkeen ne tulevat,
	ja uusi päätason peliohje pitää olla suurempi numero kuin edellisen peliohjeen jatkopeliohjeet. 
	Järjestysnumeroita voi skipata, jos et ole varma, tuleeko väliin vielä muita peliohjeita. 
	Eli voit luoda peliohjeet "1" ja "4" ja jättää niiden 
	väliin tilaa vielä kahdelle muulle peliohjeelle. Maksimiarvo saa olla 9999.</div>
	
	<p class="plomake"><b>Peliohjeen tyyppi:</b><br />
	<input type="radio" name="po_tyyppi" value="0" checked /> Normaali<br />
	<input type="radio" name="po_tyyppi" value="1" /> Jatkopeliohje<br />
	<input type="radio" name="po_tyyppi" value="2" /> Vaihtoehto<br />
	</p>
	
	<a class="naytaOhje" target="3">Näytä ohje</a><br/>
	<div id="ohje3" class="lomakeHint"><p><b>Normaali</b> = päätason peliohje, joka tulee kokonaan omaan laatikkoonsa.<br />
	<b>Jatkopeliohje</b> = toisen peliohjeen sisällä oleva peliohje, joita voi olla monta sisäkkäin.</p>
	<p><b>Vaihtoehto</b> = toisen peliohjeen sisällä oleva peliohje, joita on monta vierekkäin. Esimerkiksi jos sinulla on
	peliohje nro 1 (tyypiksi valittu "normaali"), ja peliohjeet nro 2, 3 ja 4, joiden kaikkien tyypiksi valittu "vaihtoehto", 
	niin silloin peliohjeen 1 sisään tulevat alekkain samaan aikaan näkyviin peliohjeet nro 2, 3 ja 4. Jos haluat päätasolle
	vaihtoehtoja, tee nämä vain erillisinä päätason peliohjeina.</p><p>Huom! Selkeyden vuoksi jatkopeliohjeiden sisään
	ei voi lisätä vaihtoehtoja, vaan jatkopeliohjeen jälkeen tuleva vaihtoehto menee suoraan päätason peliohjeen alle.
	Jos haluat jatkopeliohjeen alle vaihtoehtoja, ohjeista pelaaja avaamaan tietty päätason peliohje, esim. "avaa peliohje
	nimeltä X, kun pääset tähän asti" ja sitten X:n avausohje "avaa, kun saat siihen peliohjeen".
	Sen sijaan vaihtoehdon sisälle voi lisätä jatkopeliohjeita, kunhan nämä laittaa numerojärjestyksessä vaihtoehdon jälkeen.</p></div>
	
	<br/><p class="plomake"><b>Väliotsikko:</b> <input type="text" maxlength="50" name="v_otsikko" value="ei" required />
	<a class="naytaOhje" target="4">Näytä ohje</a></p>
	<div id="ohje4" class="lomakeHint">Jos et halua väliotsikkoa, kentässä pitää lukea "ei". Kaikki muu teksti
	tulee näkyviin väliotsikkona. Jos haluat että juuri tämän peliohjeen yläpuolella on väliotsikko, niin kirjoita
	haluamasi otsikkoteksti tähän (max 50 merkkiä). Jos haluat saman väliotsikon alle useamman peliohjeen, laita ne vaan 
	järjestysnumeroissa tämän peliohjeen jälkeen. Peliohjeiden, jotka ovat ennen väliotsikkoa, pitää olla järjestysnumeroissa
	aikaisemmin.</div>
	
	<h3>Avausohje</h3>
	
	<p class="plomake">Ohjeet pelaajalle siitä, milloin peliohje pitää avata. Koko ajan näkyvillä.</p>

	<p class="plomake"><b>Lihavoitu osuus:</b> <br />
	<textarea rows="3" cols="60" maxlength="10000" name="otsikko_bold" required></textarea></p>

	<p class="plomake"><b>Normaali osuus:</b> <br />
	<textarea rows="3" cols="60" maxlength="10000" name="otsikko_normal" required></textarea></p>

	<h3>Sisältö</h3>
	<p class="plomake">Peliohjeen piilossa oleva sisältö. <a class="naytaOhje" target="5">Näytä ohje</a></p>
	<div id="ohje5" class="lomakeHint"><p>Yhden rivinvaihdon saat painamalla shift + enter.</p>
	<p>Kenttään voi kirjoittaa myös html-koodia, mutta se ei ole suositeltua, sillä jotain voi mennä 
	peliohjesivulla rikki sen vuoksi.</p></div>
	
	<textarea rows="35" cols="60" maxlength="100000" name="po_sisalto" id="po_sisalto"></textarea><br /><br />

	<input class="lomakenappula" type="submit" value="Luo peliohje" /> 
	<input class="resetButton" type="reset" value="Tyhjennä lomake">

	</form>
</div>
</div>

<script>
$(document).ready(function(){
  
	$('.naytaOhje').click(function() {
   
	 $('#ohje' + $(this).attr('target')).toggle();
   
	 if ($(this).text() == "Näytä ohje" ) {
		$(this).text("Piilota ohje");
	 }
	 else {
		$ (this).text("Näytä ohje")
	 }
  
	});

});
</script>

</body>
</html>