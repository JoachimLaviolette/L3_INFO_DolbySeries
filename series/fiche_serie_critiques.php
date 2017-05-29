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
	load_review_page_infos($series);
	load_reviews_zone($series);
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
				echo "<link href=\"../styles/series/fiche_serie_critiques_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
			else if($_SESSION['theme']=="Bleu")
				echo "<link href=\"../styles/series/fiche_serie_critiques_css_blue.css\" rel=\"stylesheet\" type=\"text/css\"/>";
			else
				echo "<link href=\"../styles/series/fiche_serie_critiques_css_green.css\" rel=\"stylesheet\" type=\"text/css\"/>";
		}
		else
			echo "<link href=\"../styles/series/fiche_serie_critiques_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
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
		$string=substr($string,0,-2); //on enlève l'espace et la virgule à la fin de la chaine
		$string.="</p>";
		return $string;
	}

	//charge l'avatar de l'utilisateur ayant posté la review
	//on passe en paramètre le tableau de reviews (ici, nommé $series), et l'indice de la review qu'on est en train de regarder
	//même principe pour les fonctions qui suivent (pseudo, note, commentaire, date)
	function load_review_user_avatar($series,$index)
	{
		if($series[$index]['avatar_id_usr']==sha1("basic_avatar.png"))
			$str="../avatars/basic_avatar.png";
		else
			$str="../avatars/".sha1(load_review_user_pseudo($series,$index))."/".sha1(load_review_user_pseudo($series,$index)).".png";
		return $str;
	}

	function load_review_user_pseudo($series,$index)
	{
		return $series[$index]['pseudo_usr'];
	}

	function load_review_user_note($series,$index)
	{
		return $series[$index]['note_usr'];
	}

	function load_review_user_commentary($series,$index)
	{
		return $series[$index]['comm_usr'];
	}

	//dans la bdd, la colonne réservée à la date est enregistre les dates dans le format suivant : AAAA/MM/JJ hh:mm:ss
	//cette fonction formate la date pour au final donner une chaine lisible par tout utilisateur : ex --> "Le 01/01/2001 à 00h00" 
	function load_review_user_date($series,$index)
	{
		$date=$series[$index]['date_review']."";
		//format de $date dans la bdd: 2017-05-08 21:38:18
		$jour=substr($date,8,2);
		$mois=substr($date,5,2);
		$annee=substr($date,0,4);
		$heure=substr($date,11,2);
		$min=substr($date,14,2);
		return "Le ".$jour."/".$mois."/".$annee.", à ".$heure."h".$min;
	}

	//cette partie a été traitée en AJAX (voir : /js/series/ajax_calcul_moyenne.js)
	/*function load_series_average($series) 
	{
		return $series['moyenne'];
	}*/

	//ici on charge la zone d'infos de la série
	//la zone correspondante est celle avec le poster dégradé et les features de la série
	function load_series_zone($series)
	{
		$string="<div id=\"main\">
					<div id=\"popup_review_bg\"></div>
					<div id=\"popup_review\">
						<div id=\"review_form\">
							<div id=\"close_popup\"><img onclick=\"close_popup_review()\" src=\"../medias/croix_popup.jpg\"/></div>
							<form action=\"/php/series/noter_serie.php\" method=\"POST\" enctype=\"multipart/form-data\">
								<input style=\"display: none\" name=\"review_series_id\" value=\"".$series->getId()."\">
								<input style=\"display: none\" name=\"review_series_name\" value=\"".$series->getName()."\">
								<div id=\"review_title\">
									<p>Noter et critiquer une série</p>
								</div>
								<p id=\"success\" style=\"display:none;font-size:15px;text-align:center;\">Votre critique a été soumise avec succès !</p>
								<div class=\"review_user_note\">
									<label for=\"review_user_note\"><p>Note</p></label>
									<p id=\"alert_note\" style=\"display:none;color:#BC0404;font-weight:bold;font-size:13px;text-align:center;\">Vous devez saisir une note comprise entre 0 et 10 !</p>
									<input id=\"note\" type=\"number\" name=\"review_user_note\" min=\"0\" max=\"10\" required>					
								</div>
								<div class=\"review_user_commentary\">
									<label for=\"review_user_commentary\"><p>Commentaire</p></label>
									<p id=\"alert_review\" style=\"display:none;color:#BC0404;font-weight:bold;font-size:13px;text-align:center;\">Vous devez saisir un commentaire !</p>
									<textarea id=\"review\" type=\"textarea\" name=\"review_user_commentary\" placeholder=\"Saisissez ici le commentaire accompagnant votre note...\" ></textarea>
								</div>		
								<button type=\"submit\" id=\"review_submit_button\">Valider la critique !</button>
							</form>
						</div>
					</div>
					<div id=\"popup_review_connection_required\">
						<div id=\"close_popup\"><img onclick=\"close_popup_review_connection_required()\" src=\"../medias/croix_popup.jpg\"/></div>
						<p>Vous devez être connecté pour noter cette série !</p>
						<div id=\"login\">
							<button onclick=\"save_url_page_serie_note()\">
								<a href=\"../connexion.php\">
									S'IDENTIFIER MAINTENANT !
								</a>
							</button>
						</div>
					</div>
					<div id=\"main_title\">	
						<p>SERIES</p>
					</div>
					<input id=\"pseudo_u\" type=\"hidden\" value=\"".$_SESSION['pseudo']."\">
					<input id=\"id_s\" type=\"hidden\" value=\"".$series->getId()."\">
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
					<div id=\"selected\" class=\"menu_tab reviews\">
						<p>NOTES & CRITIQUES</p>
					</div>
					<div class=\"menu_tab seasons\">
						<p><a href=\"fiche_serie_saisons.php?titre=".$series->getName()."\">SAISONS</a></p>
					</div>
				</div>";
		echo $string;
	}

	//ici nous chargeons toutes les d'informations textuelles de la zone de critiques
	//dans la div réservée à la moyenne, le traitement est fait en ajax (voir /js/series/ajax_calcul_moyenne.js)
	function load_review_page_infos($series)
	{
		$string="<div id=\"review_page_title\"><p>Notes et critiques de la série</p></div>
				<div id=\"series_average\">
				</div>
				<input id=\"series_id\" name=\"series_id\" type=\"hidden\" value=\"".$series->getId()."\">
				<div id=\"review_desc\">
					<p>Vous pouvez noter la série et laisser un avis formulé en cliquant sur le bouton ci-dessous.</p>
				</div>
				<div id=\"review_action\">
					<button onclick=\"";
					if($_SESSION['connected']) //si l'utilisateur est sur la page de notation et connecté, quand il clique sur "noter la série", ouvre la popup de notation
						$string.="open_popup_review()"; 
					else //sinon, lui indique qu'il faut s'identifier
						$string.="open_popup_review_connection_required()";
		$string.="\">Noter la série</button>
				</div>";
		echo $string;
	}

	//ici on charge les critiques faites par els utilisateurs quant à la série 
	//on récupère le tableau de critiques depuis l'objet $series et nous le parcourons
	function load_reviews_zone($series)
	{
		$string="<div id=\"reviews_zone\">";
					for($i=0;$i<count($series->getReviews());$i++)
					{
						$string.="<div class=\"review\">
									<div id=\"review_header\">
										<table>
											<tr>
												<td id=\"avatar_user\">
													<img src=\"".load_review_user_avatar($series->getReviews(),$i)."\"/></p> 
												</td>
												<td id=\"pseudo_user\">
													<p>".load_review_user_pseudo($series->getReviews(),$i)."</p>
												</td>
												<td id=\"note_user\">
													<p>".load_review_user_note($series->getReviews(),$i)."/10</p>
												</td>
											</tr>
										</table>
									</div>
									<div id=\"review_commentary\">
										<p>".load_review_user_commentary($series->getReviews(),$i)."</p>
									</div>
									<div id=\"review_date\">
										<p>".load_review_user_date($series->getReviews(),$i)."</p>
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
								
					
