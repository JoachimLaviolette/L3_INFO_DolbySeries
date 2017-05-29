<?php
	//------------------------------BARRE DE RECHERCHE GENERALE PRESENTE DANS LE HEADER DEPUIS CHAQUE PAGE DU SITE----------------------------//
	require("../db.php");
	require_once("../personnalites/classe_personnalites_manager.class.php"); //manager de la classe Personnalite
	require_once("../series/classe_series_manager.class.php"); //manager de la classe Serie
	$personnalites_manager=new PersonnalitesManager($db);
	$series_manager=new SeriesManager($db);
	$search_list=array();
	//search_list possèdera deux clés : 
	//"series_list" qui aura pour valeur un tableau qui contiendra toutes les séries ayant dans leur titre la chaine de caractères tapée par l'utilisateur
	//"personnalites_list" qui aura pour valeur un tableau qui contiendra toutes les personnalités ayant dans leur nom et/ou prénom la chaine de caractères tapée par l'utilisateur
	if(isset($_GET['value_searched']) && !empty($_GET['value_searched']))
	{
		$data=htmlentities($_GET['value_searched']);
		//pour la barre de recherche générale, une liste de propositions indique également à l'utilisateur les résultats correspondant à ce qu'il est en train de renseigner 
		//soit celui-ci clique sur l'une des propositions
		//soit il décide de continuer sa saisie 
		//au final soit son entrée est complète soit elle est incomplète
		//on ne sait donc pas s'il a rentré un nom de série ou les prénom/nom ou nom/prénom d'individu
		//on teste ici donc tout d'abord les égalités : soit il a entré le titre exact d'une série auquel cas on le redirige vers la fiche de celle-ci
		//soit il a entré le nom et le prénom (ou inversement) exacts d'un individu, auquel cas on le redirige égaement vers la fiche de celui-ci
		//si ce n'est pas le cas, il va falloir sollicité les méthodes de recherche des managers de séries et de personnalités

		//------------------------------------------------------------CAS D'UNE SERIE-------------------------------------------------------------//
		$sql="select titre_serie from series where titre_serie=:titre order by titre_serie";
		$req=$db->prepare($sql);
		$req->bindValue(':titre',$data,PDO::PARAM_STR);
		$req->execute();
		$res=$req->fetchAll(PDO::FETCH_ASSOC);
		if(count($res)==1) //si l'entrée est exactement le nom d'une série on redirige l'utilisateur vers la fiche de la série
		{
			$url="Location: ../series/fiche_serie.php?titre=".$res[0]['titre_serie'];
			header($url);
		}
		else //sinon on demande à la méthode de recherche du manager de série de nous renvoyer une liste de séries ayant dans leur titre la chaine de caractères renseignée par l'utilisateur
			$search_list['series_list']=$series_manager->search_series($data);

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
						$search_list["personnalites_list"]=$personnalites_manager->search_personnalites($data);
				}
			}
			catch(PDOException $e)
		    {
				echo "\n[EXCEPTION] La connexion a échoué";
		    	die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
		    }
		}
		else //cas où la chaine entrée par l'utilisateur ne comporte qu'un mot, on ne peut donc pas dissocier le prénom et le nom, on demande donc directement au manager de séries de nous fournir une liste d'individus correspondant potentiellement à la recherche (càd : facteur renseigné trouvé dans un nom et/ou prénom -- voir classe /personnalites/PersonnalitesManager.php)
			$search_list["personnalites_list"]=$personnalites_manager->search_personnalites($data);
	}
	function page_recherche($search_list)
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

		if(empty($search_list["personnalites_list"] && $search_list["series_list"]))
				echo        "<p>Aucun résultat à afficher.</p>";
		else
		{
			echo "<p>Résultats de la recherche</p>";
			foreach($search_list["personnalites_list"] as $personnalite)
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
			foreach($search_list["series_list"] as $series)
			{
				echo        "<div class=\"search_res\" style=\"background-image: url('".$series->getCover()."');\">
					 			<p class=\"label\"><a href=\"../series/fiche_serie.php?titre=".$series->getName()."\">".$series->getName()."</a></p>
								<p class=\"feature\">".$series->getCountry().", (".$series->getYear().")</p>
							</div>";
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
	page_recherche($search_list);
?>



