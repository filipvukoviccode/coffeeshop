<?php
	session_start();
	include "db.php";
	include "install.php";

	if(isset($_SESSION["loggedIn"])) {
		$userId = $_SESSION["loggedIn"];

		$sql = "SELECT COUNT(id) as cartNum FROM carts WHERE userId = '$userId'";
		$result = $conn->query($sql);

		 $cartNum = $result->fetch_row()[0];
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Filip Vukovic">
		<meta name="description" content="Coffee shop">
		<title> Coffee Shop </title>
		<link href="https://fonts.googleapis.com/css?family=Allura" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900" rel="stylesheet">
		<link rel="stylesheet" href="./assets/css/styles.css">
	</head>
	<body>
		<header id="na_vrh">
			<div class="gradient">
				<div class="container">
					<h2 id="logo"><a href="index.php"> UŽIVAJTE! </a></h2>
					<img id="open_menu" class="menu_icon show" src="./assets/img/menu.png" >
					<img id="close_menu" class="menu_icon" src="./assets/img/x.png" >
					<nav>
						<a href="#na_vrh" class="menu_link active"> Dobro došli </a>
						<a href="#about" class="menu_link"> O nama </a>
						<a href="#menu" class="menu_link"> Meni </a>
						<a href="#reservation" class="menu_link">Radno vreme </a>
						<?php if(isset(	$_SESSION["loggedIn"] )) { ?>
						<a href="cart.php" class="menu_link" onclick="window.location='cart.php'"> Korpa (<?php echo $cartNum;?>) </a>
						<a href="logout.php" class="menu_link" onclick="window.location='logout.php'"> Odjava </a>
						<?php } else { ?>
						<a href="login.php" class="menu_link" onclick="window.location='login.php'"> Prijava </a>
						<a href="register.php" class="menu_link" onclick="window.location='register.php'"> Registracija </a>
						<?php } ?>
						<a href="#info" class="menu_link"> Kontakt </a>
					</nav>
				</div>
			</div>
			<div class="welcome_container">
				<h1 class="highlight">Dobro došli u</h1>
				<h1 class="brand"> Coffee Shop </h1>
				<span class="symbol"> &#10059; </span>
				<h2> Otvaranje uskoro! </h2>
			</div>
		</header>

		<main>
			<section id="about" class="breakpoint">
				<div class="content">
					<h1 class="highlight"> Otkrijte </h1>
					<h1 class="topic"> našu priču </h1>
					<p class="symbol"> &#10059; </p>
					<p> Priča o našem putu do savršene šoljice kafe počinje 2001. godine. Grupa pasioniranih ljubitelja kafe sastala se i pokrenula pržionicu kafe u Beogradu sa idejom da drugim ljubiteljima ponudi sveže prženu kafu sa poreklom. Coffee Shop konstantno istražuje i razvija svoju ponudu. Ako je Vaš posao vezan za upravljanje kafeom, restoranom ili hotelom i u potrazi ste za nečim posebnim u šoljici kafe, stojimo Vam na usluzi.</p>
					<h2><a href="#"> O nama </a></h2>
				</div>
				<div class="img_container">
					<img src="./assets/img/smoothie.jpg" title="Smoothie in a jar" alt="Smoothie in a jar">
				</div>
			</section>

			<section class="divider">
					<h1 class="highlight"> Ukusno </h1>
					<h1 class="topic"> Preukusno! </h1>
			</section>

			<section id="menu" class="breakpoint">
				<div class="img_container">
					<img class="align_end" src="./assets/img/bowl-menu.jpg" title="Bowl" alt="Bowl">
					<img class="align_end" src="./assets/img/spinach-salad.jpg" title="Spinach salad" alt="Spinach salad">
					<img class="align_start" src="./assets/img/coffee-book.jpg" title="Coffee and book." alt="Coffee and book.">
					<img class="align_start" src="./assets/img/tea.jpg" title="Peppermint tea." alt="Peppermint tea.">
				</div>
				<div class="content">
					<h1 class="highlight"> Otkrijte </h1>
					<h1 class="topic"> naš meni </h1>
					<p class="symbol"> &#10059; </p>
					<p> Drink Hot, Break Fast, Lunch Well. </p>
					<h2><a href="menu.php"> Pogledajte kompletan meni </a></h2>
				</div>
			</section>

			<section class="divider">
					<h1 class="highlight"> Savršena </h1>
					<h1 class="topic"> mešavina </h1>
			</section>

			<section id="reservation" class="breakpoint">
				<div class="content">
					<h1 class="highlight"> Deserti </h1>
					<h1 class="topic"> Poslastice </h1>
					<p class="symbol"> &#10059; </p>
					<p> Od nas, za vas, kod nas. </p>
					<h2><a href="#info"> Rezervišite ovde </a></h2>
				</div>
				<div class="img_container">
					<img src="./assets/img/croissant.jpg" title="Croissant" alt="Croissant">
					<img src="./assets/img/doughnut.jpg" title="Doughnut" alt="Doughnut">
				</div>
			</section>

		</main>

		<footer>
			<div id="top">
				<a href="#na_vrh" class="menu_link">
					<p id="arrow"> &lsaquo; </p>
					<p> Vrh </p>
				</a>
			</div>
			<div id="info" class="breakpoint">
				<div id="locations">
					<h2> Lokacije </h2>
					<div  class="address_container">
						<div class="address1">
							<p> Gandijeva 23 </p>
							<p> Beograd </p>
						</div>
						<div class="address2">
							<p> Cara Dušana 18 </p>
							<p>  Beograd </p>
						</div>
					</div>
				</div>

				<div id="hours">
					<h2> Radno Vreme </h2>
					<div class="open_container">
						<div class="open">
							<p> Ponedeljak - Četvrtak </p>
							<p> 09:00 - 21:00 </p>
						</div>
						<div class="open">
							<p> Petak & Subota </p>
							<p> 10:00 - 22:00 </p>
						</div>
						<div class="open">
							<p> Otvoreno za rezervacije za  </p>
							<p> privatne događaje nedeljom </p>
						</div>
					</div>
				</div>
			</div>
			<div id="kontakt">


				<h2 align="center">Kontaktirajte nas</h2>
				<form action="kontakt.php" align="center" method="post">
					<input type="text" name="ime" placeholder="Ime i prezime"><br />
					<input type="text" name="email" placeholder="e-mail adresa">
					<input type="text" name="telefon" placeholder="Vaš broj telefona">
					<textarea name="poruka" placeholder="Poruka"></textarea>
					<p class="submit" align="center"><input type="submit" value="Pošalji" />
				</form>
			</div>
			<div class="copyright_container">
				<div id="copyright">
						<div>
							<p> Copyright 2020 &copy; Filip Vuković</p>
						</div>

				</div>
			</div>
		</footer>

		<script src="./assets/js/scripts.js"> </script>
	</body>
</html>
