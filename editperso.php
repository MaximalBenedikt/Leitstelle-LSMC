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
	   //if(!$user['admin']==true){die("Sie haben keine Berechtigung für diese Seite!");} //Für Adminseiten!
	   //if(!$user['lst']==true){die("Sie haben keine Berechtigung für diese Seite!");} //Für Leitstellenseiten!
  ?>
  
  </body>
</html>