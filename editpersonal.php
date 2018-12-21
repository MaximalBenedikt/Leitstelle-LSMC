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
	   if(!$user['admin']==true){die("Sie haben keine Berechtigung für diese Seite!");} 
        $statement = $pdo->prepare("SELECT * FROM users WHERE dienstnummer = :nr");
        $result = $statement->execute(array('nr' => $_GET['nr']));
  	    $userline = $statement->fetch();
	?>
  <form action="personal.php" method="post">
    <table id="customers" width=100% height=100% border="1px black solid">
      <tr>
        <th width=20%>
          Feld:
        </th>
        <th width=20%>
          Wert:
        </th>
		<input hidden="" name="edit" value="<?php echo $_GET['edit'] ?>" />
		<input hidden="" name="dienstnummerold" value="<?php echo $userline['dienstnummer']; ?>" />
  	</tr>
      <tr>
         <td>
           Dienstnummer:
  	   </td>
  	   <td>
  	     <input type="text" name="dienstnummer" size="10" maxlength="4" value="<?php echo $userline['dienstnummer']; ?>" />
  	   </td>
      </tr>
	  <tr>
         <td>
           Passwort:
  	   </td>
  	   <td>
  	     <input type="text" name="passwort" size="50" maxlength="250" value="" />
  	   </td>
      </tr>
	  <tr>
         <td>
           Name:
  	   </td>
  	   <td>
  	     <input type="text" name="name" size="50" maxlength="250" value="<?php echo $userline['name']; ?>" />
  	   </td>
      </tr>
	  <tr>
         <td>
           Vorname:
  	   </td>
  	   <td>
  	     <input type="text" name="vorname" size="50" maxlength="250" value="<?php echo $userline['vorname']; ?>" />
  	   </td>
      </tr>
	  <tr>
         <td>
           Ausbildung:
  	   </td>
  	   <td>
  	     <input type="text" name="ausbildung" size="50" maxlength="250" value="<?php echo $userline['ausbildung']; ?>" />
  	   </td>
      </tr>
	  <tr>
         <td>
           Telefonnummer:
  	   </td>
  	   <td>
  	     <input type="text" name="telefonnummer" size="10" maxlength="6" value="<?php echo $userline['telefonnummer']; ?>" />
  	   </td>
      </tr>
	  <tr>
         <td>
           NDA:
  	   </td>
  	   <td>
  	     <input type="text" name="mitarbeiter" size="10" maxlength="1" value="<?php echo $userline['mitarbeiter']; ?>" />
  	   </td>
      </tr>
	  <tr>
         <td>
           Discord:
  	   </td>
  	   <td>
  	     <input type="text" name="discord" size="50" maxlength="250" value="<?php echo $userline['discord']; ?>" />
  	   </td>
      </tr>
	  <tr>
         <td>
           E-Mail:
  	   </td>
  	   <td>
  	     <input type="text" name="email" size="50" maxlength="250" value="<?php echo $userline['email']; ?>" />
  	   </td>
      </tr>
	  <tr>
         <td>
           ADMIN:
  	   </td>
  	   <td>
  	     <input type="text" name="admin" size="10" maxlength="1" value="<?php echo $userline['admin']; ?>" />
  	   </td>
      </tr>
	  <tr><td colspan="2"><input type="submit" /></td></tr>
    </table>
  </form>
  </body>
</html>