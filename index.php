<!DOCTYPE html> 

<html> 
<head>
  <title>Login</title>  
  <style type="text/css">
    form {
      width: 20%;
      margin-left: 40%;
      margin-top: 100px;
    }
    img {
      width:100%;
    }
  </style>  
</head> 
<body>
<?php 
session_start();
$pdo = new PDO('mysql:host=10.35.47.115:3306;dbname=k83067_lsmcdb', 'k83067_lsmcdb', 'CUUCgvn9dLnL2Lwm0oCZ');
 
if(isset($_GET['login'])) {
    $email = $_POST['uname'];
    $passwort = md5($_POST['psw']);
    
    $statement = $pdo->prepare("SELECT * FROM users WHERE dienstnummer = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();
	
    if ($user !== false && $passwort==$user['passwort']) {
        $_SESSION['userid'] = $user['dienstnummer'];
        die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
    } else {
        $errorMessage = "Dienstnummer oder Passwort war ungültig<br>";
    }
   
}
?> 
<form action="?login=1" method="post">
<div class="loginform">
      <img src="lsmc.png">
      <label for="uname"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="uname" required>
      <br />
      <label for="psw"><b>Passwort</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>
      <br />
      <button type="submit">Login</button>
    </div>
    <div class="container" style="background-color:#f1f1f1">
      <span class="psw">Passwort vergessen? Melde dich bitte bei Bella!</span>
    </div>
</form> 
<?php 
if(isset($errorMessage)) {
    echo $errorMessage;
}
?>
</body>
</html>