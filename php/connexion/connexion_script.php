<?php
	session_start();
	require("../../db.php"); //connexion à la base de données
	$pseudo=htmlentities($_POST['login_pseudo']);
	$pwd=htmlentities($_POST['login_pwd']);
	$calling_page=$_POST['calling_page']; //page appelante
	try
	{
		$sql="select count(*) as sum,pwd,date_insc,sexe,adr_mail,date_anniv from utilisateurs where pseudo=:pseudo";
		$req=$db->prepare($sql);
		$req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
		$req->execute();
		$res=$req->fetch(PDO::FETCH_ASSOC);
		if($res['sum']==1)
		{
			if(sha1($pwd)==$res['pwd'])
			{
				//si le mot de passe (encrypté) correspond, on stocke les informations de l'utilisateur conncté dans la variable session
				$_SESSION['pseudo']=$pseudo;
				$_SESSION['pwd']=$res['pwd'];
				$_SESSION['date_insc']=$res['date_insc'];;
				$_SESSION['sexe']=$res['sexe'];
				$_SESSION['adr_mail']=$res['adr_mail'];
				$_SESSION['date_anniv']=$res['date_anniv'];
				$_SESSION['connected']=true;
				//on formate l'url de la page appelante pour la redirection automatique
				$page_path = substr($calling_page,strpos($calling_page,"/")); //ex: https://localhost/series/fiche_serie.php --> //localhost/series/fiche_serie.php
				$page_path[0]=""; //on retire le premier slash
				$page_path[1]=""; //on retire le second
				$page_path = substr($page_path,strpos($page_path,"/")); //on obtient localhost/series/fiche_serie.php
				if(!empty($page_path))
				{
					$url="Location: ".$page_path;
					header($url); //redirection automatique vers la page appelante
				}
				else
					header("Location: ../../index.php"); //par défaut, redirection vers la page d'accueil
			}
			else
				echo '[Erreur] : mot de passe renseigné incorrect.'; //à contrôler en AJAX ?
		}
		else
			echo '[Erreur] : Le pseudo que vous avez renseigné n\'existe pas ou est incorrect. Veuillez réessayer.'; //à contrôler en AJAX
	}
	catch (PDOException $e) 
	{
	    echo "\n[EXCEPTION] La connexion a échoué";
	    die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
	}
?>