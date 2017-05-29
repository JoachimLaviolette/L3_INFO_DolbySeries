<?php 
	require("../../db.php");
	try
	{
		if(isset($_GET['perso_name']))
		{
			//recherche dans les individus
			$data=htmlentities($_GET['perso_name']);
			$infos=explode(" ",$data);
			$size=count($infos);
			$new_size=0;
			$values=array();
			for($x=0;$x<$size;$x++) //si 1 mot + que des espaces
				if($infos[$x]!="")
				{	
					$values[$new_size]=$infos[$x];
					$new_size++;					
				}
			$size=$new_size;
			if($size==1) 
			{
				$sql="select nom_ind,pren_ind,acteur,realisateur,producteur,createur,url as photo_ind from individus i join photo_individu p on i.id_ind=p.id_ind where nom_ind like :val or pren_ind like :val order by pren_ind asc";
				$req=$db->prepare($sql);
				$req->bindValue(':val','%'.html_entity_decode($values[0]).'%',PDO::PARAM_STR);
				$req->execute();
				$res=$req->fetchAll(PDO::FETCH_ASSOC);
				foreach($res as $val)
					echo "<li id=\"perso\">".$val['pren_ind']." ".$val['nom_ind']."</li>";
			} //si plusieurs mots
			else
			{
				$fname=$values[0];
				for($i=1;$i<$size;$i++)
					$lname.=$values[$i]." ";
				$lname=substr($lname,0,-1);
				$sql="select nom_ind,pren_ind,acteur,realisateur,producteur,createur,url as photo_ind from individus i join photo_individu p on i.id_ind=p.id_ind where pren_ind=:fname and nom_ind like :lname order by pren_ind asc";
				$req=$db->prepare($sql);
				$req->bindValue(':lname', '%'.$lname.'%', PDO::PARAM_STR);
				$req->bindValue(':fname', $fname, PDO::PARAM_STR);
				$req->execute();
				$res=$req->fetchAll(PDO::FETCH_ASSOC);
				if(!empty($res))
					foreach($res as $val)
						echo "<li id=\"perso\">".$val['pren_ind']." ".$val['nom_ind']."</li>";
				else //on inverse l'odre des nom et prénom
				{
					$sql="select nom_ind,pren_ind,acteur,realisateur,producteur,createur,url as photo_ind from individus i join photo_individu p on i.id_ind=p.id_ind where nom_ind=:fname and pren_ind like :lname order by pren_ind asc";
					$req=$db->prepare($sql);
					$req->bindValue(':lname', '%'.$lname.'%', PDO::PARAM_STR);
					$req->bindValue(':fname', $fname, PDO::PARAM_STR);
					$req->execute();
					$res=$req->fetchAll(PDO::FETCH_ASSOC);
					if(!empty($res))
						foreach($res as $val)
							echo "<li id=\"perso\">".$val['pren_ind']." ".$val['nom_ind']."</li>";
					else
					{
						$sql="select nom_ind,pren_ind,acteur,realisateur,producteur,createur,url as photo_ind from individus i join photo_individu p on i.id_ind=p.id_ind where pren_ind like :fname and nom_ind like :lname order by pren_ind asc";
						$req=$db->prepare($sql);
						$req->bindValue(':lname', '%'.$lname.'%', PDO::PARAM_STR);
						$req->bindValue(':fname', '%'.$fname.'%', PDO::PARAM_STR);
						$req->execute();
						$res=$req->fetchAll(PDO::FETCH_ASSOC);
						if(!empty($res))
							foreach($res as $val)
								echo "<li id=\"perso\">".$val['pren_ind']." ".$val['nom_ind']."</li>";
						else
						{
							$sql="select nom_ind,pren_ind,acteur,realisateur,producteur,createur,url as photo_ind from individus i join photo_individu p on i.id_ind=p.id_ind where nom_ind like :fname and pren_ind like :lname order by pren_ind asc";
							$req=$db->prepare($sql);
							$req->bindValue(':lname', '%'.$lname.'%', PDO::PARAM_STR);
							$req->bindValue(':fname', '%'.$fname.'%', PDO::PARAM_STR);
							$req->execute();
							$res=$req->fetchAll(PDO::FETCH_ASSOC);
							if(!empty($res))
								foreach($res as $val)
									echo "<li id=\"perso\">".$val['pren_ind']." ".$val['nom_ind']."</li>";
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