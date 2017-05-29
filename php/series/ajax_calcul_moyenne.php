<?php 
	require("../../db.php");
	try
	{
		if(isset($_GET['series_id']))
		{
			$sql="select avg(note_ns) as average from noter_series where id_serie=:series_id";
			$req=$db->prepare($sql);
			$req->bindValue(':series_id',$_GET['series_id'],PDO::PARAM_STR);
			$req->execute();
			$res=$req->fetch(PDO::FETCH_ASSOC);
			if(empty($res['average']))
				echo "<p>Cette série n'a pas encore été notée";
			else
				echo "<p>Note moyenne : ".(int)$res['average']."/10</p>";
		}
	}
	catch (PDOException $e) 
	{
	    echo "\n[EXCEPTION] La connexion a échoué";
	    die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
	}	
?>