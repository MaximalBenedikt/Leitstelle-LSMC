<table border="1px black solid">
 		 <tr>
	 	 <td width="35%">
		 	 <a href="leitstelle.php">Leitstelle</a>
			 <a href=""></a>
			 <a href="personal.php">Personalverwaltung</a>
		 </td>
		 <td width="28%">
		    <img width="100%" src="lsmc.png">
		 </td>
		 <td width="35%">
		     <table border='1px black solid' width=100% height=100%>
			 		<tr>
					  <td>Hallo <?php echo $user['vorname']; ?>!</td><td><a href="logout.php">LOGOUT</a></td>
					</tr>
					<tr>
					  <td colspan="2">Du bist derzeit: <?php if($user['onduty'] == true) {echo 'IM DIENST <a href="">>Dienst beenden<</a>';} ?>
					</tr>
			 </table>
		 </td>
	 </tr>
 </table>