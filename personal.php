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

//Einfügen der neuen Werte
if($_POST['edit']=='edit'){
  $statement = $pdo->prepare("UPDATE `users` SET `dienstnummer` = ? ,`passwort` = ? ,`vorname` = ? ,`name` = ? ,`kurz` = ? ,`telefonnummer` = ? ,`mitarbeiter` = ? ,`ausbildung` = ? ,`email` = ? ,`discord` = ?,`admin` = ?  WHERE dienstnummer = ? ");
  $result = $statement->execute(array($_POST['dienstnummer'],md5($_POST['passwort']),$_POST['vorname'],$_POST['name'], $_POST['kurz'],$_POST['telefonnummer'],$_POST['mitarbeiter'],$_POST['ausbildung'],$_POST['email'],$_POST['discord'],$_POST['admin'],$_POST['dienstnummerold']));
}

if($_POST['edit']=='new'){
  $statement = $pdo->prepare("INSERT INTO `users` VALUES `dienstnummer` = ? ,`passwort` = ? ,`vorname` = ? ,`name` = ? ,`kurz` = ? ,`telefonnummer` = ? ,`mitarbeiter` = ? ,`ausbildung` = ? ,`email` = ? ,`discord` = ? ");
  $passwort = md5($_POST['passwort']);
  $result = $statement->execute(array($_POST['dienstnummer'] , $passwort , $_POST['vorname'] , $_POST['name'] , $_POST['kurz'] , $_POST['telefonnummer'] , $_POST['mitarbeiter'] , $_POST['ausbildung'] , $_POST['email'] , $_POST['discord']));
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="generator" content="CoffeeCup HTML Editor (www.coffeecup.com)">
    <meta name="dcterms.created" content="So, 16 Dez 2018 12:07:57 GMT">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title></title>
    <style type="text/css">
      #customers {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
      }
      
      #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
      }
      
      #customers tr:nth-child(even){background-color: #f2f2f2;}
      
      #customers tr:hover {background-color: #ddd;}
      
      #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
      }
      .buttons:hover{ 
        background-color:orange;
      }
      .buttons:active{
        background-color:blue;
       }
 	 </style>
    <!--[if IE]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body>
  <?php
  	   include('header.php');
	   if(!$user['admin']==true){die("Sie haben keine Berechtigung für diese Seite!");}
  ?>
  <table id="customers" width=100% height=100% border="1px black solid">
    <tr>
      <th width=5%>
        ID:
      </th>
      <th width=15%>
        Name:
      </th>
      <th width=15%>
        Vorname:
      </th>
      <th width=15%>
        Ausbildung:
      </th>
	  <th width=10%>
        Telefonnummer:
      </th>
	  <th width=5%>
	    NDA?
	  </th>
	  <th width=15%>
        OOC! Discord:
      </th>
	  <th width=20%>
        OOC! E-Mail:
      </th>
	  <th></th>
    </tr>
	<?php 
      $statement = $pdo->prepare("SELECT * FROM users ORDER BY dienstnummer");
      $result = $statement->execute();
	  $i = 0;
	  while (++$i) {
	    $userline = $statement->fetch();
		if ($userline == false) {break;}
		echo "<tr><td>".$userline['dienstnummer']."</td><td>".$userline['name']."</td><td>".$userline['vorname']."</td><td>".$userline['ausbildung']."</td><td>".$userline['telefonnummer']."</td><td>".$userline['mitarbeiter']."</td><td>".$userline['discord']."</td><td>".$userline['email']."</td><td><a href='editpersonal.php?nr=".$userline['dienstnummer']."&edit=edit'>Bearbeiten</a></td></tr>";
	  }
	?>
	<!--<tr><td colspan="2"><a href="editpersonal.php?edit=new">Neues Personal anlegen</a></td></tr>-->
  </table>

  </body>
</html>