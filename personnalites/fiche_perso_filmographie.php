<?php
	session_start();
	require("../db.php"); //se connecte à la db et crée un objet pdo
	require("classe_personnalites_manager.class.php"); //manager de la classe Personnalite
	$personnalites_manager=new PersonnalitesManager($db); //instanciation du manager de séries
	//la méthode get_serie charge toutes les informations quant à la série ayant comme titre celui passé en paramètre, crée un objet Serie en conséquence, et le renvoie
	$perso=$personnalites_manager->get_personnalite($_GET["prenom"],$_GET["nom"]);
		
	//chargement des fonctions qui renvoient des chaines de HTML, on écho le tout à la fin pour produire la page
	load_header();
?>
	<script src="/js/personnalites/functions.js"></script>
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
					<li><a href="../series.php">SERIES</a></li>
					<li><a href="../forum.php">FORUM</a></li>
					<li id="selected">PERSONNALITES</li>
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
	load_personnalite_zone($perso);
	load_personnalite_nav_menu($perso);
	load_personnalite_series_zone($perso);
	load_main_footer($perso);
	load_footer();
	load_header_end(); 
	//fin des fonctions

	//implémentation des fonctions de chargement de données (même modèle que pour série)
	function load_header()
	{
		require('../utiles/header.php');
		//on teste si la s-globale session possède des clé définies pour les préférences
		//par défaut, nous appliquerons le css de base
		/////////////////////////////// -- Changement du thème (couleur) -- ///////////////////////////
		if(isset($_SESSION['theme']))
		{
			if($_SESSION['theme']=="Rouge")
				echo "<link href=\"../styles/personnalites/fiche_perso_filmographie_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
			else if($_SESSION['theme']=="Bleu")
				echo "<link href=\"../styles/personnalites/fiche_perso_filmographie_css_blue.css\" rel=\"stylesheet\" type=\"text/css\"/>";
			else
				echo "<link href=\"../styles/personnalites/fiche_perso_filmographie_css_green.css\" rel=\"stylesheet\" type=\"text/css\"/>";
		}
		else
			echo "<link href=\"../styles/personnalites/fiche_perso_filmographie_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
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

	function load_names($perso)
	{
		return "<p>".$perso->getFname()." ".$perso->getLname()."</p>";
	}

	//ici on charge les différents métiers de la personnalité et on en crée une chaine
	function load_jobs($perso)
	{
		$i=0;
		$string="<p>";
		foreach($perso->getJobs() as $job)
			if($job!=""  && $i<3)
			{
				$string.=$job.", ";
				$i++;
			}
		$string=substr($string,0,-2); //suppression de a virgule et de l'espace de fin
		$string.="</p>";
		return $string;
	}

	//ici on charge les séries auxquelles est associé l'individu
	function load_series($perso)
	{
		$i=0;
		$string="<p>";
		foreach($perso->getSeries() as $series)
			if($series->getName()!="" && $i<3)
			{
				$string.=$series->getName().", ";
				$i++;
			}
		$string=substr($string,0,-2); //suppression de a virgule et de l'espace de fin
		$string.="</p>";
		return $string;
	}

	function load_personnalite_zone($perso)
	{
		$string="<div id=\"main\">
					<div id=\"main_title\">	
						<p>PERSONNALITES</p>
					</div>
					<div id=\"main_content\">
						<div id=\"personnalite_zone\">
							<style>
							main > #main > #main_content > #personnalite_zone
							{
								background-image: url(\"".$perso->getPoster()."\");
							}
							</style>
							<div id=\"personnalite_title\">".load_names($perso)."</div>
							<div id=\"personnalite_background\">
								<div id=\"personnalite_picture\">
									<img id=\"personnalite_pic\" src=\"".$perso->getPhoto()."\"/>
								</div>
								<div id=\"personnalite_infos\">
									<div id=\"personnalite_job\" class=\"personnalite_feature\">
										<div class=\"personnalite_infos_label\"><p>Métier</p></div>
										<div id=\"job_val\">".load_jobs($perso)."</div>
									</div>
									<div id=\"personnalite_name\" class=\"personnalite_feature\">
										<div class=\"personnalite_infos_label\"><p>Nom</p></div>
										<div id=\"name_val\">".load_names($perso)."</div>
									</div>
									<div id=\"personnalite_series\" class=\"personnalite_feature\">
										<div class=\"personnalite_infos_label\"><p>Séries</p></div>
										<div id=\"series_val\">".load_series($perso)."</div>
									</div>
								</div>
							</div>
						</div>";
		echo $string;
	}

	function load_personnalite_nav_menu($perso)
	{
		$string="<div id=\"personnalite_nav_menu\">
					<div id=\"selected\" class=\"menu_tab\">
						<p>FILMOGRAPHIE</p>
					</div>
					<div class=\"menu_tab\">
						<p><a href=#>BIOGRAPHIE</a></p>
					</div>
				</div>";
		echo $string;
	}

	function load_personnalite_series_zone($perso)
	{
		$string="<div id=\"personnalite_series_zone\">
					<div class=\"label\"><p>Séries notables</p></div>";
					foreach($perso->getSeries() as $series)
					{
						$string.="<div class=\"series\">
									<div id=\"series_pic\">
										<a href=\"../series/fiche_serie.php?titre=".$series->getName()."\"><img class=\"series_pic\" src=\"".$series->getCover()."\"/></a>
									</div>
									<div id=\"series_desc\">
										<p class=\"series_name\"><a href=\"../series/fiche_serie.php?titre=".$series->getName()."\">".$series->getName()."</a></p>
									</div>			
								</div>";
					}
		$string.="</div></div>";
		echo $string;
	}

	function load_main_footer($perso)
	{
		$string="<div id=\"main_footer\">
					<button>
						<a href=\"fiche_perso.php?nom=".$perso->getLname()."&prenom=".$perso->getFname()."\">Retour à la fiche de \"".$perso->getFname()." ".$perso->getLname()."\"</a>
					</button>
				</div>
			</div>";
		echo $string;
	}
?>