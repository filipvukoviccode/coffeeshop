<?php
	session_start();
	include "db.php";

	if(isset($_SESSION["loggedIn"])) {
		$userId = $_SESSION["loggedIn"];

		$sql = "SELECT COUNT(id) as cartNum FROM carts WHERE userId = '$userId'";
		$result = $conn->query($sql);

		 $cartNum = $result->fetch_row()[0];
	} else {
		header("location: login.php");
		exit;
	}

	$addOK = 0;

	if(isset($_GET["finishOrder"])) {
		$sql = "SELECT products.id AS productID FROM carts INNER JOIN products ON products.id = carts.ProductId INNER JOIN categories ON products.categoryId = categories.id WHERE userId = '$userId'";
		$result = $conn->query($sql);
		$rows = implode(",", $result->fetch_assoc());

		$sql = "INSERT INTO orders (userId, orderedProducts)
									 VALUES ('$userId', '$rows')";

		if ($conn->query($sql) === TRUE) {
			$addOK = 1;
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$sql = "DELETE FROM carts WHERE userId = '$userId'";

		if ($conn->query($sql) === TRUE) {

		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

	$Total = 0;


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
						<a href="#menu" class="menu_link" onclick="window.location='menu.php'"> Menu </a>
						<a href="#reservation" class="menu_link">Working Hours</a>
						<?php if(isset(	$_SESSION["loggedIn"] )) { ?>
						<a href="cart.php" class="menu_link" onclick="window.location='cart.php'"> Shopping Cart (<?php echo $cartNum;?>) </a>
						<a href="logout.php" class="menu_link" onclick="window.location='logout.php'"> Logout </a>
						<?php } else { ?>
						<a href="login.php" class="menu_link" onclick="window.location='login.php'"> Login </a>
						<a href="register.php" class="menu_link" onclick="window.location='register.php'"> Registration </a>
						<?php } ?>
						<a href="#info" class="menu_link"> Contact </a>
					</nav>
				</div>
			</div>
			<div class="welcome_container">
				<h1 class="highlight">Shopping Cart</h1>
				<span class="symbol"> &#10059; </span>
				<h2> Drink Hot, Break Fast, Lunch Well. </h2>
			</div>
		</header>

		<main>
			<section id="menu" class="breakpoint" style="display:inherit;">
				<?php if($addOK == 1) { ?>
					<p>Order has been successfully sent.</p><br/><br/>
				<?php } ?>
				<table id="table">
  <tr>
    <th>Product Name</th>
    <th>Category</th>
    <th>Description</th>
		<th>Price</th>
  </tr>
<?php
	$sql = "SELECT *, products.id AS productID FROM carts INNER JOIN products ON products.id = carts.ProductId INNER JOIN categories ON products.categoryId = categories.id WHERE userId = '$userId'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  // output data of each row
	  while($row = $result->fetch_assoc()) {
			$Total = $Total + $row["productPrice"];
?>
  <tr>
    <td><?php echo $row["productName"];?></td>
    <td><?php echo $row["categoryName"];?></td>
    <td><?php echo $row["productDescription"];?></td>
		<td><?php echo $row["productPrice"];?> RSD</td>
  </tr>
<?php
		}
	} else {
	echo "<p>There is no product in shopping cart.</p>";
}
?>
</table>
<?php if ($result->num_rows > 0) { ?>
<div style="text-align:right">
	<br/>
	<h1>Overall: <?php echo $Total;?>RSD</h1>
</div>
<br/>
<form action="" method="get">
	<input type="submit" name="finishOrder" value="FINISH ORDER">
</form>
<?php } ?>
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
