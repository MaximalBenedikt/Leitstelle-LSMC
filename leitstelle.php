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

if(($_GET['action']=="actionedit")OR($_GET['action']=="actionadd")) {
  foreach ($_GET['vehicles'] as $vehicle) {
    $update = 'UPDATE `vehicles` SET `einsatz`= '.$_GET['id'].' , status = 3 WHERE `id`='.$vehicle;
    $statement = $pdo->prepare($update);
    $result = $statement->execute();
  }
}

if($_GET['action']=="actiontoggleactive"){
  $update = 'UPDATE `vehicles` SET `einsatz`= 0 , status = 2 WHERE `einsatz`='.$_GET['id'];
  $statement = $pdo->prepare($update);
  $result = $statement->execute();
  $update = 'UPDATE `actions` SET `aktiv`= 0 WHERE `id`='.$_GET['id'];
  $statement = $pdo->prepare($update);
  $result = $statement->execute();
}

if($_GET['action']=="actionedit") {
  if($_GET['aktiv']=='on') { $activ = '1'; } else { $activ = '0'; }
  $update = 'UPDATE actions SET stichwort = "'.$_GET["stichwort"].'" , ort = "'.$_GET["ort"].'" , notizen = "'.$_GET["notes"].'", aktiv = "'.$activ.'" WHERE id = "'.$_GET["id"].'"';
  $statement = $pdo->prepare($update);
  $result = $statement->execute();
}

if($_GET['action']=="actionadd") {
  $activ = '1';
  $update = 'INSERT INTO actions (`stichwort`, `ort`, `notizen`, `aktiv`) VALUES  ("'.$_GET["stichwort"].'" , "'.$_GET["ort"].'" , "'.$_GET["notes"].'", "'.$activ.'")';
  $statement = $pdo->prepare($update);
  $result = $statement->execute();
}

if($_GET['action']=="vehiclestatuschange") {
  $update = 'UPDATE vehicles SET status = '.$_GET['status'].' WHERE id = '.$_GET['id'];
  $statement = $pdo->prepare($update);
  $result = $statement->execute();
}

if($_GET['action']=="vehicleortchange") {
  $update = 'UPDATE vehicles SET lastpos = "'.$_GET['ort'].'" WHERE id = '.$_GET['id'];
  //echo $update;
  $statement = $pdo->prepare($update);
  $result = $statement->execute();
}

//Einsatz erstellen
?>


<!DOCTYPE html> 

<html> 
<head>
  <title>Leitstelle</title>  
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
  <link rel="code" type="text/javascript" href="leitstelle.js"></link>
</head> 
<body>
     <?php include('header.php'); 
	   var_dump($_GET);
	 
	 ?>
     
     <table style="float:right;width:22%;" id="customers">
        <tr><th>Aktionen</th></tr>
        <tr><th>Einsatzverwaltung</th></tr>
        <tr><td><a href="editaction.php?edit=new">Neuen Einsatz erstellen</a></td></tr>
        <tr><th>Personal</th></tr>
        <tr><td><a href="">Dienstplan</a></td></tr>
        <tr><td><a href="">Personalzuweisung</a></td></tr>
        <tr><th>Fahrzeug</th></tr>
        <tr><td><a href=""></a></td></tr>
     </table>
     
     <table id="customers" style="float:left;width:78%;margin-top:1px;">
        <tr><th colspan="4">Einsätze</th></tr>
        <tr>
          <th style="width:3%">ID</th>
          <th style="width:30%">Stichwort</th>
          <th style="width:30%">Ort</th>
          <th style="width:15%">Bearbeiten</th>
        </tr>
        <?php 
          $statement = $pdo->prepare("SELECT * FROM actions WHERE aktiv = true");
          $result = $statement->execute(); //array('id' => $userid)
          $i=0;
          while (++$i) {
            $einsatz = $statement->fetch();
        	if ($einsatz==false){break;}
        	echo "<tr><td>";
        	echo $einsatz['id'];
        	echo "</td><td>";
        	echo $einsatz['stichwort'];
        	echo "</td><td>";
        	echo $einsatz['ort'];
        	echo "</td><td>";
        	echo "<a href='editaction.php?edit=".$einsatz['id']."'>Bearbeiten</a> <a href='?action=actiontoggleactive&id=".$einsatz['id']."'>Einsatz beenden</a>";
        	echo "</td></tr>";
			
          }
        ?>
     </table>
     
	  <table id="customers" style="float:left;width:78%;margin-top:1px;">
	    <tr>
		  <th colspan="5">Fahrzeuge</th>
		</tr>
	    <tr>
		  <th style="width:17%">Funkkenner</th>
		  <th style="width:12%">EinsatzID</th>
		  <th style="width:9%">Status</th>
		  <th style="width:20%">Letzte Position</th>
		  <th style="">Bearbeiten</th>
		</tr>
		<?php 
		  $statement = $pdo->prepare("SELECT * FROM vehicles WHERE onduty = 1");
          $result = $statement->execute(); //array('id' => $userid)
		  $i=0;
		  while (++$i) {
		    $vehicle = $statement->fetch();
			if ($vehicle==false){break;}
			echo "<tr><td>";
			echo $vehicle['funkkenner'];
			echo "</td><td>";
			echo $vehicle['einsatz'];
			echo "</td><td>";
			echo $vehicle['status'];
			echo "</td><td>";
			echo $vehicle['lastpos'];
			echo "</td><td>";
			echo "<p style='margin:1px'><form><input name='action' type='hidden' value='vehiclestatuschange' /><input name='id' type='hidden' value='".$vehicle['id']."' />Status <input type='text' required='' name='status' size='1' maxlength='1' value='".$vehicle['status']."' /><input type='submit' /></form></p>";
			echo "<p style='margin:1px'><form><input name='action' type='hidden' value='vehicleortchange' /><input name='id' type='hidden' value='".$vehicle['id']."' />Ort <input type='text' required='' name='ort' size='20' maxlength='250' value='".$vehicle['lastpos']."' /><input type='submit' /></form></p>";
			//echo "<a href='editaction.php?id=".$vehicle['id']."'>Bearbeiten</a>";
			echo "</td></tr>";
		  }
		?>
	  </table>
  </body>
</html>