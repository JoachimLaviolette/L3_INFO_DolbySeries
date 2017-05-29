<?php
	require("../../db.php");
	try
	{
		if(isset($_POST['psd']) && isset($_POST['mdp']))
		{
			$pseudo=htmlentities($_POST['psd']);
			$mdp=htmlentities($_POST['mdp']);
			$mdp=sha1($mdp); //on encrypte le mdp entré par l'utilisateur
			$sql="select pwd from utilisateurs where pseudo=:pseudo";
			$req=$db->prepare($sql);
			$req->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
			$req->execute();
			$res=$req->fetch(PDO::FETCH_ASSOC);
			if($res['pwd']==$mdp)
				echo "OK";
			else
				echo "NOT_OK"; //le mdp entré ne correspond pas au mot de passe actuel de l'utilisateur
		}
		//ne renverra rien sinon
	}
	catch (PDOException $e) 
	{
	    echo "\n[EXCEPTION] La connexion a échoué";
	    die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
	}	
?>