<?php
	require("classe_serie.class.php");
	class SeriesManager
	{
		private $db; //récupéré de db.php
		//constructeur
		public function __construct($db)
		{
			$this->setDb($db);
		}
		//méthodes
		public function get_serie($series_name) //$series_name sera le $_GET['titre_serie'] ou le titre de la série 
		{
			//infos serie
			$sql="select id_serie,titre_serie,annee_serie,pays_serie,sum_serie from series where titre_serie=:series_name";
			$req=$this->db->prepare($sql);
			$req->bindValue(':series_name',$series_name,PDO::PARAM_STR);
			$req->execute();
			$res=$req->fetch(PDO::FETCH_ASSOC);
			$series=array();
			if(isset($res) && !empty($res))
			{
				$series=array(
					"id" => $res['id_serie'],
					"name" => $res['titre_serie'],
					"year" => $res['annee_serie'],
					"country" => $res['pays_serie'],
					"summary" => $res['sum_serie'],
					"nb_seasons" => "",
					"actors" => $actors=array(),
					"producers" => $producers=array(),
					"creators" => $creators=array(),
					"directors" => $directors=array(),
					"genres" => $genres=array(),
					"cover" => "",
					"poster" => "",
					"background" => "",
					"reviews" => $reviews=array(),
					"seasons_episodes" => $seasons_episodes=array()
					);
			}
			//infos acteurs
			$sql="select nom_ind,pren_ind from individus where id_ind in(select id_ind from jouer where id_serie=(select id_serie from series where titre_serie=:series_name))";
			$req=$this->db->prepare($sql);
			$req->bindValue(':series_name',$series_name,PDO::PARAM_STR);
			$req->execute();
			$res1=$req->fetchAll(PDO::FETCH_ASSOC);
			if(isset($res1) && !empty($res1))
			{
				$s_lnames="";
				$s_fnames="";
				foreach($res1 as $name)
					$s_lnames.=$name['nom_ind']."_";
				foreach($res1 as $name)
					$s_fnames.=$name['pren_ind']."_";
				$s_lnames=substr($s_lnames,0,-1);
				$s_fnames=substr($s_fnames,0,-1);
				$t_lnames=explode("_",$s_lnames);
				$t_fnames=explode("_",$s_fnames);
				$size=count($t_lnames);
				for($i=0;$i<$size;$i++)
				{
					$s=$t_fnames[$i]." ".$t_lnames[$i];
					array_push($actors,$s);
				}
				$series['actors']=$actors;
			}		
			//infos realisateurs
			$sql="select nom_ind,pren_ind from individus where id_ind in(select id_ind from realiser where id_serie=(select id_serie from series where titre_serie=:series_name))";
			$req=$this->db->prepare($sql);
			$req->bindValue(':series_name',$series_name,PDO::PARAM_STR);
			$req->execute();
			$res2=$req->fetchAll(PDO::FETCH_ASSOC);
			if(isset($res2) && !empty($res2))
			{
				$s_lnames="";
				$s_fnames="";
				foreach($res2 as $name)
					$s_lnames.=$name['nom_ind']."_";
				foreach($res2 as $name)
					$s_fnames.=$name['pren_ind']."_";
				$s_lnames=substr($s_lnames,0,-1);
				$s_fnames=substr($s_fnames,0,-1);
				$t_lnames=explode("_",$s_lnames);
				$t_fnames=explode("_",$s_fnames);
				$size=count($t_lnames);
				for($i=0;$i<$size;$i++)
				{
					$s=$t_fnames[$i]." ".$t_lnames[$i];
					array_push($directors,$s);
				}
				$series['directors']=$directors;
			}
			//infos producteurs
			$sql="select nom_ind,pren_ind from individus where id_ind in(select id_ind from produire where id_serie=(select id_serie from series where titre_serie=:series_name))";
			$req=$this->db->prepare($sql);
			$req->bindValue(':series_name',$series_name,PDO::PARAM_STR);
			$req->execute();
			$res3=$req->fetchAll(PDO::FETCH_ASSOC);
			if(isset($res3) && !empty($res3))
			{
				$s_lnames="";
				$s_fnames="";
				foreach($res3 as $name)
					$s_lnames.=$name['nom_ind']."_";
				foreach($res3 as $name)
					$s_fnames.=$name['pren_ind']."_";
				$s_lnames=substr($s_lnames,0,-1);
				$s_fnames=substr($s_fnames,0,-1);
				$t_lnames=explode("_",$s_lnames);
				$t_fnames=explode("_",$s_fnames);
				$size=count($t_lnames);
				for($i=0;$i<$size;$i++)
				{
					$s=$t_fnames[$i]." ".$t_lnames[$i];
					array_push($producers,$s);
				}
				$series['producers']=$producers;
			}
			//infos createurs
			$sql="select nom_ind,pren_ind from individus where id_ind in(select id_ind from creer where id_serie=(select id_serie from series where titre_serie=:series_name))";
			$req=$this->db->prepare($sql);
			$req->bindValue(':series_name',$series_name,PDO::PARAM_STR);
			$req->execute();
			$res4=$req->fetchAll(PDO::FETCH_ASSOC);
			if(isset($res4) && !empty($res4))
			{
				$s_lnames="";
				$s_fnames="";
				foreach($res4 as $name)
					$s_lnames.=$name['nom_ind']."_";
				foreach($res4 as $name)
					$s_fnames.=$name['pren_ind']."_";
				$s_lnames=substr($s_lnames,0,-1);
				$s_fnames=substr($s_fnames,0,-1);
				$t_lnames=explode("_",$s_lnames);
				$t_fnames=explode("_",$s_fnames);
				$size=count($t_lnames);
				for($i=0;$i<$size;$i++)
				{
					$s=$t_fnames[$i]." ".$t_lnames[$i];
					array_push($creators,$s);
				}
				$series['creators']=$creators;
			}
			//infos genres
			$sql="select nom_genre from etre_du_genre where id_serie=(select id_serie from series where titre_serie=:series_name)";
			$req=$this->db->prepare($sql);
			$req->bindValue(':series_name',$series_name,PDO::PARAM_STR);
			$req->execute();
			$res5=$req->fetchAll(PDO::FETCH_ASSOC);
			if(isset($res5) && !empty($res5))
			{
				foreach($res5 as $nom_genre)
					array_push($genres,$nom_genre['nom_genre']);

				$series['genres']=$genres;
			}
			//infos saisons
			$sql="select count(distinct saison_ep) as nb_saisons from series s join episodes on s.id_serie=episodes.id_serie where titre_serie=:series_name";
			$req=$this->db->prepare($sql);
			$req->bindValue(':series_name',$series_name,PDO::PARAM_STR);
			$req->execute();
			$res6=$req->fetch(PDO::FETCH_ASSOC);
			if(isset($res6) && !empty($res6))
			{
				$series['nb_seasons']=$res6['nb_saisons'];
			}
			//infos cover
			$sql="select distinct url from photo_serie where id_serie=:id and url regexp '_cover'";
			$req=$this->db->prepare($sql);
			$req->bindValue(':id',$series['id'],PDO::PARAM_INT);
			$req->execute();
			$res7=$req->fetch(PDO::FETCH_ASSOC);
			if(isset($res7) && !empty($res7))
				$series['cover']=$res7['url'];
			//infos poster
			$sql="select distinct url from photo_serie where id_serie=:id and url regexp '_poster'";
			$req=$this->db->prepare($sql);
			$req->bindValue(':id',$series['id'],PDO::PARAM_INT);
			$req->execute();
			$res8=$req->fetch(PDO::FETCH_ASSOC);
			if(isset($res8) && !empty($res8))
				$series['poster']=$res8['url'];
			//infos background
			$sql="select distinct url from photo_serie where id_serie=:id and url regexp '_bg'";
			$req=$this->db->prepare($sql);
			$req->bindValue(':id',$series['id'],PDO::PARAM_INT);
			$req->execute();
			$res=$req->fetch(PDO::FETCH_ASSOC);
			if(isset($res) && !empty($res))
				$series['background']=$res['url'];
			//infos critiques
			$sql="select pseudo as pseudo_usr, note_ns as note_usr, cmt_ns as comm_usr, date_ns as date_review from noter_series where id_serie=:id order by date_review desc";
			$req=$this->db->prepare($sql);
			$req->bindValue(':id',$series['id'],PDO::PARAM_INT);
			$req->execute();
			$res9=$req->fetchAll(PDO::FETCH_ASSOC);
			if(isset($res9) && !empty($res9))
			{
				$reviews=$res9;
			}
			for($j=0;$j<count($res9);$j++)
			{
				$sql="select avatar_id from utilisateurs where pseudo=:psd";
				$req=$this->db->prepare($sql);
				$req->bindValue(':psd',$res9[$j]['pseudo_usr'],PDO::PARAM_STR);
				$req->execute();
				$res10=$req->fetch(PDO::FETCH_ASSOC);			
				if(isset($res10) && !empty($res10))
					$reviews[$j]['avatar_id_usr']=$res10['avatar_id'];
			}
			$series['reviews']=$reviews;
			//infos saisons + episodes
			$sql="select nom_ep,saison_ep from episodes where id_serie=:id order by saison_ep asc";
			$req=$this->db->prepare($sql);
			$req->bindValue(':id',$series['id'],PDO::PARAM_INT);
			$req->execute();
			$res11=$req->fetchAll(PDO::FETCH_ASSOC);
			if(isset($res11) && !empty($res11))
			{
				for($i=0;$i<$series['nb_seasons'];$i++)
					$seasons_episodes[$i+1]=array();
				for($i=0;$i<count($res11);$i++)
					array_push($seasons_episodes[$res11[$i]['saison_ep']],$res11[$i]['nom_ep']);
				$series['seasons_episodes']=$seasons_episodes;
			}
			return new Serie($series);
		}

		//méthodes qui prend en paramètre le nom une chaine de caractères
		//retourne une liste de séries (classe Serie) qui ont le morceau de chaine de caractères indiqué dans leur titre 
		public function search_series($title_string)
		{
			$sql="select titre_serie,annee_serie,pays_serie,url from series s join photo_serie p on s.id_serie=p.id_serie where titre_serie regexp :titre and url regexp '_cover' order by titre_serie asc";
			$req=$this->db->prepare($sql);
			$req->bindValue(':titre',$title_string,PDO::PARAM_STR);
			$req->execute();
			$res=$req->fetchAll(PDO::FETCH_ASSOC);
			$series_list=array();
			if(count($res)>=1)
				foreach($res as $s)
				{
					$series=array(
						"name" => $s['titre_serie'],
						"year" => $s['annee_serie'],
						"country" => $s['pays_serie'],
						"cover" => $s['url']
						);
					array_push($series_list,new Serie($series)); //j'ajoute à mon tableau les séries successives transormées en objets Serie
				}
			return $series_list;
		}

		public function get_5_series()
		{
			$sql="select s.titre_serie from series s join etre_du_genre e on s.id_serie=e.id_serie where e.nom_genre='Super-héros'";
			$req=$this->db->prepare($sql);
			$req->execute();
			$res=$req->fetchAll(PDO::FETCH_ASSOC);
			$series_list=array();
			//ajout des 5 dernières séries en date (requête TRES GENERALE à arranger selon ce qu'on souhaite (par genre, par annee, par notes, par.. bref, whatever))
			if(isset($res) && !empty($res))
			{
				for($i=0;$i<5;$i++) 
				{
					$s=$this->get_serie($res[$i]["titre_serie"]);
					array_push($series_list, $s);
				}
			}
			return $series_list;
		}
		//mutateurs
		public function setDb($db)
		{
			$this->db=$db;
		}
	}
?>