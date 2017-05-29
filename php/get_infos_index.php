<?php
	require('db.php');
	require('series/classe_series_manager.class.php'); //manager de la classe Serie
	$series_manager=new SeriesManager($db); //instanciation du manager de séries
	try
	{
		//on commence par initialiser notre tableau "index", réservé à la page d'accueil
		$index=array(
			"series_top_5_year" => array(), //tableau contenant le "top5" (pas vraiment un top 5), ce qu'il faut comprendre c'est qu'il contiendra 5 séries classées en fonction d'un critère (année, genre,meilleure notation... auc hoix ! Il suffira juste de modifier la requête sql qui suit !)
			"birthday" => array() //tabbleau contenant les informations de l'utilisateur dont c'est l'anniversaire. Il restera vide si ce n'est l'anniversaire de personne
			);
		
		//on récupère un "top 5" de séries (requête (TRES GENERALE) à modifier dans la classe Serie)
		$index["series_top_5_year"]=$series_manager->get_5_series();
		
		//fonctions
		function get_infos_anniversaire($db,$index)
		{
			$jour=date("d");
			$mois=date("m");
			$sql="select avatar_id,pseudo,sexe from utilisateurs where extract(month from STR_TO_DATE(date_anniv, '%Y-%m-%d'))=:mois and extract(day from STR_TO_DATE(date_anniv, '%Y-%m-%d'))=:jour"; 
			$req=$db->prepare($sql);
			$req->bindValue(':mois',$mois);
			$req->bindValue(':jour',$jour);
			$req->execute();
			$res=$req->fetch(PDO::FETCH_ASSOC);
			if(isset($res) && !empty($res))
			{
				$index['birthday']['pseudo']=$res['pseudo'];
				$index['birthday']['avatar']=$res['avatar_id'];
				$index['birthday']['sexe']=$res['sexe'];
			}
		}

		//on récupère enfin les informations quant à l'anniversaire
		get_infos_anniversaire($db,$index);
	}
	catch (PDOException $e) 
	{
	    echo "\n[EXCEPTION] La connexion a échoué";
	    die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
	}
?>