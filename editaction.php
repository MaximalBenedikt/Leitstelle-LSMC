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
	   //if(!$user['admin']==true){die("Sie haben keine Berechtigung für diese Seite!");} Für Adminseiten!
	   
	   if((isset($_GET['edit']))&&($_GET['edit']!='new')){
	     $statement = $pdo->prepare("SELECT * FROM actions WHERE id = :id");
         $result = $statement->execute(array('id' => $_GET['edit'])); 
		 $einsatz= $statement->fetch();
	   }
	   if((isset($_GET['edit']))&&($_GET['edit']=='new')){
	     $einsatz['aktiv']=1;
	   }
  ?>
    <form action="leitstelle.php" method="get">
      <table id="customers" style="width:70%;float:left;">
	    <input type="hidden" name="action" value="<?php if((isset($_GET['edit']))&&($_GET['edit']!='new')){ echo "actionedit"; } else { echo "actionadd"; } ?>" />
		<?php echo '<input type="hidden" name="id" value="'.$_GET['edit'].'" />'; ?>
    	  <tr>
    	    <th colspan="2"><?php if($_GET['edit']=='new') { echo 'Einsatzerstellung'; } else { echo 'Einsatzbearbeitung'; } ?></th>
    	  </tr>
    	  <?php echo '<tr><td>EinsatzID:</td><td><input disabled="true" name="id" value="'.$_GET['edit'].'" /></td></tr>'; ?>
		  <tr>
    	    <td>Einsatzort</td>
    		<td><input name="ort" width="100" value="<?php echo $einsatz['ort']; ?>" /></td>
    	  </tr>
		  <tr>
    	    <td>Einsatzstichwort</td>
    		<td><input name="stichwort" value="<?php echo $einsatz['stichwort']; ?>" /></td>
    	  </tr>
    	  <tr>
    	    <td>Notizen</td>
    		<td><input name="notes" width="150" value="<?php echo $einsatz['notizen']; ?>" /></td>
    	  </tr>
    	  <tr>
    	    <td>Einsatz aktiv</td>
    		<td><input name="aktiv" type="checkbox"  <?php if($einsatz['aktiv']==1){ echo "checked=''"; }  ?> /></td>
    	  </tr>
	      <tr>
	  	    <td colspan="2"><input type="submit" /></td>
  	      </tr>
	  </table>
	  <table id="customers" style="width:30%;float:left;">
	    <tr><th>Verfügbare Fahrzeuge</th><th></th></tr>
		<tr><td>
		  <select name="vehicles[]" multiple="" style="width:100%">
		    <?php
			  $statement = $pdo->prepare("SELECT * FROM `vehicles` WHERE `onduty` = 1 AND (`status`=1 OR `status`=2)");
              $result = $statement->execute(); //array('id' => $userid)
              $i=0;
              while (++$i) {
                $vehicle = $statement->fetch();
        	    if ($vehicle==false){break;}
        	    echo "<option value='".$vehicle['id']."'>".$vehicle['funkkenner']."</option>";
              }
			?>
		  </select>
		</td></tr>
	  </table>
	</form>
  </body>
</html>