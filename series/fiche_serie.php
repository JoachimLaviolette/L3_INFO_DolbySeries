<?php
	require("../db.php"); //se connecte à la db et crée un objet pdo
	require('classe_series_manager.class.php'); //manager de la classe Serie
	$series_manager=new SeriesManager($db); //instanciation du manager de séries
	//la méthode get_serie charge toutes les informations quant à la série ayant comme titre celui passé en paramètre, crée un objet Serie en conséquence, et le renvoie
	$series=$series_manager->get_serie($_GET['titre']); 

	//chargement des fonctions qui renvoient des chaines de HTML, on écho le tout à la fin pour produire la page
	load_header();
?>
	<script src="/js/series/functions.js"></script>
</head>
<body>
	<main>
		<header>
			<div id="header">
				<div id="logo_header">
					<a href="../index.php">
					<?php 
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
					?>
					</a>
				</div>	
				<div id="search_bar">
					<form method="get" action="../recherche/recherche.php">
						<input onkeyup="propositions_search()" id="header_search_input" type="text" name="value_searched" placeholder="Nom de série, d'acteur, de réalisateur..." size="50" maxlength="50"/><button type="submit" id="search_button">RECHERCHER</button>
						<div id="list_of_search">
							<ul>
							</ul> 
						</div>
					</form>
				</div>
			</div>
		</header>
		<div id="menu">
			<div id="cat">
				<ul>
					<li><a href="../index.php">ACCUEIL</a></li>
					<li id="selected">SERIES</li>
					<li><a href="../forum.php">FORUM</a></li>
					<li><a href="../personnalites.php">PERSONNALITES</a></li>
				</ul>
			</div>
			<div id="account">
				<ul>
					<li>
						<?php 
							if(isset($_SESSION['connected']))
								echo '<a href="../compte.php">> MON COMPTE</a>';
							else
								echo '<a href="../connexion.php">> SE CONNECTER</a>';
						?>
					</li>
				</ul>
			</div>
		</div>
		<div id="sep">
			<marquee>DOLBY SERIES EST UN NOUVEAU SITE DEDIE AUX SERIES DU MOMENT !</marquee>
		</div>	
<?php
	load_series_zone($series);
	load_series_nav_menu($series);
	load_series_resume($series);
	load_footer();
	load_header_end();
	//fin des fonctions 

	//implémentation des fonctions de chargement de données
	function load_header()
	{
		require('../utiles/header.php');
		//on teste si la s-globale session possède des clé définies pour les préférences
		//par défaut, nous appliquerons le css de base
		/////////////////////////////// -- Changement du thème (couleur) -- ///////////////////////////
		if(isset($_SESSION['theme']))
		{
			if($_SESSION['theme']=="Rouge")
				echo "<link href=\"../styles/series/fiche_serie_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
			else if($_SESSION['theme']=="Bleu")
				echo "<link href=\"../styles/series/fiche_serie_css_blue.css\" rel=\"stylesheet\" type=\"text/css\"/>";
			else
				echo "<link href=\"../styles/series/fiche_serie_css_green.css\" rel=\"stylesheet\" type=\"text/css\"/>";
		}
		else
			echo "<link href=\"../styles/series/fiche_serie_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
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
	}

	function load_footer()
	{
		require('../utiles/footer.php');
	}

	function load_header_end()
	{
		require('../utiles/header_end.php');
	}

	//retour une chaine de caractère d'au plus 3 éléments de la feature demandée (noms d'acteurs, genres etc.)
	function load_feature($feature)
	{
		$string="<p>";
		for($i=0;$i<3;$i++)
			if($feature[$i]!="")
				$string.=$feature[$i].", ";
		$string=substr($string,0,-2);
		$string.="</p>";
		return $string;
	}

	//ici on charge la zone d'infos de la série
	//la zone correspondante est celle avec le poster dégradé et les features de la série
	function load_series_zone($series)
	{
		$string="<div id=\"main\">
					<div id=\"main_title\">	
						<p>SERIES</p>
					</div>
					<div id=\"main_content\">
						<div id=\"series_zone\">
							<style>
							main > #main > #main_content > #series_zone
							{
								background-image: url(\"".$series->getPoster()."\");
							}
							</style>
							<div id=\"series_title\"><p>".$series->getName()."</p></div>
							<div id=\"series_background\">
								<div id=\"series_infos\">
									<div id=\"series_creators\" class=\"series_feature\">
										<div class=\"series_infos_label\"><p>Créateurs</p></div>
										<div id=\"creators_names\">".load_feature($series->getCreators())."</div>
									</div>
									<div id=\"series_producers\" class=\"series_feature\">
										<div class=\"series_infos_label\"><p>Producteurs</p></div>
										<div id=\"producers_names\">".load_feature($series->getProducers())."</div>
									</div>
									<div id=\"series_directors\" class=\"series_feature\">
										<div class=\"series_infos_label\"><p>Réalisateurs</p></div>
										<div id=\"directors_names\">".load_feature($series->getDirectors())."</div>
									</div>
									<div id=\"series_actors\" class=\"series_feature\">
										<div class=\"series_infos_label\"><p>Acteurs</p></div>
										<div id=\"actors_names\">".load_feature($series->getActors())."</div>
									</div>
									<div id=\"series_genres\" class=\"series_feature\">
										<div class=\"series_infos_label\"><p>Genres</p></div>
										<div id=\"genres_names\">".load_feature($series->getGenres())."</div>
									</div>
									<div id=\"series_year\" class=\"series_feature\">
										<div class=\"series_infos_label\"><p>Année de sortie</p></div>
										<div id=\"year\"><p>".$series->getYear()."</p></div>
									</div>
									<div id=\"series_country\" class=\"series_feature\">
										<div class=\"series_infos_label\"><p>Nationalité</p></div>
										<div id=\"country\"><p>".$series->getCountry()."</p></div>
									</div>
									<div id=\"series_seasons\" class=\"series_feature\">
										<div class=\"series_infos_label\"><p>Nbre de saisons</p></div>
										<div id=\"seasons_number\"><p>".$series->getNbseasons()."</p></div>
									</div>
								</div>
							</div>
						</div>";
		echo $string;
	}

	//ici on charge les onglets sous la zone d'infos de la série
	function load_series_nav_menu($series)
	{
		$string="<div id=\"series_nav_menu\">
					<div class=\"menu_tab\">
						<p><a href=\"fiche_serie_casting.php?titre=".$series->getName()."\">CASTING</a></p>
					</div>
					<div class=\"menu_tab reviews\">
						<p><a href=\"fiche_serie_critiques.php?titre=".$series->getName()."\">NOTES & CRITIQUES</a></p>
					</div>
					<div class=\"menu_tab saisons\">
						<p><a href=\"fiche_serie_saisons.php?titre=".$series->getName()."\">SAISONS</a></p>
					</div>
				</div>";
		echo $string;
	}

	//ici on charge le résumé de la série
	function load_series_resume($series)
	{
		$string="<div id=\"series_resume\">
					<p id=\"title\">Synopsis</p>
					<p id=\"content\">".$series->getSummary()."</p>
				</div></div>";
		echo $string;
	}
?>
								
					
