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
	$array = array();
?>
	<script src="../js/forum/functions.js"></script>
<title>Forum</title>
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
//Le cas du forum des séries, on a besoin que l'id (f) du forum des séries soit 2 ET d'avoir un paramètre s dans l'URL
try
{
	if ((isset($_GET['f']) && ((int) htmlentities($_GET['f']) == 2)) && isset($_GET['s']))
	{
		$titre = '';
		$f = htmlentities($_GET['f']);
		$f = (int) $f;
		$s = htmlentities($_GET['s']);
		$s = (int) $s;
		
		//On récupère le titre de la série en question pour pouvoir l'afficher dans le traçage
		$titreserie = $db->prepare('SELECT TITRE_SERIE from series WHERE ID_SERIE = :s');
		$titreserie->bindValue(':s', $s);
		$titreserie->execute();
		if($tracserie = $titreserie->fetch(PDO::FETCH_NUM))
			$titre = $tracserie[0];
		
		//Une sorte de traçage à été mis en place pour permettre à l'utilisateur de se retrouver lors de sa navigation sur le forum
		switch ($f) {
				
			case 2:
				echo'<div class="subject-link">
					<a href="../forum.php" id="tracage">Accueil du forum</a> > <a href="viewseries.php" id="tracage">Séries</a> > 
					<span class="current">'.$titre.'</span>
				</div>';
				break;
			
			case 0:
				break;
		}
		
		echo '<div id="new_topic"><a href="rediger.php?f='.$f.'&s='.$s.'"><button class="new_topic">NOUVEAU SUJET</button></a></div>';
		
		//On sélectionne les titres des messages qui appartiennent au forum en question
		$req = $db->prepare('SELECT ID_MSG, PSEUDO, TITRE_MSG, DATE_MSG FROM messages WHERE ID_FORUM = :id AND ID_SERIE = :ids');
		$req->bindValue(':id', $f);
		$req->bindValue(':ids', $s);
		
		//on selectionne la derniere reponse à ce message
		$lastmsg = $db->prepare('SELECT PSEUDO, DATE_RPS FROM reponses WHERE ID_MSG = :id order by ID_RPS desc');
		
		//et on compte le nombre de réponses que ce message a eu
		$countrep = $db->prepare('SELECT COUNT(*) FROM reponses WHERE ID_MSG = :id');
		
		$req->execute();
		
		echo '
			<div id="main_content">
				<div id="container">
					<table id="forum-table">
						<tbody id="subject-list">
							<tr id="table-title">
								<td>SUJETS</td>
								<td>REPONSES</td>
								<td>DERNIER MESSAGE</td>
							</tr>';
			//on affiche le tout avec les informations que l'on a collectées,
			//et que l'on va collecter dans les requêtes qui seront executées dans la suite du code
			while ($rep = $req->fetch(PDO::FETCH_NUM))
		{
			$lastmsg->bindValue(':id', $rep[0]);
			$lastmsg->execute();
			
			//on récupère les informations dans un tableau : 
			//Les clefs de ce tableaux correspondent à la date de la dernière réponse (dans le cas du if)
			//ou alors à la date de création du message (dans le cas else)
			
			if($rep_lastmsg = $lastmsg->fetch(PDO::FETCH_NUM)) //si la requete concernant la derniere réponse aboutit
			{
				$countrep->bindValue(':id', $rep[0]);
				$countrep->execute();
				$rep_countrep = $countrep->fetch(PDO::FETCH_NUM);
				
				$array[strtotime($rep_lastmsg[1])] = 
				array(
				"f" => $f, 
				"t" => $rep[0], 
				"titre_msg" => $rep[2], 
				"auteur_msg" => $rep[1], 
				"date_msg" =>$rep[3], 
				"nb_rps" => $rep_countrep[0],
				"auteur_last_rep" => 'Par '.$rep_lastmsg[0],
				"date_last_rep" => '<div class="summary">'.formater_date($rep_lastmsg[1]).'
								</div>');
			}
			
			else
				$array[strtotime($rep[3])] = 
				array(
				"f" => $f, 
				"t" => $rep[0], 
				"titre_msg" => $rep[2], 
				"auteur_msg" => $rep[1],
				"date_msg" => $rep[3],
				"nb_rps" => 0,
				"date_last_rep" => 'Pas encore de réponse');
		}
		//On classe ensuite le tableau dans l'ordre antichronologique (du plus récent au plus vieux) 
		//de ses clefs (les dates)
		krsort($array);
		
		//On affiche ensuite, bien entendu, les messages ayant eu une réponse en premier,
		foreach($array as $date => $info)
		{
			if(!isset($info["auteur_last_rep"]))
				echo'
						<tr class="subject-list-row">
							<td class="subject-title">
								<div class="subject-link">
									<a href="viewtopic.php?f='.$info["f"].'&t='.$info["t"].'">'.$info["titre_msg"].'</a>
								</div> 
								<div class="summary">Par '.$info["auteur_msg"].', '.formater_date($info["date_msg"]).'
								</div>
							</td>
							<td class="nb_subject">'.$info["nb_rps"].'</td>
							<td class="last-msg">'.$info["date_last_rep"].'</td>
						</tr>';
			
			else
				echo'
						<tr class="subject-list-row">
							<td class="subject-title">
								<div class="subject-link">
									<a href="viewtopic.php?f='.$info["f"].'&t='.$info["t"].'">'.$info["titre_msg"].'</a>
								</div> 
								<div class="summary">Par '.$info["auteur_msg"].', '.formater_date($info["date_msg"]).'
								</div>
							</td>
							<td class="nb_subject">'.$info["nb_rps"].'</td>
							<td class="last-msg"> '.$info["auteur_last_rep"].''.$info["date_last_rep"].'</td>
						</tr>';
		}
			echo '		</tbody>
					</table>
				</div>
			</div>
		</div>';
	}

	//Le cas des autres forums
	else if (isset($_GET['f']) && ((int) htmlentities($_GET['f']) != 2))
	{
		
		$f = htmlentities($_GET['f']);
		$f = (int) $f;
		
		//Une sorte de traçage à été mis en place pour permettre à l'utilisateur de se retrouver lors de sa navigation sur le forum	
		switch ($f) {
			case 1:
				echo'<div class="subject-link">
					<a href="../forum.php" id="tracage">Accueil du forum</a> > <span class="current" id="tracage">Présentation du forum</span>
				</div>';
				break;
			
			case 3:
				echo'<div class="subject-link">
					<a href="../forum.php" id="tracage">Accueil du forum</a> > <span class="current" id="tracage">Discussions diverses</span>
				</div>';
				break;
			
			case 4:
				echo'<div class="subject-link">
					<a href="../forum.php" id="tracage">Accueil du forum</a> > <span class="current" id="tracage">Suggestions et remarques</span>
				</div>';
				break;
			
			case 0:
				break;
		}
		
		//Exactement le même procédé que dans le cas des séries
		$req = $db->prepare('SELECT ID_MSG, PSEUDO, TITRE_MSG, DATE_MSG FROM messages WHERE ID_FORUM = :id');
		$req->bindValue(':id', $f);
		
		$lastmsg = $db->prepare('SELECT PSEUDO, DATE_RPS FROM reponses WHERE ID_MSG = :id order by ID_RPS desc');
		
		$countrep = $db->prepare('SELECT COUNT(*) FROM reponses WHERE ID_MSG = :id');
		$req->execute();
		
		echo '<div id="new_topic"><a href="rediger.php?f='.$f.'"><button class="new_topic">NOUVEAU SUJET</button></a></div>';
		echo '
		<div id="main_content">
			<div id="container">
				<table id="forum-table">
					<tbody id="subject-list">
						<tr id="table-title">
							<td>SUJETS</td>
							<td>REPONSES</td>
							<td>DERNIER MESSAGE</td>
						</tr>';
		while ($rep = $req->fetch(PDO::FETCH_NUM))
		{
			$lastmsg->bindValue(':id', $rep[0]);
			$lastmsg->execute();
			
			if($rep_lastmsg = $lastmsg->fetch(PDO::FETCH_NUM))
			{
				$countrep->bindValue(':id', $rep[0]);
				$countrep->execute();
				$rep_countrep = $countrep->fetch(PDO::FETCH_NUM);
				
				//on récupère les informations dans deux tableaux : le premier contient tous les messages à qui on a repondu,
				//tandis que le second contient tous les messages sans réponses.
				//Les clefs de ces tableaux correspondent à la date de la dernière réponse (dans le cas du premier tableau)
				//ou alors à la date de création du message (dans le cas du second tableau)
				$array[strtotime($rep_lastmsg[1])] = 
				array(
				"f" => $f, 
				"t" => $rep[0], 
				"titre_msg" => $rep[2], 
				"auteur_msg" => $rep[1], 
				"date_msg" =>$rep[3], 
				"nb_rps" => $rep_countrep[0],
				"auteur_last_rep" => 'Par '.$rep_lastmsg[0],
				"date_last_rep" => '<div class="summary">'.formater_date($rep_lastmsg[1]).'
								</div>');
			}
			
			else
				$array[strtotime($rep[3])] = 
				array(
				"f" => $f, 
				"t" => $rep[0], 
				"titre_msg" => $rep[2], 
				"auteur_msg" => $rep[1],
				"date_msg" => $rep[3],
				"nb_rps" => 0,
				"date_last_rep" => 'Pas encore de réponse');
		}
		//On classe ensuite ces tableaux dans l'ordre antichronologique (du plus récent au plus vieux) 
		//de leurs dates, passées en clefs, respectives
		krsort($array);
		
		//On affiche ensuite, bien entendu, les messages ayant eu une réponse en premier,
		foreach($array as $date => $info)
		{
			if(!isset($info["auteur_last_rep"]))
				echo'
						<tr class="subject-list-row">
							<td class="subject-title">
								<div class="subject-link">
									<a href="viewtopic.php?f='.$info["f"].'&t='.$info["t"].'">'.$info["titre_msg"].'</a>
								</div> 
								<div class="summary">Par '.$info["auteur_msg"].', '.formater_date($info["date_msg"]).'
								</div>
							</td>
							<td class="nb_subject">'.$info["nb_rps"].'</td>
							<td class="last-msg">'.$info["date_last_rep"].'</td>
						</tr>';
			
			else
				echo'
						<tr class="subject-list-row">
							<td class="subject-title">
								<div class="subject-link">
									<a href="viewtopic.php?f='.$info["f"].'&t='.$info["t"].'">'.$info["titre_msg"].'</a>
								</div> 
								<div class="summary">Par '.$info["auteur_msg"].', '.formater_date($info["date_msg"]).'
								</div>
							</td>
							<td class="nb_subject">'.$info["nb_rps"].'</td>
							<td class="last-msg"> '.$info["auteur_last_rep"].''.$info["date_last_rep"].'</td>
						</tr>';
		}
		echo '		</tbody>
				</table>
			</div>
		</div>
	</div>';
	}

	//Si l'on tombe ici, c'est que l'url qui a été fournie n'est pas la bonne
	else
	{
		header("Location: ../erreurs/404.php");
	}
}
catch (PDOException $e) 
{
	    echo "\n[EXCEPTION] La connexion a échoué";
	    die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
}	
?>


<?php require("../utiles/footer.php"); ?>
<?php require("../utiles/header_end.php"); ?>

