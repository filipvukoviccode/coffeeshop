<?php
  session_start();
  include "db.php";

  if(!isset($_SESSION["adminLogin"])) {
    $logOk = 1;
    	if($_SERVER["REQUEST_METHOD"] == "POST") {
    		$email = $_POST["email"];
    		$password = $_POST["password"];

    		$sql = "SELECT id, email, password FROM admins WHERE email = '$email'";
    		$result = $conn->query($sql);

    		if ($result->num_rows > 0) {
    		  $row = $result->fetch_row();

    			if(password_verify($password, $row[2])) {
    				$_SESSION["adminLogin"] = $row[0];

    				header("location: admin.php");
    				exit;
    			}
    		}
    		$logOk=0;
    	}
  } else {
    if($_SERVER["REQUEST_METHOD"] == "POST") {
      if(isset($_POST["categoryName"])) {
        $categoryName = $_POST["categoryName"];

        $sql = "INSERT INTO categories (categoryName)
  										 VALUES ('$categoryName')";

  			if ($conn->query($sql) === TRUE) {
  			  $addOK = 1;
  			} else {
  			  echo "Error: " . $sql . "<br>" . $conn->error;
  			}
      }

      if(isset($_POST["productName"])) {
        $productName = $_POST["productName"];
        $categoryId = $_POST["categoryId"];
        $productDescription = $_POST["productDescription"];
        $productPrice = $_POST["productPrice"];

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


        if (file_exists($target_file)) {
          $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
          $uploadOk = 0;
        }

          if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            //
          }

          if($uploadOk == 1) {
        $sql = "INSERT INTO products (productName, productImage, categoryId, productDescription, productPrice)
  										 VALUES ('$productName', '$target_file', '$categoryId', '$productDescription', '$productPrice')";

  			if ($conn->query($sql) === TRUE) {
  			  $addOK = 1;
  			} else {
  			  echo "Error: " . $sql . "<br>" . $conn->error;
  			}
      } else {
        header("location: admin.php?Message=UploadError");
        exit;
      }
      }

      if(isset($_POST["email"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO admins (email, password)
  										 VALUES ('$email', '$password')";

  			if ($conn->query($sql) === TRUE) {
  			  $addOK = 1;
  			} else {
  			  echo "Error: " . $sql . "<br>" . $conn->error;
  			}
      }

      header("location:admin.php");
      exit;
    }
  }
?>
<html>
<head>
  <title>Admin Panel</title>
  <link href="https://fonts.googleapis.com/css?family=Allura" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body>
<?php if(!isset($_SESSION["adminLogin"])) { ?>
  <main>
    <section id="menu" class="breakpoint" style="display:inherit;">
      <h2 style="font-size:25px;">Admin Panel</h2>
      <hr/>
    <?php if($logOk == 0) { ?>
      <p>Pogresan email ili lozinka.</p><br/><br/>
    <?php } ?>
    <div>
    <form action="" method="post">
      <input type="text" name="email" placeholder="E-Mai Adresa" required>
      <input type="password" name="password" placeholder="Lozinka" required>
      <input type="submit" value="PRIJAVI ME">
    </form>
  </div>
    </section>

  </main>
<?php } else { ?>
  <main>
    <section id="menu" class="breakpoint" style="display:inherit;">
      <h2 style="font-size:25px;">Pregled Porudžbina</h2>
      <hr/>
      <?php
      $sql = "SELECT * FROM orders";
    	$result = $conn->query($sql);

    	if ($result->num_rows > 0) {
    	  // output data of each row
    	  while($row = $result->fetch_assoc()) {
          $Total = 0;
          $userId = $row["userId"];
          $sql = "SELECT firstName, lastName, email, address, city, zipCode, country FROM users WHERE id = '$userId'";
      		$result1 = $conn->query($sql);
      		  $userData = $result1->fetch_row();
      ?>
        <b>Podaci o Korisniku:</b> <?php echo implode(", ", $userData);?><br/><br/>
        <table id="table">
  <tr>
    <th>Naziv Proizvoda</th>
    <th>Kategorija</th>
    <th>Opis</th>
		<th>Cena</th>
  </tr>
<?php
foreach(explode(",", $row["orderedProducts"]) as $productId) {
	$sql = "SELECT * FROM products INNER JOIN categories ON products.categoryId = categories.id WHERE products.id = '$productId'";
	$result2 = $conn->query($sql);

	  $row2 = $result2->fetch_row();
			$Total = $Total + $row2["5"];
?>
  <tr>
    <td><?php echo $row2[2];?></td>
    <td><?php echo $row2[8];?></td>
    <td><?php echo $row2[4];?></td>
		<td><?php echo $row2[5];?> RSD</td>
  </tr>
<?php
		}
?>
</table>
<div style="text-align:right">
	<br/>
	<h1>UKUPNO: <?php echo $Total;?>RSD</h1>
</div>
        <hr/>
      <?php
    } }
    ?>
    <br/><br/>
    <h2 style="font-size:25px;">Pregled Kategorija</h2>
    <hr/>
    <?php
    $sql = "SELECT categoryName FROM categories";
    $result = $conn->query($sql);
    ?>
    <b>Postojeće Kategorije:</b> | <?php while($row = $result->fetch_assoc()) echo $row["categoryName"] . " | ";?>
    <br/><br/>
    <form action="" method="POST">
      <input type="text" name="categoryName" placeholder="Naziv Kategorije">
      <input type="submit" value="Dodaj Kategoriju">
    </form>
    <br/><br/>
    <h2 style="font-size:25px;">Pregled Proizvoda</h2>
    <hr/>
    <?php
    $sql = "SELECT productName FROM products";
    $result = $conn->query($sql);
    ?>
    <b>Postojeći Proizvodi:</b> | <?php while($row = $result->fetch_assoc()) echo $row["productName"] . " | ";?>
    <br/><br/>
    <form action="" method="POST" enctype="multipart/form-data">
      <input type="text" name="productName" placeholder="Naziv Proizvoda">
      <input type="file" name="image" placeholder="Slika Proizvoda">
      <?php
      $sql = "SELECT * FROM categories";
      $result = $conn->query($sql);
      ?>
      <select name="categoryId" style="align-self: center;	width: 80%; 	padding: 10px; 	margin: auto;">
        <?php while($row = $result->fetch_assoc()) {?>
          <option value="<?php echo $row["id"];?>"><?php echo $row["categoryName"];?></option>
        <?php } ?>
      </select>
      <input type="text" name="productDescription" placeholder="Opis Proizvoda">
      <input type="text" name="productPrice" placeholder="Cena Proizvoda">
      <input type="submit" value="Dodaj Proizvod">
    </form>
    <br/><br/>
    <h2 style="font-size:25px;">Pregled Administratora</h2>
    <hr/>
    <?php
    $sql = "SELECT email FROM admins";
    $result = $conn->query($sql);
    ?>
    <b>Postojeći Administratori:</b> | <?php while($row = $result->fetch_assoc()) echo $row["email"] . " | ";?>
    <br/><br/>
    <form action="" method="POST">
      <input type="text" name="email" placeholder="E-Mail Adresa">
      <input type="password" name="password" placeholder="Lozinka">
      <input type="submit" value="Dodaj Administratora">
    </form>
    </section>

  </main>
<?php } ?>
</body>
</html>
