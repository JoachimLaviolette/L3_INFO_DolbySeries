<?php
	require("classe_personnalite.class.php");
	require("../series/classe_series_manager.class.php");
	class PersonnalitesManager
	{
		private $db; //récupéré de db.php
		private $series_manager;
		//constructeur
		public function __construct($db)
		{
			$this->setDb($db);
			$this->series_manager=new SeriesManager($db);
		}
		//méthodes
		public function get_personnalite($fname,$lname) //$personnalite_fname sera le $_GET['prenom'] et $personnalite_lname sera le $_GET['nom']
		{
			//infos perso
			$sql="select id_ind,nom_ind,pren_ind,createur,producteur,acteur,realisateur from individus where nom_ind=:lname and pren_ind=:fname";
			$req=$this->db->prepare($sql);
			$req->bindValue(':lname',$lname,PDO::PARAM_STR);
			$req->bindValue(':fname',$fname,PDO::PARAM_STR);
			$req->execute();
			$res=$req->fetch(PDO::FETCH_ASSOC);
			$perso=array();
			if(isset($res) && !empty($res))
			{
				$perso["id"]=$res['id_ind'];
				$perso["fname"]=$res['pren_ind'];
				$perso["lname"]=$res['nom_ind'];
				$perso["photo_ind"]="";
				$perso["poster"]="";
				$perso["jobs"]=array();
				$perso["series"]=array(); //tableau de séries (Serie)
				//on remplit la partie "jobs" de l'individu (acteur ? producteur ? realisateur ? createur ? 1 = oui, 0 = non)
				if($res['createur']==1)
					array_push($perso['jobs'],"Créateur");
				if($res['producteur']==1)
					array_push($perso['jobs'],"Producteur");
				if($res['acteur']==1)
					array_push($perso['jobs'],"Acteur");
				if($res['realisateur']==1)
					array_push($perso['jobs'],"Réalisateur");
			}
			//series perso -- ici on ajoute toutes les séries dans lequel l'individu est membre du staff (disons ça ainsi hein)
			$sql="(select distinct id_serie,titre_serie from series where id_serie in(select distinct id_serie from jouer where id_ind=(select distinct id_ind from individus where nom_ind=:lname and pren_ind=:fname)))
				UNION 
				(select distinct id_serie,titre_serie from series where id_serie in(select distinct id_serie from produire where id_ind=(select distinct id_ind from individus where nom_ind=:lname and pren_ind=:fname)))
				UNION
				(select distinct id_serie,titre_serie from series where id_serie in(select distinct id_serie from creer where id_ind=(select distinct id_ind from individus where nom_ind=:lname and pren_ind=:fname)))
				UNION
				(select distinct id_serie,titre_serie from series where id_serie in(select distinct id_serie from realiser where id_ind=(select distinct id_ind from individus where nom_ind=:lname and pren_ind=:fname))) order by id_serie";
			$req=$this->db->prepare($sql);
			$req->bindValue(':lname',$perso['lname'],PDO::PARAM_STR);
			$req->bindValue(':fname',$perso['fname'],PDO::PARAM_STR);
			$req->execute();
			$res1=$req->fetchAll(PDO::FETCH_ASSOC);
			if(isset($res1) && !empty($res1))
				foreach($res1 as $series)
					array_push($perso['series'],$this->series_manager->get_serie($series["titre_serie"])); //ajout successif d'objets "Serie" au tableau de séries -- la méthode get_serie() nous retournant un objet de la classe Serie 

			//photo perso -- ici on récupère dans la table photo_individu la photo de la personnalité
			$sql="select url from photo_individu where id_ind=:id";
			$req=$this->db->prepare($sql);
			$req->bindValue(':id',$perso['id'],PDO::PARAM_STR);
			$req->execute();
			$res1=$req->fetch(PDO::FETCH_ASSOC);
			if(isset($res1) && !empty($res1))
				$perso['photo_ind']=$res1['url'];
			//series perso poster -- on laisse son coté aléatoire à l'algo, un individu aura comme poster celui de la première série à laquelle il est associé (la plus rapide à se prononcer gagnera écoutez ! On peut pas satisfaire tout le monde !)
			$sql="select url from photo_serie where url regexp '_poster' and id_serie in 
					(
						select id_serie from series where titre_serie in 
						(
				    		select titre_serie from series where id_serie in 
				    		(
				        		select id_serie from jouer where id_ind=(select id_ind from individus where nom_ind=:lname and pren_ind=:fname)
				        	) order by id_serie asc
				        )
				    
					    UNION
					    
					    select id_serie from series where titre_serie in 
					    (
					    	select titre_serie from series where id_serie in 
					    	(
					        	select id_serie from realiser where id_ind=(select id_ind from individus where nom_ind=:lname and pren_ind=:fname)
					        ) order by id_serie asc
					    )
												    
					    UNION
					    
					    select id_serie from series where titre_serie in 
					    (
					    	select titre_serie from series where id_serie in 
					    	(
					        	select id_serie from produire where id_ind=(select id_ind from individus where nom_ind=:lname and pren_ind=:fname)
					        ) order by id_serie asc
					    )
					    
					    UNION

					    select id_serie from series where titre_serie in 
					    (
					    	select titre_serie from series where id_serie in 
					    	(
					        	select id_serie from creer where id_ind=(select id_ind from individus where nom_ind=:lname and pren_ind=:fname)
					        ) order by id_serie asc
					    )
					)";
			$req=$this->db->prepare($sql);
			$req->bindValue(':lname',$perso['lname'], PDO::PARAM_STR);
			$req->bindValue(':fname',$perso['fname'], PDO::PARAM_STR);
			$req->execute();
			$res3=$req->fetch(PDO::FETCH_ASSOC);
			$perso['poster']=$res3['url'];
			return new Personnalite($perso);
		}
		//méthodes qui prend en paramètre le nom une chaine de caractères
		//retourne une liste de séries (classe Serie) qui ont le morceau de chaine de caractères indiqué dans leur titre 
		public function search_personnalites($string) //$string est ici la chaine entrée par l'utilisateur
		{
			$personnalites_list=array();
			if(isset($string) && !empty($string))
			{
				$infos=explode(" ",$string);
				$size=count($infos);
				$new_size=0;
				$values=array();
				for($x=0;$x<$size;$x++)
					if($infos[$x]!="") //dès qu'on trouve un nouveau mot dans la chaine, on incrémente la size (on n'incrémente pas la size si on regarde un espace)
					{	
						$values[$new_size]=$infos[$x];
						$new_size++;					
					}
				$size=$new_size;
				//on recherche ensuite les individus
				if($size==1) //si la recherche est composée d'une seule chaine (pas d'espace)
				{
					$name=$values[0];
					$sql="select pren_ind,nom_ind,createur,producteur,acteur,realisateur,url from individus i join photo_individu p on i.id_ind=p.id_ind where nom_ind like :name or pren_ind like :name";
					$req=$this->db->prepare($sql);
					$req->bindValue(':name','%'.$name.'%',PDO::PARAM_STR);
					$req->execute();
					$res=$req->fetchAll(PDO::FETCH_ASSOC);
					if(count($res)>=1)
					{
						//pour chaque individu trouvé, on récupère les informations nécessaires pour l'affichage des résultats de la recherche (prénom, nom, métier, photo)
						foreach($res as $p)
						{
							$jobs=array();
							if($p['createur']==1)
								array_push($jobs,"Créateur");
							if($p['producteur']==1)
								array_push($jobs,"Producteur");
							if($p['acteur']==1)
								array_push($jobs,"Acteur");
							if($p['realisateur']==1)
								array_push($jobs,"Réalisateur");
							$perso=array(
								"fname" => $p['pren_ind'],
								"lname" => $p['nom_ind'],
								"jobs" => $jobs,
								"photo_ind" => $p['url']
								);
							array_push($personnalites_list,new Personnalite($perso)); //on place l'objet Personnalite dans le tablaeau de personnalité
						}
					}
				}
				else //si plusieurs individus
				{
					$fname=$values[0];
					for($i=1;$i<$size;$i++)
						$lname.=$values[$i]." ";
					$lname=substr($lname,0,-1);
					$sql="select nom_ind,pren_ind from individus where nom_ind=:lname and pren_ind=:fname";
					$req=$this->db->prepare($sql);
					$req->bindValue(':lname',$lname,PDO::PARAM_STR);
					$req->bindValue(':fname',$fname,PDO::PARAM_STR);
					$req->execute();
					$res=$req->fetchAll(PDO::FETCH_ASSOC);
					if(count($res)!=1) //si aucun égalité trouvée, on inverse nom et prénom
					{
						$sql="select nom_ind,pren_ind from individus where nom_ind=:fname and pren_ind=:lname";
						$req=$this->db->prepare($sql);
						$req->bindValue(':lname',$lname,PDO::PARAM_STR);
						$req->bindValue(':fname',$fname,PDO::PARAM_STR);
						$req->execute();
						$res=$req->fetchAll(PDO::FETCH_ASSOC);
						if(count($res)!=1) //si toujours rien, on cherche les facteurs dans le nom et le prénom, puis l'inverse
						{
							$sql="select pren_ind,nom_ind,createur,producteur,acteur,realisateur,url from individus i join photo_individu p on i.id_ind=p.id_ind where nom_ind like :lname and pren_ind like :fname";
							$req=$this->db->prepare($sql);
							$req->bindValue(':lname','%'.$lname.'%',PDO::PARAM_STR);
							$req->bindValue(':fname','%'.$fname.'%',PDO::PARAM_STR);
							$req->execute();
							$res=$req->fetchAll(PDO::FETCH_ASSOC);
							if(count($res)>=1) 
							{
								foreach($res as $p)
								{
									$jobs=array();
									if($p['createur']==1)
										array_push($jobs,"Créateur");
									if($p['producteur']==1)
										array_push($jobs,"Producteur");
									if($p['acteur']==1)
										array_push($jobs,"Acteur");
									if($p['realisateur']==1)
										array_push($jobs,"Réalisateur");
									$perso=array(
										"fname" => $p['pren_ind'],
										"lname" => $p['nom_ind'],
										"jobs" => $jobs,
										"photo_ind" => $p['url']
										);
									array_push($personnalites_list,new Personnalite($perso));
								}
							}
							//on recommence en inversant les ordres nom et prenom
							$sql="select pren_ind,nom_ind,createur,producteur,acteur,realisateur,url from individus i join photo_individu p on i.id_ind=p.id_ind where nom_ind like :fname and pren_ind like :lname";
							$req=$this->db->prepare($sql);
							$req->bindValue(':lname','%'.$lname.'%',PDO::PARAM_STR);
							$req->bindValue(':fname','%'.$fname.'%',PDO::PARAM_STR);
							$req->execute();
							$res=$req->fetchAll(PDO::FETCH_ASSOC);
							if(count($res)>=1)
							{
								foreach($res as $p)
								{
									$jobs=array();
									if($p['createur']==1)
										array_push($jobs,"Créateur");
									if($p['producteur']==1)
										array_push($jobs,"Producteur");
									if($p['acteur']==1)
										array_push($jobs,"Acteur");
									if($p['realisateur']==1)
										array_push($jobs,"Réalisateur");
									$perso=array(
										"fname" => $p['pren_ind'],
										"lname" => $p['nom_ind'],
										"jobs" => $jobs,
										"photo_ind" => $p['url']
										);
									array_push($personnalites_list,new Personnalite($perso));
								}
							}
						}
					}
				}
			}
			return $personnalites_list;
		}
		//mutateurs
		public function setDb($db)
		{
			$this->db=$db;
		}
	}
?>