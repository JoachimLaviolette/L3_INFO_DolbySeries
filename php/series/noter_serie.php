<?php
	session_start();
	$note=htmlentities($_POST['review_user_note']);
	$commentaire=htmlentities($_POST['review_user_commentary']);
	$pseudo=$_SESSION['pseudo'];
	$series_id=htmlentities($_POST['review_series_id']);
	$series_name=htmlentities($_POST['review_series_name']);
	require("../../db.php");
	try
	{	
		if(isset($_POST) && (count($_POST)!=0))
		{
			$date=date('Y-m-d H:i:s');
			$sql="insert into noter_series values(:pseudo,:id,:note,:commentaire,:date)";
			$req=$db->prepare($sql);
			$req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
			$req->bindValue(':id', $series_id, PDO::PARAM_INT);
			$req->bindValue(':note', $note, PDO::PARAM_INT);
			$req->bindValue(':commentaire', $commentaire, PDO::PARAM_STR);
			$req->bindValue(':date', $date);
			$req->execute();
			header("Location: ../../series/fiche_serie_critiques.php?titre=".$series_name);
		}
		else
			header("Location: ../../series.php");

	}
	catch (PDOException $e) 
	{
	    echo "\n[EXCEPTION] La connexion a échoué";
	    die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
	}
?>