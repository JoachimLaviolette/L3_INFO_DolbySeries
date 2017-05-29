<?php
	require("../db.php");
	try
	{
		if(isset($_GET['val_genre']))
		{
			$genre=htmlentities($_GET['val_genre']);
			$sql="select distinct titre_serie,url as cover from series s join photo_serie p on s.id_serie=p.id_serie where s.id_serie in(select id_serie from etre_du_genre where nom_genre=:genre) and url regexp '_cover' order by titre_serie asc";
			$req=$db->prepare($sql);
			$req->bindValue(':genre',$genre,PDO::PARAM_STR);
			$req->execute();
			$res=$req->fetchAll(PDO::FETCH_ASSOC);
			echo "<p>Séries triées par genre</p>";
			foreach($res as $series)
				echo "<div class=\"div_series\">
						<a href=\"series/fiche_serie.php?titre=".$series['titre_serie']."\"><img class=\"div_series_cover\" src=\"".$series['cover']."\"/></a>
						<p class=\"div_series_title\"><a href=\"series/fiche_serie.php?titre=".$series['titre_serie']."\">".$series['titre_serie']."</a></p>
					</div>";
		}
	}
	catch (PDOException $e) 
	{
	    echo "\n[EXCEPTION] La connexion a échoué";
	    die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
	}	
?>