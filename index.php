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
					<h2 id="logo"><a href="index.php"> ENJOY! </a></h2>
					<img id="open_menu" class="menu_icon show" src="./assets/img/menu.png" >
					<img id="close_menu" class="menu_icon" src="./assets/img/x.png" >
					<nav>
						<a href="#na_vrh" class="menu_link active"> Welcome </a>
						<a href="#about" class="menu_link"> About Us </a>
						<a href="#menu" class="menu_link"> Menu </a>
						<a href="#reservation" class="menu_link"> Working Hours </a>
						<?php if(isset(	$_SESSION["loggedIn"] )) { ?>
						<a href="cart.php" class="menu_link" onclick="window.location='cart.php'"> Shopping Cart (<?php echo $cartNum;?>) </a>
						<a href="logout.php" class="menu_link" onclick="window.location='logout.php'"> Logout </a>
						<?php } else { ?>
						<a href="login.php" class="menu_link" onclick="window.location='login.php'"> Login </a>
						<a href="register.php" class="menu_link" onclick="window.location='register.php'"> Register </a>
						<?php } ?>
						<a href="#info" class="menu_link"> Contact </a>
					</nav>
				</div>
			</div>
			<div class="welcome_container">
				<h1 class="highlight">Welcome to</h1>
				<h1 class="brand"> Coffee Shop </h1>
				<span class="symbol"> &#10059; </span>
				<h2> Opening soon! </h2>
			</div>
		</header>

		<main>
			<section id="about" class="breakpoint">
				<div class="content">
					<h1 class="highlight"> Discover </h1>
					<h1 class="topic"> our story </h1>
					<p class="symbol"> &#10059; </p>
					<p> The story of our journey to the perfect cup of coffee begins in 2001. A group of passionate coffee lovers met and started a coffee roaster in Belgrade with the idea of offering coffee lovers freshly roasted coffee with origin. Coffee Shop is constantly researching and developing its offer. If your job is related to managing a cafe, restaurant or hotel and you are looking for something special in a cup of coffee, we are at your service.</p>
					<h2><a href="#"> About Us </a></h2>
				</div>
				<div class="img_container">
					<img src="./assets/img/smoothie.jpg" title="Smoothie in a jar" alt="Smoothie in a jar">
				</div>
			</section>

			<section class="divider">
					<h1 class="highlight"> Tasteful </h1>
					<h1 class="topic"> Delicious! </h1>
			</section>

			<section id="menu" class="breakpoint">
				<div class="img_container">
					<img class="align_end" src="./assets/img/bowl-menu.jpg" title="Bowl" alt="Bowl">
					<img class="align_end" src="./assets/img/spinach-salad.jpg" title="Spinach salad" alt="Spinach salad">
					<img class="align_start" src="./assets/img/coffee-book.jpg" title="Coffee and book." alt="Coffee and book.">
					<img class="align_start" src="./assets/img/tea.jpg" title="Peppermint tea." alt="Peppermint tea.">
				</div>
				<div class="content">
					<h1 class="highlight"> Discover </h1>
					<h1 class="topic"> our menu </h1>
					<p class="symbol"> &#10059; </p>
					<p> Drink Hot, Break Fast, Lunch Well. </p>
					<h2><a href="menu.php"> Take a look at complete menu </a></h2>
				</div>
			</section>

			<section class="divider">
					<h1 class="highlight"> Perfect blend </h1>
					<h1 class="topic"> blend </h1>
			</section>

			<section id="reservation" class="breakpoint">
				<div class="content">
					<h1 class="highlight"> Deserts </h1>
					<h1 class="topic"> Sweets </h1>
					<p class="symbol"> &#10059; </p>
					<p> From us, to you, at our place. </p>
					<h2><a href="#info"> Reserve here </a></h2>
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
					<p> Top </p>
				</a>
			</div>
			<div id="info" class="breakpoint">
				<div id="locations">
					<h2> Locations </h2>
					<div  class="address_container">
						<div class="address1">
							<p> Gandijeva 23 </p>
							<p> Belgrade </p>
						</div>
						<div class="address2">
							<p> Cara Dušana 18 </p>
							<p>  Belgrade </p>
						</div>
					</div>
				</div>

				<div id="hours">
					<h2> Working Hours </h2>
					<div class="open_container">
						<div class="open">
							<p> Monday - Thursday </p>
							<p> 09:00 - 21:00 </p>
						</div>
						<div class="open">
							<p> Friday & Saturday </p>
							<p> 10:00 - 22:00 </p>
						</div>
						<div class="open">
							<p> Open for reservations for  </p>
							<p> private events on Sunday </p>
						</div>
					</div>
				</div>
			</div>
			<div id="kontakt">


				<h2 align="center">Contact Us</h2>
				<form action="kontakt.php" align="center" method="post">
					<input type="text" name="ime" placeholder="First and Last Name"><br />
					<input type="text" name="email" placeholder="e-mail address">
					<input type="text" name="telefon" placeholder="Your phone number">
					<textarea name="poruka" placeholder="Message"></textarea>
					<p class="submit" align="center"><input type="submit" value="Send" />
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
