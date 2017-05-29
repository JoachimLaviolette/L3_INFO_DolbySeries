<?php 
	require("../db.php");
	try
	{
		if(isset($_GET['val']))
		{
			$data=htmlentities($_GET['val']);
			//---------------------------------------------------------CAS D'UNE SERIE----------------------------------------------------------//
			$sql="select titre_serie,annee_serie,pays_serie,url as photo_serie from series s join photo_serie p on s.id_serie=p.id_serie where titre_serie regexp :val and url regexp '_cover' order by titre_serie asc";
			$req=$db->prepare($sql);
			$req->bindValue(':val',$data,PDO::PARAM_STR);
			$req->execute();
			$res=$req->fetchAll(PDO::FETCH_ASSOC);
			foreach($res as $val)
				echo "<li style=\"background-image: url('".$val['photo_serie']."');\" id=\"search\">".$val['titre_serie'].", ".$val['pays_serie']." (".$val['annee_serie'].")</li>";
			//---------------------------------------------------------CAS D'UNE PERSONNALITE----------------------------------------------------------//
			$infos=explode(" ",$data); //on explose la chaine reçue en en plusieurs chaines si jamais elle comporte des espaces
			$size=count($infos); //on récupère le nombre de mots qu'il y avait dans la chaine
			//le problème est que la réelle taille peut être faussée par les multiples espaces entre les mots
			//on va donc corriger cela et recalculer une taille qui correspond REELLEMENT au nombre de mots et qui ne s'incrémente pas à chaque espace trouvé
			$new_size=0;
			$values=array();
			for($x=0;$x<$size;$x++)
				if($infos[$x]!="") //incrémentation à chaque mot trouvé dans le tableau $infos, donc à chaque case remplie par autre chose qu'un espace !
				{	
					$values[$new_size]=$infos[$x];
					$new_size++;					
				}
			$size=$new_size;
			if($size==1) //si la chaine entrée n'est séparée par aucun espace
			{
				$sql="select nom_ind,pren_ind,acteur,realisateur,producteur,createur,url as photo_ind from individus i join photo_individu p on i.id_ind=p.id_ind where nom_ind like :val or pren_ind like :val order by pren_ind asc";
				$req=$db->prepare($sql);
				$req->bindValue(':val','%'./*html_entity_decode*/($values[0]).'%',PDO::PARAM_STR); //si le nom ou le prénom comporte une lettre avec accent, la base de données de va pas trouver l'utilisateur car elle va enregistrer le caractère spécial résultant de l'encodage du caractère avec accent sans le retransformer en clair avant de lancer sa requête... il faudrait utiliser la fonction de décodage pour reconvertir les caractères comme le "é" en clair (html_entity_decode)
				//la chaine décodée directement dans le bindValue, cela ne poserait pas de problème (normalement...)
				//encore une fois, c'est UNIQUEMENT parce qu'ils ont été insérés en clair dans la base de données -- ex: états-unis, Kévin...
				//si on ne re-décode pas avant de faire la recherche, il sera cherché dans la bdd non pas "états-unis" mais "%20tats-unis"...
				//il aurait fallu enregistré les mots ayant des caractères avec accent dans leur état encodé, dans la bdd dès le départ !
				$req->execute();
				$res=$req->fetchAll(PDO::FETCH_ASSOC);
				//construction du <li> que l'on renvoie à chaque itération
				foreach($res as $val)
				{
					$role="<em style=\"font-size:10px;\">, ";
					if($val['createur']==1)
						$role.="Créateur, ";
					if($val['producteur']==1)
						$role.="Producteur, ";
					if($val['acteur']==1)
						$role.="Acteur, ";
					if($val['realisateur']==1)
						$role.="Réalisateur, ";
					$role=substr($role,0,-2);$role.="</em>";
					echo "<li style=\"background-image: url('".$val['photo_ind']."');\" id=\"search\">".$val['pren_ind']." ".$val['nom_ind'].$role."</li>";
				}
			} 
			else //si la chaine entrée contient plusieurs mots séparés par des espaces 
			{
				$fname=$values[0];
				for($i=1;$i<$size;$i++)
					$lname.=$values[$i]." ";
				$lname=substr($lname,0,-1);
				//on teste d'abord l'égalité du prénom et le facteur dans le nom
				//ex : "Tyler Pos"
				$sql="select nom_ind,pren_ind,acteur,realisateur,producteur,createur,url as photo_ind from individus i join photo_individu p on i.id_ind=p.id_ind where pren_ind=:fname and nom_ind like :lname order by pren_ind asc";
				$req=$db->prepare($sql);
				$req->bindValue(':lname', '%'.$lname.'%', PDO::PARAM_STR);
				$req->bindValue(':fname', $fname, PDO::PARAM_STR);
				$req->execute();
				$res=$req->fetchAll(PDO::FETCH_ASSOC);
				if(!empty($res))
					foreach($res as $val)
					{
						$role="<em style=\"font-size:10px;\">, ";
						if($val['createur']==1)
							$role.="Créateur, ";
						if($val['producteur']==1)
							$role.="Producteur, ";
						if($val['acteur']==1)
							$role.="Acteur, ";
						if($val['realisateur']==1)
							$role.="Réalisateur, ";
						$role=substr($role,0,-2);$role.="</em>";
						echo "<li style=\"background-image: url('".$val['photo_ind']."');\" id=\"search\">".$val['pren_ind']." ".$val['nom_ind'].$role."</li>";
					}
				else //on teste sinon l'égalité du nom et le facteur dans le prénom -- ex : Tyl Posey
				{
					$sql="select nom_ind,pren_ind,acteur,realisateur,producteur,createur,url as photo_ind from individus i join photo_individu p on i.id_ind=p.id_ind where nom_ind=:fname and pren_ind like :lname order by pren_ind asc";
					$req=$db->prepare($sql);
					$req->bindValue(':lname', '%'.$lname.'%', PDO::PARAM_STR);
					$req->bindValue(':fname', $fname, PDO::PARAM_STR);
					$req->execute();
					$res=$req->fetchAll(PDO::FETCH_ASSOC);
					if(!empty($res))
						foreach($res as $val)
						{
							$role="<em style=\"font-size:10px;\">, ";
							if($val['createur']==1)
								$role.="Créateur, ";
							if($val['producteur']==1)
								$role.="Producteur, ";
							if($val['acteur']==1)
								$role.="Acteur, ";
							if($val['realisateur']==1)
								$role.="Réalisateur, ";
							$role=substr($role,0,-2);$role.="</em>";
							echo "<li style=\"background-image: url('".$val['photo_ind']."');\" id=\"search\">".$val['pren_ind']." ".$val['nom_ind'].$role."</li>";
						}
					else //si toujours rien, on teste les facteurs dans prénom et dans le nom -- ex : "Pos Tyl"
					{
						$sql="select nom_ind,pren_ind,acteur,realisateur,producteur,createur,url as photo_ind from individus i join photo_individu p on i.id_ind=p.id_ind where pren_ind like :fname and nom_ind like :lname order by pren_ind asc";
						$req=$db->prepare($sql);
						$req->bindValue(':lname', '%'.$lname.'%', PDO::PARAM_STR);
						$req->bindValue(':fname', '%'.$fname.'%', PDO::PARAM_STR);
						$req->execute();
						$res=$req->fetchAll(PDO::FETCH_ASSOC);
						if(!empty($res))
							foreach($res as $val)
							{
								$role="<em style=\"font-size:10px;\">, ";
								if($val['createur']==1)
									$role.="Créateur, ";
								if($val['producteur']==1)
									$role.="Producteur, ";
								if($val['acteur']==1)
									$role.="Acteur, ";
								if($val['realisateur']==1)
									$role.="Réalisateur, ";
								$role=substr($role,0,-2);$role.="</em>";
								echo "<li style=\"background-image: url('".$val['photo_ind']."');\" id=\"search\">".$val['pren_ind']." ".$val['nom_ind'].$role."</li>";
							}
						else //sinon on inverse l'ordre -- ex "Tyl Pos"
						{
							$sql="select nom_ind,pren_ind,acteur,realisateur,producteur,createur,url as photo_ind from individus i join photo_individu p on i.id_ind=p.id_ind where nom_ind like :fname and pren_ind like :lname order by pren_ind asc";
							$req=$db->prepare($sql);
							$req->bindValue(':lname', '%'.$lname.'%', PDO::PARAM_STR);
							$req->bindValue(':fname', '%'.$fname.'%', PDO::PARAM_STR);
							$req->execute();
							$res=$req->fetchAll(PDO::FETCH_ASSOC);
							if(!empty($res))
								foreach($res as $val)
								{
									$role="<em style=\"font-size:10px;\">, ";
									if($val['createur']==1)
										$role.="Créateur, ";
									if($val['producteur']==1)
										$role.="Producteur, ";
									if($val['acteur']==1)
										$role.="Acteur, ";
									if($val['realisateur']==1)
										$role.="Réalisateur, ";
									$role=substr($role,0,-2);$role.="</em>";
									echo "<li style=\"background-image: url('".$val['photo_ind']."');\" id=\"search\">".$val['pren_ind']." ".$val['nom_ind'].$role."</li>";
								}
						}
					}
				}
			}		
		}
	}
	catch (PDOException $e) 
	{
	    echo "\n[EXCEPTION] La connexion a échoué";
	    die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
	}	
?>