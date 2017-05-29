<?php
	session_start();
	require("../../db.php");
	$avatar=htmlentities($_FILES['infos_compte_avatar']['name']);
	$old_pwd=htmlentities($_POST['infos_compte_old_pwd']);
	$new_pwd=htmlentities($_POST['infos_compte_new_pwd']);
	$new_pwd_conf=htmlentities($_POST['infos_compte_new_pwd_confirmed']);
	$new_mail=htmlentities($_POST['infos_compte_new_mail']);
	$sexe=htmlentities($_POST['infos_compte_sexe']);
	$date_anniv=htmlentities($_POST['infos_compte_anniv']);
	$pseudo=$_SESSION['pseudo'];	
	$calling_page=$_POST['calling_page']; //page appelante
	try
	{
		if(empty($avatar) && empty($old_pwd) && empty($new_pwd) && empty($new_pwd_conf) && empty($new_mail) && empty($sexe) && empty($date_anniv)) //si rien n'est rempli, redirection avers la page du compte
			header("Location: ../../compte.php");
		else
		{
			$sql="update utilisateurs set "; //début de requete sql
			$binary="";  //chaine binaire de contrôle
			//la chaine binaire de contrôle permet de savoir quel champ a effectivement été rempli pour, au fur et à mesure, compléter la requête UPDATE sql
			//chaque position dans la chaine binaire correspond à un champ différent
			//[0] --> mot de passe
			//[1] --> sexe
			//[2] --> adresse-mail
			//[3] --> date d'anniversaire
			//[4] --> avatar
			//Un 1 sera mis dans chaque champ si l'information correspondante a été renseignée, 0 sinon
			//de cette façon, nous serons à la fin, avant d'exécuter la requête, quelles sont les valeurs à binder
			//////////////////////////////
			//mots de passe
			$res_pwd=0; //0 tout vide, 1 tout rempli, 2 l'un des champs est manquant
			if( 
				(!empty($old_pwd) && empty($new_pwd) && empty($new_pwd_conf)) ||
				(!empty($old_pwd) && !empty($new_pwd) && empty($new_pwd_conf)) ||
				(!empty($old_pwd) && empty($new_pwd) && !empty($new_pwd_conf)) ||
				(empty($old_pwd) && !empty($new_pwd) && empty($new_pwd_conf)) ||
				(empty($old_pwd) && !empty($new_pwd) && !empty($new_pwd_conf)) ||
				(empty($old_pwd) && empty($new_pwd) && !empty($new_pwd_conf))
			) //condition finalement contrôlée en AJAX. Voir : /js/compte/functions.js
			{
				$res_pwd=2;
			}
			else if(empty($old_pwd) && empty($new_pwd) && empty($new_pwd_conf))
				$res_pwd=0;
			else
				$res_pwd=1;
			if($res_pwd==2)
				echo '[Erreur] : l\'un des champs réservés aux mots de passe est manquant.';
			else if($res_pwd==1) //si tous les champs quant aux mdp sont remplis
			{
				if(sha1($old_pwd)!=sha1($new_pwd)) //si le nouveau mdp renseigné est bien différent de l'ancien
				{
					if(sha1($new_pwd)==sha1($new_pwd_conf)) //encore une fois, ce contrôle a finalement été fait en AJAX
					{
						$sql.="pwd=:new_pwd,"; //si tout est bon, on complète la requête UPDATE sql
						$binary.="1"; //on ajoute 1 à la chaine binaire à sa position 0
					}
					else
						echo '[Erreur] : la confirmation de mot de passe ne correspond pas au nouveau mot de passe renseigné.';
				}
				else
					echo '[Erreur] : le nouveau mot de passe renseigné est identique au précédent.';
			}
			else
				$binary.="0";
			//sexe
			if(!empty($sexe))
			{
				$sql.=" sexe=:sexe,";
				$binary.="1";
			}
			else
				$binary.="0";
			//adresse_mail
			if(!empty($new_mail))
			{
				$sql1="select count(*) as sum from utilisateurs where adr_mail=:mail"; //on vérifie qu'aucun autre utilisateur ne possède la nouvelle adresse-mail renseignée
				$req=$db->prepare($sql1);
				$req->bindValue(':mail', $new_mail, PDO::PARAM_STR);
				$req->execute();
				$res=$req->fetch(PDO::FETCH_ASSOC);
				if($res['sum']==0) //si la somme vaut 0, donc si personne d'autre ne possède l'adresse-mail renseignée
				{
					$sql.=" adr_mail=:new_mail,"; //on complète la requête sql en conséquence
					$binary.="1"; //on ajoute 1 à la chaine binaire pour indiquer que ce champ est à prendre en compte
				}
				else
					echo '[Erreur] : une personne possède déjà ce mail. Choisissez-en un nouveau.'; //finalement contrôlé au préalable en AJAX
			}
			else
				$binary.="0";
			//date_anniv
			if(!empty($date_anniv))
			{
				$sql.=" date_anniv=:anniv,";
				$binary.="1";
			}
			else
				$binary.="0";
			//avatar
			if(!empty($avatar))
			{
				$sql.=" avatar_id=:avatar,";
				$binary.="1";
			}
			else
				$binary.="0";
			//une fois que la requete sql est ok, on supprime le dernier caractère ","
			$sql=substr($sql,0,-1);
			$sql.=" where pseudo=:pseudo"; //on termine la requête sql
			$req=$db->prepare($sql);
			$req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
			//moment de binder la valeurs renseignées
			//c'est maintenant que l'on se sert de notre chère chaine binaire !
			if($binary[0]==1)
				$req->bindValue(':new_pwd', sha1($new_pwd), PDO::PARAM_STR);	
			if($binary[1]==1)
				$req->bindValue(':sexe', $sexe, PDO::PARAM_STR);
			if($binary[2]==1)
				$req->bindValue(':new_mail', $new_mail, PDO::PARAM_STR);
			if($binary[3]==1)
				$req->bindValue(':anniv', $date_anniv);
			if($binary[4]==1)
			{
				$avatar_id=sha1($pseudo).""; //l'avatar a pour "id" (nom stocké dans la bdd et nom attribué à l'image stocké sur le serveur) le pseudo encrypté de l'utilisateur
				$req->bindValue(':avatar', $avatar_id, PDO::PARAM_STR);
			}
			$req->execute();
			//on enregistre l'avatar sur le serveur
			save_avatar($pseudo,$avatar_id); //détail de la fonction en dessous
			//on redirige l'utilisateur vers sa page profil
			if($binary[0]==1) //si le mot de passe a été modifié, on déconnecte l'utilisateur pour l'obliger a se reconnecter
				header("Location: /php/connexion/deconnexion_script.php");
			else //autrement, on le renvoit à sa page de compte
				header("Location: ../../compte.php");
		}
	}
	catch (PDOException $e) 
	{
	    echo "\n[EXCEPTION] La connexion a échoué";
	    die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
	}

	//fonction save_avatar()
	//cette fonction prend en paramètres le pseudo de l'utilisateur et l'id de son avatar
	//comme dit plus haut, l'id de son avatar (champ avatar_id dans la table utilisateur) correspond au pseudo encrypté (sha1) de l'utilisateur
	//l'idée était de ne stocker qu'un seul avatar par utilisateur
	//en d'autres termes, d'écraser automatiquement l'ancien avatar stocké sur le serveur avec le nouvel avatar uploadé
	//utiliser comme nom d'image le pseudo encrypté de l'utilisateur était une bonne façon de s'assurer de son unicité
	//l'avatar de l'utilisateur est stocké sur le serveur dans le dossier /medias/avatars/xxxx/ où la chaine xxxx correspond également au pseudo encrypté de l'utilisateur
	//oui oui, on s'organise hein !
	//voilà, tout est dit, place à l'implémentation !
	function save_avatar($pseudo,$avatar_id)
	{
		$folder_path='../../avatars/'.sha1($pseudo).'/'; //on commence à créer l'url de fichier
		/*if(file_exists($folder_path))
			rmdir($folder_path);*/
		if(!file_exists($folder_path)) //si le dossier n'existe pas encore, donc que l'utilisateur n'a encore jamais uploadé d'avatar, on crée son dossier personnel
			mkdir($folder_path);
		//$file_ext=strtolower(substr(strrchr($_FILES['infos_compte_avatar']['name'],'.'),1));
		$file_path=$folder_path.$avatar_id.".png"; //on complète l'url avec le nom de fichier. On a fait ici le choix d'imposer le format PNG (d'où la ligne du dessus finalement commentée)
		$res=move_uploaded_file($_FILES['infos_compte_avatar']['tmp_name'],$file_path); //on finit en placant le fichier image uploadé à l'emplacement correspondant
	}
?>