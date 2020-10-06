<?php
if(isset($_POST['email'])) {
 
    // definition of address for sending and message subject (fixated)
    $email_to = "55555@proba.zs";
    $email_subject = "Upit sa veb-sajta";
 
    function died($error) {
		readfile('greska_top.php');
		echo $error;
		echo "</font></b><br />";
		echo "<font color='white'>Vratite se nazad kako biste popravili unos</font><br />";
		echo "<font color='#133F13'>Sada je " . date("d.m.Y, "), date("H:i:s") . "</font>";
		readfile('greska_btm.php');
		die();
    }
 
 
    // validation of entered data
    if(!isset($_POST['ime']) ||
        !isset($_POST['email']) 	||
        !isset($_POST['telefon']) ||
        !isset($_POST['poruka'])) 
		{
        died('There is a mistake in data entry.');       
	}
 
     
 
    $first_name = $_POST['ime']; // necessary
    $email_from = $_POST['email']; // necessary
    $telephone = $_POST['telefon']; // not necessary
    $comments = $_POST['poruka']; // necessary
 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'Invalid email address format.<br />';
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$first_name)) {
    $error_message .= 'The first name must contain only letters.<br />';
  }
 
  if(strlen($comments) < 2) {
    $error_message .= 'Not sufficient message.<br />';
  }
 
  if(strlen($error_message) > 0) {
    died($error_message);
  }
 
    $email_message = "Details from contact form.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
     
 
    $email_message .= "Name: ".clean_string($first_name)."\n";
    $email_message .= "e-mail: ".clean_string($email_from)."\n";
    $email_message .= "telephone: ".clean_string($telephone)."\n";
    $email_message .= "message: ".clean_string($comments)."\n";
 
// e-mail header
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  
?>
 
<!doctype html>
<html>
<head>
<title>Sent</title>
<link rel="stylesheet" type="text/css" href="assets/css/rez.css">
<script type="text/javascript" src="assets/js/rez.js"></script>
</head>
<body>
<a href="index.php">
 <svg height="0.8em" width="0.8em" viewBox="0 0 4 2" preserveAspectRatio="none">
  <polyline
        fill="none" 
        stroke="777777" 
        stroke-width="0.5" 
        points="0.9,0.1 0.1,0.5 0.9,0.9" 
  />
</svg> Back
</a>
<div class="background-wrapper">
	<h1 id="visual">Thanks!</h1>
</div>
<p><font color="#133F13">Message is sent.</font> We will let you know as soon as possible.<br />

	<?php echo "<font color='#133F13'>Now is " . date("d.m.Y, "), date("H:i:s") . "</font>"; ?></p>

</body>
</html>

<?php
 
}
?>