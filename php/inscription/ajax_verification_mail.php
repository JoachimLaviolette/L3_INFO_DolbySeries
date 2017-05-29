<?php
	require("../../db.php");
	try
	{
		if(isset($_POST['m']))
		{
			$mail=htmlentities($_POST['m']);
			$sql="select count(*) as sum from utilisateurs where adr_mail=:mail";
			$req=$db->prepare($sql);
			$req->bindValue(':mail',$mail,PDO::PARAM_STR);
			$req->execute();
			$res=$req->fetch(PDO::FETCH_ASSOC);
			if(!empty($res))
			{
				if($res['sum']==0)
					echo "OK";
				else
					echo "NOT_OK";
			}
		}
	}
	catch (PDOException $e) 
	{
	    echo "\n[EXCEPTION] La connexion a échoué";
	    die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
	}
?>