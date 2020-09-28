<?php
	session_start();
	include "db.php";

	if(isset($_SESSION["loggedIn"])) {
		$userId = $_SESSION["loggedIn"];

		$sql = "SELECT COUNT(id) as cartNum FROM carts WHERE userId = '$userId'";
		$result = $conn->query($sql);

		 $cartNum = $result->fetch_row()[0];
	}

	$addOK = 2;

	if(isset($_GET["action"]) && $_GET["action"] == "addToCart" && isset($_GET["id"])) {
		$addOK = 0;
		$productId = $_GET["id"];

		if(isset($_SESSION["loggedIn"])) {
			$sql = "INSERT INTO carts (userId, productId)
										 VALUES ('$userId', '$productId')";

			if ($conn->query($sql) === TRUE) {
			  $addOK = 1;
			} else {
			  echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
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
				<h1 class="highlight">Otkrijte</h1>
				<h1 class="brand"> naš meni </h1>
				<span class="symbol"> &#10059; </span>
				<h2> Drink Hot, Break Fast, Lunch Well. </h2>
			</div>
		</header>

		<main>
			<section id="menu" class="breakpoint" style="display:inherit;">
				<?php if($addOK == 0) { ?>
					<p>Morate se ulogovati da biste dodali proizvod u korpu.</p><br/><br/>
				<?php } ?>
				<?php if($addOK == 1) { ?>
					<p>Uspešno ste dodali proizvod u korpu.</p><br/><br/>
				<?php } ?>
				<form action="" style="display:inline-block">
					<label>
					<input type="radio" name="sort" value="1"> Cena rastuće
				</label>
				<label>
					<input type="radio" name="sort" value="2"> Cena opadajuće
				</label>
				<label>
					<input type="radio" name="sort" value="3"> Naziv (A > Z)
				</label>
				<label>
					<input type="radio" name="sort" value="4"> Naziv (A < Z)
				</label>
				<input type="submit" style="width:auto;" value="Sortiraj">
				</form>
				<br/>
				<br/>
	<div class="row">
<?php
if(isset($_GET["sort"])) {
	$sort = $_GET["sort"];

	switch($sort) {
		case 1:
		$sql = "SELECT *, products.id AS productID FROM products INNER JOIN categories ON products.categoryId = categories.id ORDER BY productPrice ASC";
		break;
		case 2:
		$sql = "SELECT *, products.id AS productID FROM products INNER JOIN categories ON products.categoryId = categories.id ORDER BY productPrice DESC";
		break;
		case 3:
		$sql = "SELECT *, products.id AS productID FROM products INNER JOIN categories ON products.categoryId = categories.id ORDER BY productName ASC";
		break;
		case 4:
		$sql = "SELECT *, products.id AS productID FROM products INNER JOIN categories ON products.categoryId = categories.id ORDER BY productName DESC";
		break;
	}
} else {
	$sql = "SELECT *, products.id AS productID FROM products INNER JOIN categories ON products.categoryId = categories.id";
}
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  // output data of each row
	  while($row = $result->fetch_assoc()) {
?>
	<div class="column" style="background-color:#ddd;">
		<img src="<?php echo $row["productImage"];?>" style="width: 120px;height:120px; border-radius:50%;">
		<hr/>
    <h2><?php echo $row["productName"];?></h2>
		<hr/>
    <p><?php echo $row["productDescription"];?></p>
		<hr/>
		<h2><?php echo $row["productPrice"];?> RSD</h2>
		<hr/>
		<a href="menu.php?action=addToCart&id=<?php echo $row["productID"];?>" style="color:#000;!important">DODAJ U KORPU</a>
  </div>
<?php
		}
	} else {
	echo "Nema proizvoda u ovoj kategoriji.";
}
?>
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
