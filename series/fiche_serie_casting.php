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
	load_staff_creators_zone($series);
	load_staff_actors_zone($series);
	load_staff_producers_zone($series);
	load_staff_directors_zone($series);
	load_main_footer($series);
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
				 echo "<link href=\"../styles/series/fiche_serie_casting_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
			else if($_SESSION['theme']=="Bleu")
				echo "<link href=\"../styles/series/fiche_serie_casting_css_blue.css\" rel=\"stylesheet\" type=\"text/css\"/>";
			else
				echo "<link href=\"../styles/series/fiche_serie_casting_css_green.css\" rel=\"stylesheet\" type=\"text/css\"/>";
		}
		else
			echo "<link href=\"../styles/series/fiche_serie_casting_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
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

	//ici on charge la photo d'une personnalité
	//la fonction prend en paramètres le tableau de personnalités (acteurs, producteurs etc.) et l'index que l'on est en train de consulter
	//l'index que l'on est e train de consulter contient les prénom et nom (DANS CET ORDRE !) de la personnalité
	//on isole le prénom et le nom
	//on cherche dans la bdd la photo qui correspond à l'individu en question
	//on retour l'url de la photo contenue dans la bdd
	function load_perso_photo($tab,$index)
	{
		require("../db.php");
		$nom=load_perso_lname($tab,$index);
		$prenom=load_perso_fname($tab,$index);
		$sql="select url from photo_individu where id_ind in(select id_ind from individus where nom_ind=:lname and pren_ind=:fname)";
		$req=$db->prepare($sql);
		$req->bindValue(":lname",$nom);
		$req->bindValue(":fname",$prenom);
		$req->execute();
		$res=$req->fetch(PDO::FETCH_ASSOC);
		if(isset($res) && !empty($res))
			$str.=$res['url'];
		return $str;
	}

	//ici on charge le prénom de la personnalité
	//on recoit en paramètres le tableau de personnalités (acteurs, directeurs, réalisateurs etc.) et l'index de la ligne de ce tableau que l'on est en train de regarder
	//cette ligne contient les prénom et nom (DANS CET ORDRE !) de la personnalité
	//on récupère cette chaine, on l'explose en deux (ou plus), ce qui nous crée un tableau
	//on récupère la première valeur de ce tableau (on partira du principe que même dans les noms composés, la première valeur avant d'atteindre le premier espace correpsond toujours au prénom)
	function load_perso_fname($tab,$index)
	{
		$t=explode(" ",$tab[$index]);
		return($t[0]);
	}

	//ici on charge le nom de la personnalité
	//même fonctionnement que pour le prénom
	//ici on récupère tout à partir de la deuxième valeur du tableau en partant du même principe que le prénom se positionne toujours dans la première case
	function load_perso_lname($tab,$index)
	{
		$str="";
		$t=explode(" ",$tab[$index]);
		for($x=1;$x<count($t);$x++)
			$str.=$t[$x]." ";
		$str=substr($str,0,-1);
		return $str; 
	}

	function load_perso_names($tab,$index)
	{
		return $tab[$index];
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
					<div id=\"selected\" class=\"menu_tab\">
						<p>CASTING</p>
					</div>
					<div class=\"menu_tab reviews\">
						<p><a href=\"fiche_serie_critiques.php?titre=".$series->getName()."\">NOTES & CRITIQUES</a></p>
					</div>
					<div class=\"menu_tab seasons\">
						<p><a href=\"fiche_serie_saisons.php?titre=".$series->getName()."\">SAISONS</a></p>
					</div>
				</div>";
		echo $string;
	}
	
	//ici on charge la zone des créateurs de la série
	//une div "creator" est crée à chaque créateur trouvé dans le tableau de créateurs contenu dans l'attribut "creators" de l'objet $series
	function load_staff_creators_zone($series)
	{
		$string="<div id=\"staff_creators\">
					<div class=\"series_staff_label\"><p>Créateurs</p></div>";
					for($i=0;$i<count($series->getCreators());$i++)
					{
						$string.="<div class=\"creator\">
									<div id=\"staff_creators_pics\">
										<a href=\"../personnalites/fiche_perso.php?nom=".load_perso_lname($series->getCreators(),$i)."&prenom=".load_perso_fname($series->getCreators(),$i)."\"><img class=\"staff_pic\" src=\"".load_perso_photo($series->getCreators(),$i)."\"/></a>
									</div>
									<div id=\"staff_creators_desc\">
										<p class=\"staff_creators_names\"><a href=\"../personnalites/fiche_perso.php?nom=".load_perso_lname($series->getCreators(),$i)."&prenom=".load_perso_fname($series->getCreators(),$i)."\">".load_perso_names($series->getCreators(),$i)."</a></p>
									</div>
								</div>";
					}
		$string.="</div>";
		echo $string;
	}

	//idem que la fonction précédente
	function load_staff_actors_zone($series)
	{
		$string="<div id=\"staff_actors\">
					<div class=\"series_staff_label\"><p>Acteurs</p></div>";
					for($i=0;$i<count($series->getActors());$i++)
					{
						$string.="<div class=\"actor\">
									<div id=\"staff_actors_pics\">
										<a href=\"../personnalites/fiche_perso.php?nom=".load_perso_lname($series->getActors(),$i)."&prenom=".load_perso_fname($series->getActors(),$i)."\"><img class=\"staff_pic\" src=\"".load_perso_photo($series->getActors(),$i)."\"/></a>
									</div>
									<div id=\"staff_actors_desc\">
										<p class=\"staff_actors_names\"><a href=\"../personnalites/fiche_perso.php?nom=".load_perso_lname($series->getActors(),$i)."&prenom=".load_perso_fname($series->getActors(),$i)."\">".load_perso_names($series->getActors(),$i)."</a></p>
									</div>
								</div>";
					}
		$string.="</div>";
		echo $string;
	}

	//idem que la fonction précédente
	function load_staff_producers_zone($series)
	{
		$string="<div id=\"staff_producers\">
					<div class=\"series_staff_label\"><p>Producteurs</p></div>";
					for($i=0;$i<count($series->getProducers());$i++)
					{
						$string.="<div class=\"producer\">
									<div id=\"staff_producers_pics\">
										<a href=\"../personnalites/fiche_perso.php?nom=".load_perso_lname($series->getProducers(),$i)."&prenom=".load_perso_fname($series->getProducers(),$i)."\"><img class=\"staff_pic\" src=\"".load_perso_photo($series->getProducers(),$i)."\"/></a>
									</div>
									<div id=\"staff_producers_desc\">
										<p class=\"staff_producers_names\"><a href=\"../personnalites/fiche_perso.php?nom=".load_perso_lname($series->getProducers(),$i)."&prenom=".load_perso_fname($series->getProducers(),$i)."\">".load_perso_names($series->getProducers(),$i)."</a></p>
									</div>
								</div>";
					}
		$string.="</div>";
		echo $string;
	}

	//idem que la fonction précédente
	function load_staff_directors_zone($series)
	{
		$string="<div id=\"staff_directors\">
					<div class=\"series_staff_label\"><p>Réalisateurs</p></div>";
					for($i=0;$i<count($series->getDirectors());$i++)
					{
						$string.="<div class=\"director\">
									<div id=\"staff_directors_pics\">
										<a href=\"../personnalites/fiche_perso.php?nom=".load_perso_lname($series->getDirectors(),$i)."&prenom=".load_perso_fname($series->getDirectors(),$i)."\"><img class=\"staff_pic\" src=\"".load_perso_photo($series->getDirectors(),$i)."\"/></a>
									</div>
									<div id=\"staff_directors_desc\">
										<p class=\"staff_directors_names\"><a href=\"../personnalites/fiche_perso.php?nom=".load_perso_lname($series->getDirectors(),$i)."&prenom=".load_perso_fname($series->getDirectors(),$i)."\">".load_perso_names($series->getDirectors(),$i)."</a></p>
									</div>
								</div>";
					}
		$string.="</div></div>";
		echo $string;
	}

	//ici on charge le bouton de de retour vers la page "Fiche série"
	function load_main_footer($series)
	{
		$string="<div id=\"main_footer\">
					<button>
						<a href=\"fiche_serie.php?titre=".$series->getName()."\">Retour à la fiche de \"".$series->getName()."\"</a>
					</button>
				</div></div>";
		echo $string;
	}
?>
								
					
