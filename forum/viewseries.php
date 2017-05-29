<?php
	require("../utiles/header.php");
	require("../db.php");
	require("fonctions_forum.php");
	if(isset($_SESSION['theme']))
	{
		if($_SESSION['theme']=="Rouge")
			echo "<link href=\"../styles/forum_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
		else if($_SESSION['theme']=="Bleu")
			echo "<link href=\"../styles/forum_css_blue.css\" rel=\"stylesheet\" type=\"text/css\"/>";
		else
			echo "<link href=\"../styles/forum_css_green.css\" rel=\"stylesheet\" type=\"text/css\"/>";
	}
	else
		echo "<link href=\"../styles/forum_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
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
	<script src="../js/forum/functions.js"></script>
<title>Liste des séries</title>
</head>
<body>
	<main>
		<header>
			<div id="header">
				<div id="logo_header">
					<a href="index.php">
					<?php 
					if(isset($_SESSION['theme']))
					{
						if($_SESSION['theme']=="Rouge")
							echo "<img src=\"../medias/logo_header_3.png\" alt=\"logo_header\"/>";
						else if($_SESSION['theme']=="Bleu")
							echo "<img src=\"../medias/logo_header_4.png\" alt=\"logo_header\"/>";
						else
							echo "<img src=\"../medias/logo_header_5.png\" alt=\"logo_header\"/>";
					}
					else
						echo "<img src=\"../medias/logo_header_3.png\" alt=\"logo_header\"/>";
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
<?php 

try
{
	$arrayrep = array();
	$arraynorep = array();
	echo'<div class="subject-link">
			<a href="../forum.php">Accueil du forum</a> > <span class="current">Séries</span>
		</div>';

	$req = $db->prepare('SELECT ID_SERIE, TITRE_SERIE, SUM_SERIE FROM series ORDER BY TITRE_SERIE');
	$req->execute();
	echo '
		<div id="main_content">
			<div id="container">
				<table id="forum-table">
					<tbody id="subject-list">
						<tr id="table-title">
							<td>SERIES</td>
							<td>SUJETS</td>
							<td>DERNIER SUJET</td>
						</tr>';
	while ($rep = $req->fetch(PDO::FETCH_NUM))
	{
		//on récupère les informations dans deux tableaux : le premier contient toutes les series dans lesquelles on a posté,
		//tandis que le second contient toutes les séries sans messages.
		//Les clefs de ces tableaux correspondent à la date du dernier sujet ouvert (dans le cas du premier tableau)
		//ou alors a rien !
		if (affiche_nb_sujets_serie($db, $rep[0]) != 0)
		{
			$lastmsg = affiche_dernier_message_serie($db, $rep[0]);
			$arrayrep[$lastmsg["date_msg"]] = 
			array(
			"s" => $rep[0],
			"titre" => $rep[1],
			"sum" => $rep[2],
			"nb_sub" => affiche_nb_sujets_serie($db, $rep[0]),
			"pseudo" => $lastmsg["pseudo"]
			);
		}
		
		else
		{
			$lastmsg = affiche_dernier_message_serie($db, $rep[0]);
			array_push($arraynorep,
					array(
					"s" => $rep[0],
					"titre" => $rep[1],
					"sum" => $rep[2]
					)
			);
		}	
	}

	//On classe ensuite ces tableaux dans l'ordre antichronologique (du plus récent au plus vieux) 
	//de leurs dates, passées en clefs, respectives
	//On affiche ensuite, bien entendu, les séries qui contiennent des messages
	krsort($arrayrep);
	foreach($arrayrep as $date => $info)
		echo 
					'	<tr class="subject-list-row">
							<td class="subject-title">
								<div class="subject-link">
									<a href="viewforum.php?f=2&s='.$info["s"].'">'.$info["titre"].'</a>
								</div>
								<div class="summary">
									'.$info["sum"].'
								</div>
							</td>
							<td class="nb_subject">'.$info["nb_sub"].'</td>
							<td class="last-msg">Par '.$info["pseudo"].'
								<div class="summary">'.formater_date($date).'
								</div>
							</td>
						</tr>';

	//puis celles qui n'en ont pas eu en second.
	foreach($arraynorep as $info)
		echo 
					'	<tr class="subject-list-row">
							<td class="subject-title">
								<div class="subject-link">
									<a href="viewforum.php?f=2&s='.$info["s"].'">'.$info["titre"].'</a>
								</div>
								<div class="summary">
									'.$info["sum"].'
								</div>
							</td>
							<td class="nb_subject">0</td>
							<td class="last-msg">Pas encore de message posté
							</td>
						</tr>';
	echo '			</tbody>
				</table>
			</div>
		</div>';
}
catch (PDOException $e) 
{
	    echo "\n[EXCEPTION] La connexion a échoué";
	    die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
}	
?>

<?php require("../utiles/footer.php"); ?>
<?php require("../utiles/header_end.php"); ?>

