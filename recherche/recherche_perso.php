<?php
	//------------------------------BARRE DE RECHERCHE DE LA PAGE PERSONNALITES----------------------------//
	require("../db.php"); //se connecte à la db et crée un objet pdo
	require_once("../personnalites/classe_personnalites_manager.class.php"); //manager de la classe Personnalite
	$personnalites_manager=new PersonnalitesManager($db); //instanciation du manager de séries
	$personnalites_list=array(); //tableau qui contiendra toutes les personnalités ayant dans leur nom et/ou prénom la chaine de caractères tapée par l'utilisateur
	if(isset($_GET['personnalites_search_bar']) && !empty($_GET['personnalites_search_bar']))
	{
		$data=htmlentities($_GET['personnalites_search_bar']);
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
		//les traitements qui suivent concernent le cas où l'utilisateur entre excatement le bon prénom suivi du bon nom d'une personnalité
		//soit il l'a bien entré à la main
		//soit il a cliqué sur une des propositions de la liste déroulante
		if($size>1)
		{
			//la variable $fname contient le prénom de l'individu
			$fname=$values[0]; //on partira du principe qu'on trouve le prénom systématiquement à la première place du tableau résultant de l'explosion de la chaine de caractères (même pour les noms composés, ex : Juan José Camapnaella)
			for($i=1;$i<$size;$i++)
				$lname.=$values[$i]." "; //on construit maintenant la variable $lname qui correspond au nom de famille de l'individu, on parcourt donc le reste du tableau (en excluant donc la première valeur) et ajoutons à la variable $lname chaque nouveau mot trouvé (noms composés)
			$lname=substr($lname,0,-1); //on enlève l'espace de fin de chaine
			//maintenant que nos deux variables $fname et $lname, correspondant respectivement aux prénom et nom de l'individu, ont été crées, on va procéder à des tests d'égalités
			//si l'utilisateur a cliqué sur l'une des propoistions dans la liste déroulante et a cliqué sur "entrer", on le dirige directement vers la page de l'individu
			//autre cas : si l'utilisateur a rempli lui même la barre de recherche dans l'ordre : prénom puis nom -- ex : Tyler Posey, ou dans le sens inverse
			try 
			{				
				$sql="select nom_ind,pren_ind from individus where nom_ind=:lname and pren_ind=:fname";
				$req=$db->prepare($sql);
				$req->bindValue(':lname', $lname, PDO::PARAM_STR);
				$req->bindValue(':fname', $fname, PDO::PARAM_STR);
				$req->execute();
				$res=$req->fetchAll(PDO::FETCH_ASSOC);
				if(count($res)==1)//on teste l'égalité des nom et prénom
				{
					$url="Location: ../personnalites/fiche_perso.php?nom=".$res[0]['nom_ind']."&prenom=".$res[0]['pren_ind'];
					header($url);
				} 
				else //si non trouvé, on test l'égalité dans le sens inverse, si l'utilisateur a par exemple entré : Posey Tyler
				{
					$sql="select nom_ind,pren_ind from individus where nom_ind=:fname and pren_ind=:lname";
					$req=$db->prepare($sql);
					$req->bindValue(':lname', $lname, PDO::PARAM_STR);
					$req->bindValue(':fname', $fname, PDO::PARAM_STR);
					$req->execute();
					$res=$req->fetchAll(PDO::FETCH_ASSOC);
					if(count($res)==1)
					{
						$url="Location: ../personnalites/fiche_perso.php?nom=".$res[0]['nom_ind']."&prenom=".$res[0]['pren_ind'];
						header($url);
					}
					else //si l'un des deux libellés (prénom ou nom est incomplet -- ex : "Tyler Pos" ou "Posey Tyl", on demande au manager de nous fournir une liste de tous les individus potentiels)
						$personnalites_list=$personnalites_manager->search_personnalites($data);
				}
			}
			catch(PDOException $e)
		    {
				echo "\n[EXCEPTION] La connexion a échoué";
		    	die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
		    }
		}
		else //cas où la chaine entrée par l'utilisateur ne comporte qu'un mot, on ne peut donc pas dissocier le prénom et le nom, on demande donc directement au manager de séries de nous fournir une liste d'individus correspondant potentiellement à la recherche (càd : facteur renseigné trouvé dans un nom et/ou prénom -- voir classe /personnalites/PersonnalitesManager.php)
			$personnalites_list=$personnalites_manager->search_personnalites($data);
	}
	
	//depuis la page personnalites.php, l'utilisateur rentre soit un nom d'individu exact, auquel cas il est dirigé directement vers la fiche de la personnalité
	//autrement, il atteri sur la page de recherche où une liste de perosnnalités possédant la chaine de caractères entrée par l'utilisateur comme facteur dans leur nom ou prénom
	//on va pour cela demander au manager de personnalités de nous renvoyer un tableau d'objets "Personnalite", si celui-ci est vide, nous indiquons à l'utilisateur qu'aucun résultat a été trouvé
	//autrement on affiche la liste des résultats 
	function page_recherche($personnalites_list)
	{
		//-------------------en-tête de page-------------------------------------------------------------------//
		require('../utiles/header.php');
		//choix du css en fonction de la préférence choisie (si choisie)
		/////////////////////////////// -- Changement du thème (couleur) -- ///////////////////////////
		if(isset($_SESSION['theme']))
		{
			if($_SESSION['theme']=="Rouge")
				echo "<link href=\"../styles/recherche_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
			else if($_SESSION['theme']=="Bleu")
				echo "<link href=\"../styles/recherche_css_blue.css\" rel=\"stylesheet\" type=\"text/css\"/>";
			else
				echo "<link href=\"../styles/recherche_css_green.css\" rel=\"stylesheet\" type=\"text/css\"/>";
		}
		else
			echo "<link href=\"../styles/recherche_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
		/////////////////////////////// -- Changement de la typo -- ///////////////////////////////////
		if(isset($_SESSION['typo']))
		{
			if($_SESSION['typo']=="Trebuchet")
				$script="<script>
							$(document).ready(function(){
								$('html,input,button').css('font-family','Trebuchet MS, sans-serif');
							});
						</script>";
			else if($_SESSION['typo']=="Arial")
				$script="<script>
							$(document).ready(function(){
								$('html,input,button').css('font-family','Arial');
							});
						</script>";
			else
				$script="<script>
							$(document).ready(function(){
								$('html,input,button').css('font-family','Calibri');
							});
						</script>";
			echo $script;
		}
		echo "
		</head>
		<body>
			<main>
				<header>
					<div id=\"header\">
						<div id=\"logo_header\">
							<a href=\"../index.php\">";
							if(isset($_SESSION['theme']))
							{
								if($_SESSION['theme']=="Rouge")
									echo "<img src=\"/medias/logo_header_3.png\" alt=\"logo_header\"/>";
								else if($_SESSION['theme']=="Bleu")
									echo "<img src=\"/medias/logo_header_4.png\" alt=\"logo_header\"/>";
								else
									echo "<img src=\"/medias/logo_header_5.png\" alt=\"logo_header\"/>";
							}
							else
								echo "<img src=\"/medias/logo_header_3.png\" alt=\"logo_header\"/>";
							echo "
							</a>
						</div>	
						<div id=\"search_bar\">
							<form method=\"get\" action=\"../recherche/recherche.php\">
								<input onkeyup=\"propositions_search()\" id=\"header_search_input\" type=\"text\" name=\"value_searched\" placeholder=\"Nom de série, d'acteur, de réalisateur...\" size=\"50\" maxlength=\"50\"/><button type=\"submit\" id=\"search_button\">RECHERCHER</button>
								<div id=\"list_of_search\">
									<ul>
									</ul> 
								</div>
							</form>
						</div>
					</div>
				</header>
				<div id=\"menu\">
					<div id=\"cat\">
						<ul>
							<li><a href=\"../index.php\">ACCUEIL</a></li>
							<li><a href=\"../series.php\">SERIES</a></li>
							<li><a href=\"../forum.php\">FORUM</a></li>
							<li><a href=\"../personnalites.php\">PERSONNALITES</a></li>
						</ul>
					</div>
					<div id=\"account\">
						<ul>
							<li>"; 
								if(isset($_SESSION['connected']))
									echo '<a href="../compte.php">> MON COMPTE</a>';
								else
									echo '<a href="../connexion.php">> SE CONNECTER</a>';
							echo "
							</li>
						</ul>
					</div>
				</div>
				<div id=\"sep\">
					<marquee>DOLBY SERIES EST UN NOUVEAU SITE DEDIE AUX SERIES DU MOMENT !</marquee>
				</div>";
		//-------------------fin en-tête-------------------------------------------------------------------//
		echo 	"<div id=\"main\">
					<div id=\"main_title\">	
						<p>RECHERCHE</p>
					</div>
					<div id=\"main_content\">";

		if(empty($personnalites_list))
				echo        "<p>Aucun résultat à afficher.</p>";
		else
		{
			echo "<p>Résultats de la recherche</p>";
			foreach($personnalites_list as $personnalite)
			{
				echo        "<div class=\"search_res\" style=\"background-image: url('".$personnalite->getPhoto()."');\">
								<p class=\"label\">
									<a href=\"../personnalites/fiche_perso.php?nom=".$personnalite->getLname()."&prenom=".$personnalite->getFname()."\">".$personnalite->getFname()." ".$personnalite->getLname()."</a></p>";
									$str="<p class=\"role\">";
									for($i=0;$i<count($personnalite->getJobs());$i++)
										$str.=$personnalite->getJobs()[$i].", ";
									$str=substr($str,0,-2); //on supprime la virgule et l'espace de fin
						$str.="</p>";
				echo $str;
				echo 		"</div>";									
			}
		}
		echo "		</div>
				 </div>
			 </div>";
		require('../utiles/footer.php');
		require('../utiles/header_end.php');
	}
	//chargement de la page de résultat en apelant la fonction implémentée
	//$series_list est ici le tableau de séries renvoyé par le manager
	page_recherche($personnalites_list);
?>



