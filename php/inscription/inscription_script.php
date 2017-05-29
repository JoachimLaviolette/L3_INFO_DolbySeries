<?php
	session_start();
	require("../../db.php");
	$mail=htmlentities($_POST['sign_up_mail']);
	$pseudo=htmlentities($_POST['sign_up_pseudo']);
	$pwd=htmlspecialchars($_POST['sign_up_pwd']);
	$conf_pwd=htmlentities($_POST['sign_up_pwd_confirmed']);
	$sexe=htmlentities($_POST['sign_up_sex']);
	$calling_page=$_POST['calling_page']; //page appelante
	try
	{
		if(isset($mail) && !empty($mail))
		{
			$sql="select count(*) as sum from utilisateurs where pseudo=:pseudo";
			$req=$db->prepare($sql);
			$req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
			$req->execute();
			$res=$req->fetch(PDO::FETCH_ASSOC);
			if($res['sum']==0)
			{
				$sql="select count(*) as sum from utilisateurs where adr_mail=:mail";
				$req=$db->prepare($sql);
				$req->bindValue(':mail', $mail, PDO::PARAM_STR);
				$req->execute();
				$res=$req->fetch(PDO::FETCH_ASSOC);
				if($res['sum']==0)
				{
					if(sha1($pwd)==sha1($conf_pwd))
					{
						$sql="insert into utilisateurs values(:pseudo,:pwd,:heure,:sexe,:mail,'',:avatar)";
						$req=$db->prepare($sql);
						$req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
						$req->bindValue(':pwd', sha1($pwd), PDO::PARAM_STR);
						$req->bindValue(':heure', date('Y-m-d H:i:s'));				
						$req->bindValue(':sexe', $sexe, PDO::PARAM_STR);
						$req->bindValue(':mail', $mail, PDO::PARAM_STR);
						$req->bindValue(':avatar', sha1("basic_avatar.png"), PDO::PARAM_STR);
						$req->execute();
						echo 'Vous êtes désormais inscrit sur le site.';
						$_SESSION['pseudo']=$pseudo;
						$_SESSION['pwd']=$pwd;
						$_SESSION['date_insc']=date('Y-m-d H:i:s');
						$_SESSION['sexe']=$sexe;
						$_SESSION['adr_mail']=$mail;
						$_SESSION['connected']=true;
						sleep(2);
						header("Location: ../../compte.php");
					}
					else
						echo '[Erreur] : les deux mots de passe renseignés ne correspondent pas. Réessayez.';
				}
				else
					echo '[Erreur] : une personne possède déjà cette adresse-mail.';
			}
			else
				echo '[Erreur] : une personne possède déjà ce pseudo. Choisissez-en un nouveau.';
		}
		else
			header("Location: ../../inscription.php");
	}
	catch (PDOException $e) 
	{
	    echo "\n[EXCEPTION] La connexion a échoué";
	    die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
	}
?>
