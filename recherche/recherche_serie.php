<?php
	//------------------------------BARRE DE RECHERCHE DE LA PAGE SERIES----------------------------//
	require("../db.php"); //se connecte à la db et crée un objet pdo
	require_once('../series/classe_series_manager.class.php'); //manager de la classe Serie
	$series_manager=new SeriesManager($db); //instanciation du manager de séries
	$series_list=array(); //tableau qui contiendra toutes les séries ayant dans leur titre la chaine de caractères tapée par l'utilisateur
	if(isset($_GET['series_search_bar']) && !empty($_GET['series_search_bar']))
	{
		$data=htmlentities($_GET['series_search_bar']);
		//on recherche les séries
		$sql="select titre_serie from series where titre_serie=:titre order by titre_serie";
		$req=$db->prepare($sql);
		$req->bindValue(':titre',$data,PDO::PARAM_STR);
		$req->execute();
		$res=$req->fetchAll(PDO::FETCH_ASSOC);
		if(count($res)==1)//si l'entrée est exactement le nom d'une série
		{
			$url="Location: ../series/fiche_serie.php?titre=".$res[0]['titre_serie'];
			header($url);
		}
		else //sinon on demande à la méthode de recherche du manager de série de nous renvoyer une liste de séries ayant dans leur titre la chaine de caractères renseignée par l'utilisateur
			$series_list=$series_manager->search_series($data);
	}

	//depuis la page series.php, l'utilisateur rentre soit un nom de série exact, auquel cas il est dirigé directement vers la fiche de la série
	//autrement, il atteri sur la page de recherche où une liste de séries possédant la chaine de caractères entrée par l'utilisateur comme facteur dans leur intitulé
	//on va pour cela demander au manager de séries de nous renvoyer un tableau d'objets "Serie", si celui-ci est vide, nous indiquons à l'utilisateur qu'aucun résultat a été trouvé
	//autrement on affiche la liste des résultats 
	function page_recherche($series_list)
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
		if(empty($series_list))
				echo        "<p>Aucun résultat à afficher.</p>";
		else
		{
			echo "<p>Résultats de la recherche</p>";
			foreach($series_list as $series)
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
	page_recherche($series_list);
?>



