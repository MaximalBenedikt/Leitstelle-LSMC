<?php
session_start();
if(!isset($_SESSION['userid'])) {
    die('Bitte zuerst <a href="index.php">einloggen</a>');
}
$userid = $_SESSION['userid'];
$pdo = new PDO('mysql:host=10.35.47.115:3306;dbname=k83067_lsmcdb', 'k83067_lsmcdb', 'CUUCgvn9dLnL2Lwm0oCZ');
$statement = $pdo->prepare("SELECT * FROM users WHERE dienstnummer = :id");
$userid = $_SESSION['userid'];
$result = $statement->execute(array('id' => $userid));
$user = $statement->fetch();
?>


<!DOCTYPE html> 

<html> 
<head>
  <title>Auswahl</title>  
  <style type="text/css">
    
  </style>  
</head> 
<body>
	  <table>
	  		 <tr><a href="leitstelle.php">Leitstelle</a></tr><br>
			 <tr><a href="leitstelle.php">Patienten-System</a></tr><br>
			 <tr><a href="leitstelle.php">Personalmanagement</a></tr><br>
	  </table>	  
</body>
</html>