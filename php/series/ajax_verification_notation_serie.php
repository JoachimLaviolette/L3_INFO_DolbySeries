<?php 
	require("../../db.php");
	try
	{
		if(isset($_POST['psd']) && isset($_POST['id']))
		{
			$pseudo_u=htmlentities($_POST['psd']);
			$id_s=htmlentities($_POST['id']);
			$id_s=intval($id_s);
			$sql="select count(*) as sum from noter_series where pseudo=:pseudo and id_serie=:id";
			$req=$db->prepare($sql);
			$req->bindValue(':pseudo',$pseudo_u,PDO::PARAM_STR);
			$req->bindValue(':id',$id_s,PDO::PARAM_INT);
			$req->execute();
			$res=$req->fetch(PDO::FETCH_ASSOC);
			if(!empty($res))
			{
				if($res['sum']==0)
					echo "OK"; //la série n'a pas encore été notée par l'utilisateur
				else
					echo "reviewed"; //la série a déjà été notée par l'utilisateur
			}
		}
	}
	catch (PDOException $e) 
	{
	    echo "\n[EXCEPTION] La connexion a échoué";
	    die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
	}	
?>