<?php 
require("utiles/header.php"); 
require("db.php");
require("forum/fonctions_forum.php");
/////////////////////////////// -- Changement du thème (couleur) -- ///////////////////////////////////
if(isset($_SESSION['theme']))
{
	if($_SESSION['theme']=="Rouge")
		echo "<link href=\"styles/forum_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
	else if($_SESSION['theme']=="Bleu")
		echo "<link href=\"styles/forum_css_blue.css\" rel=\"stylesheet\" type=\"text/css\"/>";
	else
		echo "<link href=\"styles/forum_css_green.css\" rel=\"stylesheet\" type=\"text/css\"/>";
}
else
	echo "<link href=\"styles/forum_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
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
?>	
		<script src="/js/forum/functions.js"></script>
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
						<li><a href="../index.php">ACCUEIL</a></li>
						<li><a href="../series.php">SERIES</a></li>
						<li id="selected">FORUM</li>
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
			<div id="main">
				<div id="main_title">	
					<p>FORUM</p>
				</div>
				<div id="main_content">
					<div id="container">
						<table id="forum-table">
							<tbody id="subject-list">
								<tr id="table-title">
									<td>CATEGORIES</td>
									<td>SUJETS</td>
									<td>MESSAGES</td>
									<td>DERNIER MESSAGE</td>
								</tr>
								<tr class="subject-list-row">
									<td class="subject-title">
										<div class="subject-link">
											<a href="forum/viewforum.php?f=1">Présentation du Forum</a>
										</div> 
										<div class="summary">
											Le première étape après t'être inscrit, c'est ici ! On y explique quelques généralités sur le forum de Dolby Series. Tu peux aussi te présenter au reste de la communauté !
										</div>
									</td>
									<td class="nb_subject"><?php affiche_nb_sujets_forum($db, 1);?></td>
									<td class="nb-msg"><?php affiche_nb_messages_forum($db, 1);?></td>
									<td class="last-msg"><?php affiche_dernier_message_forum($db, 1);?></td>
								</tr>
								<tr class="subject-list-row">
									<td class="subject-title">
										<div class="subject-link">
											<a href="forum/viewseries.php">Séries</a>
										</div>
										<div class="summary">
											Viens discuter et partager tes émotions à propos de tes séries favorites !
										</div>
									</td>
									<td class="nb_subject"><?php affiche_nb_sujets_forum($db, 2);?></td>
									<td class="nb-msg"><?php affiche_nb_messages_forum($db, 2);?></td>
									<td class="last-msg"><?php affiche_dernier_message_forum($db, 2);?></td>
								</tr>
								<tr class="subject-list-row">
									<td class="subject-title">
										<div class="subject-link">
											<a href="forum/viewforum.php?f=3">Discussions diverses</a>
										</div>
										<div class="summary">
											Ici, on parle de tout et de rien, mais pas des séries.
										</div>
									</td>
									<td class="nb_subject"><?php affiche_nb_sujets_forum($db, 3);?></td>
									<td class="nb-msg"><?php affiche_nb_messages_forum($db, 3);?></td>
									<td class="last-msg"><?php affiche_dernier_message_forum($db, 3);?></td>
								</tr>
								<tr class="subject-list-row">
									<td class="subject-title">
										<div class="subject-link">
											<a href="forum/viewforum.php?f=4">Suggestions et remarques</a>
										</div>
										<div class="summary">
											Une suggestion ou une remarque sur le site ? Ecris-nous un petit mot !
										</div>
									</td>
									<td class="nb_subject"><?php affiche_nb_sujets_forum($db, 4);?></td>
									<td class="nb-msg"><?php affiche_nb_messages_forum($db, 4);?></td>
									<td class="last-msg"><?php affiche_dernier_message_forum($db, 4);?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
<?php require("utiles/footer.php"); ?>
<?php require("utiles/header_end.php"); ?>
