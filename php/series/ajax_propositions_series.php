<?php 
	require("../../db.php");
	try
	{
		if(isset($_GET['series_name']))
		{
			$series_name=htmlentities($_GET['series_name']);
			$sql="select titre_serie from series where titre_serie like :series_name order by titre_serie asc";
			$req=$db->prepare($sql);
			$req->bindValue(':series_name','%'.$series_name.'%',PDO::PARAM_STR);
			$req->execute();
			$res=$req->fetchAll(PDO::FETCH_ASSOC);
			foreach($res as $series)
				echo "<li id=\"series\">".$series['titre_serie']."</li>";
		}
	}
	catch (PDOException $e) 
	{
	    echo "\n[EXCEPTION] La connexion a échoué";
	    die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
	}	
?>