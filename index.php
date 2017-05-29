<?php 
require('utiles/header.php');
//on teste si la s-globale session possède des clé définies pour les préférences
//par défaut, nous appliquerons le css de base et la typo de base
///////////////////////////// -- Changement du thème (couleur) -- //////////////////////////////
if(isset($_SESSION['theme']))
{
	if($_SESSION['theme']=="Rouge")
		$css="<link href=\"styles/index_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
	else if($_SESSION['theme']=="Bleu")
		$css="<link href=\"styles/index_css_blue.css\" rel=\"stylesheet\" type=\"text/css\"/>";
	else
		$css="<link href=\"styles/index_css_green.css\" rel=\"stylesheet\" type=\"text/css\"/>";
	echo $css;
}
else
	echo "<link href=\"styles/index_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
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
else
	echo "<script>
			$(document).ready(function(){
				$('html,input,button').css('font-family','Trebuchet MS, sans-serif');
			});
		 </script>";
?>
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
						<form method="get" action="/recherche/recherche.php">
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
						<li id="selected">ACCUEIL</li>
						<li><a href="series.php">SERIES</a></li>
						<li><a href="forum.php">FORUM</a></li>
						<li><a href="personnalites.php">PERSONNALITES</a></li>
					</ul>
				</div>
				<div id="account">
					<ul>
						<li>
							<?php 
								if(isset($_SESSION['connected']))
									echo '<a href="compte.php">> MON COMPTE</a>';
								else
									echo '<a href="connexion.php">> SE CONNECTER</a>';
							?>
						</li>
					</ul>
				</div>
			</div>
			<div id="sep">
				<marquee>DOLBY SERIES EST UN NOUVEAU SITE DEDIE AUX SERIES DU MOMENT !</marquee>
			</div>						
<?php
//on charge notre tableau de données ($index)
require('php/get_infos_index.php');

//chargement du contenu
load_main($index);
load_footer();
load_header_end();

//implémentation des fonctions de chargement de données
function load_main($index)
{
	
	$string="<div id=\"main\">";		
	$string.=load_main_slideshow($index);
	$string.="<div id=\"main_content\">";
	$string.=load_top_5_years_series_zone($index);
	$string.=load_video_zone("https://www.youtube.com/embed/N9i2WDv5E3g?autohide=1&autoplay=1&controls=0&vq=hd1080&iv_load_policy=3&modestbranding=1&rel=0&showinfo=0&theme=light");
	$string.=load_series_selection_zone();
	$string.=load_div_series_zone();
	$string.=load_user_birthday_zone($index);
	$string.="</div></div>";
	echo $string;
}

function load_footer()
{
	require('utiles/footer.php'); 
}

function load_header_end()
{
	require('utiles/header_end.php'); 
}

//-----------------------------------------FONCTIONS POUR LA ZONE DE SELECTION PAR CRITERE-------------------------------------//
//fonction qui charge les genres d'une série en particulier
function load_series_genres($series)
{
	$str="";
	foreach($series->getGenres() as $genre)
		$str.=$genre.", ";
	$str=substr($str,0,-2);
	return $str;
}

//fonctions qui charge l'ensemble des genres des séries du site
function load_genres() //width: 50% -- inline
{
	require("db.php");
	$sql="select nom_genre from genres";
	$req=$db->prepare($sql);
	$req->execute();
	$res=$req->fetchAll(PDO::FETCH_ASSOC);
	return $res;
	//deconnexion db
}

//fonction qui charge l'ensemble des années des séries du site
function load_years() //width: 50 -- inline
{
	require("db.php");
	$sql="select distinct annee_serie as annee from series order by annee_serie desc";
	$req=$db->prepare($sql);
	$req->execute();
	$res=$req->fetchAll(PDO::FETCH_ASSOC);
	return $res;
	//deconnexion db
}

//fonction qui charge l'ensemble des pays des séries du site
function load_countries() //width: 25% -- inline
{
	require("db.php");
	$sql="select distinct pays_serie as pays from series order by pays_serie asc";
	$req=$db->prepare($sql);
	$req->execute();
	$res=$req->fetchAll(PDO::FETCH_ASSOC);
	return $res;
	//deconnexion db
}

//--------------------------------------------------------FONCTIONS POUR L'ANNIVERSAIRE UTILISATEUR-------------------------------------------//
//fonction qui charge l'avatar de l'utilisateur dont c'est l'anniversaire
function load_user_bd_avatar($index)
{
	if($index['birthday']['avatar']==sha1("basic_avatar.png"))
		$str="avatars/basic_avatar.png";
	else
		$str="avatars/".sha1($index['birthday']['pseudo'])."/".sha1($index['birthday']['pseudo']).".png";
	return $str;
}

//-----------------------------------------FONCTIONS DE CHARGEMENT DES ZONES PRINCIPALES DE LA PAGE D'ACCUEIL-------------------------------------//
function load_main_slideshow($index)
{
	$i=1;
	$string="<div id=\"slideshow_container\">
	<div id=\"slideshow\">";				
		foreach($index['series_top_5_year'] as $series)
		{
			$string.="<img id=\"slide_".$i."\" class=\"slideshow_bg_pic\" src=\"".$series->getBackground()."\"/>
			<img id=\"slideshow_blank_space_".$i."\" class=\"superimposed\" src=\"medias/slideshow/slideshow_blank_space1.png\"/>
			<div id=\"slideshow_title_".$i."\" class=\"superimposed\">
				<p class=\"title_text\"><a class=\"title_link\" href=\"series/fiche_serie.php?titre=".$series->getName()."\">".$series->getName()."</a></p>
			</div>";
			$i++;
		}
		$string.="</div>";
		$string.="<img src=\"medias/slideshow/arrow_left.png\" class=\"slideshow_arrow sa_left\" onclick=\"shift_slide(-1)\"/>
		<img src=\"medias/slideshow/arrow_right.png\" class=\"slideshow_arrow sa_right\" onclick=\"shift_slide(1)\"/>
	</div>
	<div style=\"text-align:center\">
		<span id=\"id_1\" class=\"indicator\" onclick=\"select_slide(1)\"></span> 
		<span id=\"id_2\" class=\"indicator\" onclick=\"select_slide(2)\"></span> 
		<span id=\"id_3\" class=\"indicator\" onclick=\"select_slide(3)\"></span>
		<span id=\"id_4\" class=\"indicator\" onclick=\"select_slide(4)\"></span> 
		<span id=\"id_5\" class=\"indicator\" onclick=\"select_slide(5)\"></span>  
	</div>";
	return $string;
}

function load_top_5_years_series_zone($index)
{
	$string="<div id=\"top_5_year_series\">
	<table>
		<tbody>
			<tr>";
		foreach($index['series_top_5_year'] as $series)
		{
			$string.="<td><a href=\"/series/fiche_serie.php?titre=".$series->getName()."\"><img class=\"t5ys_pic\" src=\"".$series->getCover()."\"/></a></td>";
		}
		$string.="</tr>
		<tr>";
			foreach($index['series_top_5_year'] as $series)
			{
				$string.="<td><p class=\"t5ys_title\"><a href=\"/series/fiche_serie.php?titre=".$series->getName()."\">".$series->getName()."</a></p></td>";
			}
			$string.="</tr>
			<tr>";
				foreach($index['series_top_5_year'] as $series)
				{		
					$string.="<td><p class=\"t5ys_genre\">".load_series_genres($series)."</p></td>";
				}
				$string.="</tr>
			</tbody>
		</table>
	</div>";
	return $string;
}

function load_video_zone($url)
{
	return "<iframe id=\"yt_video\"height=\"470\" src=\"".$url."\" frameborder=\"0\" allowfullscreen></iframe>";
}

function load_series_selection_zone()
{
	$tab_genres=load_genres();
	$tab_annees=load_years();
	$tab_pays=load_countries();
	$str="<div id=\"series_selection_zone\">
	<p>Rechercher une série par critère</p>";
	//genres
	$str.="	<table id=\"genres\" class=\"selection_table\">
	<tbody>
		<tr>
			<th>Par genre</th>
		</tr>";
		foreach($tab_genres as $genre)
			$str.=			"<tr><td><p class=\"div_genre\">".$genre['nom_genre']."</p></td></tr>";
		$str.=		"</tbody>
	</table>";
	//annees
	$str.="	<table id=\"annees\" class=\"selection_table\">
	<tbody>
		<tr>
			<th>Par année</th>
		</tr>";
		foreach($tab_annees as $annee)
			$str.=			"<tr><td><p class=\"div_year\">".$annee['annee']."</p></td></tr>";
		$str.=		"</tbody>
	</table>";
	//pays
	$str.="	<table id=\"pays\" class=\"selection_table\">
	<tbody>
		<tr>
			<th>Par pays</th>
		</tr>";
		foreach($tab_pays as $pays)
			$str.=			"<tr><td><p class=\"div_country\">".$pays['pays']."</p></td></tr>";
		$str.=		"</tbody>
	</table>";
	$str.=  "</div>";
	return $str;
}

function load_div_series_zone()
{
	$string="<div id=\"div_series_zone\">
				<div id=\"div_series_by_genre\">
				</div>
				<div id=\"div_series_by_year\">
				</div>
				<div id=\"div_series_by_country\">
				</div>
				<div class=\"close_div_series_button\">
					<button onclick=\"close_div_series_zone()\" class=\"close_button\">Fermer</button>
				</div>
			</div>
			";
	return $string;
}

function load_user_birthday_zone($index)
{
	if(!empty($index['birthday']))
	{
		$string.="<div class=\"user_birthday\">
					<img id=\"user_avatar\" src=\"".load_user_bd_avatar($index)."\"/>
					<p>C'est l'anniversaire de ".$index['birthday']['pseudo']." !</p>
					<p>Joyeux anniversaire à ";
					if($index['birthday']['sexe']=='M')
						$string.="lui !";
					else
						$string.="elle !";
					$string.="</p>
				</div>";
	}
	return $string;
}
?>
