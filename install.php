<?php
  include "db.php";

  $sql = "CREATE TABLE IF NOT EXISTS admins (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            email     VARCHAR(64) NOT NULL,
            password  VARCHAR(128) NOT NULL,
            regDate   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
          )";

  if ($conn->query($sql) === TRUE) {
    //echo "Tabela Admins je uspesno kreirana.<br/>";
  } else {
    echo "Greska: " . $conn->error . "<br/>";
  }

  $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            firstName VARCHAR(32) NOT NULL,
            lastName  VARCHAR(32) NOT NULL,
            email     VARCHAR(64) NOT NULL,
            password  VARCHAR(255) NOT NULL,
            address   VARCHAR(64) NOT NULL,
            city      VARCHAR(32) NOT NULL,
            zipCode   INT(6) UNSIGNED NOT NULL,
            country   VARCHAR(32) NOT NULL,
            regDate   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
          )";

  if ($conn->query($sql) === TRUE) {
    //echo "Tabela Users je uspesno kreirana.<br/>";
  } else {
    echo "Greska: " . $conn->error . "<br/>";
  }

  $sql = "CREATE TABLE IF NOT EXISTS categories (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            categoryName        VARCHAR(32) NOT NULL,
            categoryDescription MEDIUMTEXT,
            createDate          TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
          )";

  if ($conn->query($sql) === TRUE) {
    //echo "Tabela Categories je uspesno kreirana.<br/>";
  } else {
    echo "Greska: " . $conn->error . "<br/>";
  }

  $sql = "CREATE TABLE IF NOT EXISTS products (
            id INT(6)          UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            categoryId INT(6)  UNSIGNED NOT NULL,
            productName        VARCHAR(32) NOT NULL,
            productImage       VARCHAR(255) NOT NULL,
            productDescription MEDIUMTEXT,
            productPrice       FLOAT NOT NULL,
            createDate         TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
          )";

  if ($conn->query($sql) === TRUE) {
    //echo "Tabela Products je uspesno kreirana.<br/>";
  } else {
    echo "Greska: " . $conn->error . "<br/>";
  }

  $sql = "CREATE TABLE IF NOT EXISTS carts (
            id INT(6)     UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            userId INT(6) UNSIGNED NOT NULL,
            productId INT(6) UNSIGNED NOT NULL,
            updateDate    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
          )";

  if ($conn->query($sql) === TRUE) {
    //echo "Tabela Carts je uspesno kreirana.<br/>";
  } else {
    echo "Greska: " . $conn->error . "<br/>";
  }

  $sql = "CREATE TABLE IF NOT EXISTS orders (
            id INT(6)     UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            userId INT(6) UNSIGNED NOT NULL,
            orderedProducts MEDIUMTEXT NOT NULL,
            orderDate    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
          )";

  if ($conn->query($sql) === TRUE) {
    //echo "Tabela Orders je uspesno kreirana.<br/>";
  } else {
    echo "Greska: " . $conn->error . "<br/>";
  }

  $sql = "SELECT COUNT(id) as adminNum FROM admins";
  $result = $conn->query($sql);

   $adminNum = $result->fetch_row()[0];

   if($adminNum == 0) {
     $password = password_hash("Admin123", PASSWORD_DEFAULT);
     $sql = "INSERT INTO `admins` (`email`, `password`) VALUES ('admin@test.com', '$password')";

     if ($conn->query($sql) === TRUE) {
     } else {
       echo "Error: " . $sql . "<br>" . $conn->error;
     }

     $sql = "INSERT INTO `categories` (`categoryName`, `categoryDescription`) VALUES ('Kafe', NULL), ('Kolaci', NULL)";

     if ($conn->query($sql) === TRUE) {
     } else {
       echo "Error: " . $sql . "<br>" . $conn->error;
     }

     $sql = "INSERT INTO `orders` (`userId`, `orderedProducts`, `orderDate`) VALUES ('1', '1,2', '2020-06-18 22:20:12')";

     if ($conn->query($sql) === TRUE) {
     } else {
       echo "Error: " . $sql . "<br>" . $conn->error;
     }

     $sql = "INSERT INTO `products` (`categoryId`, `productName`, `productImage`, `productDescription`, `productPrice`, `createDate`) VALUES ('2', 'Sacher Torta', 'uploads/SacherTorta.png', 'Prava poslastica za uživanje.', '525.9', '2020-06-18 22:17:10'), ('1', 'Espresso', 'uploads/Espreso.png', 'Odličan izbor za početak dana.', '195.9', '2020-06-18 22:12:16'), ('1', 'Cappucino', 'uploads/Cappucino.png', 'Odličan izbor za uživanje.', '210.9', '2020-06-18 22:13:54'), ('2', 'Ruska Kapa', 'uploads/RuskaKapa.png', 'Prava poslastica uz kafu.', '305', '2020-06-18 22:15:36')";

     if ($conn->query($sql) === TRUE) {
     } else {
       echo "Error: " . $sql . "<br>" . $conn->error;
     }

     $password = password_hash("User123", PASSWORD_DEFAULT);
     $sql = "INSERT INTO `users` (`firstName`, `lastName`, `email`, `password`, `address`, `city`, `zipCode`, `country`) VALUES ('Test', 'Test', 'user@test.com', '$password', 'Test Adresa', 'Test Grad', '0', 'Srbija')";

     if ($conn->query($sql) === TRUE) {
     } else {
       echo "Error: " . $sql . "<br>" . $conn->error;
     }
   }

?>
