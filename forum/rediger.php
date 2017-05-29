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
	if($_SESSION['connected']==true)
	{
		//on regarde si l'on est dans le forum des séries
		if ((isset($_GET['f']) && ((int) htmlentities($_GET['f']) == 2)) && isset($_GET['s']))
		{
			$f = htmlentities($_GET['f']);
			$f = (int) $f;
			$s = htmlentities($_GET['s']);
			$s = (int) $s;
			
			$titreserie = $db->prepare('SELECT TITRE_SERIE from series WHERE ID_SERIE = :s');
			$titreserie->bindValue(':s', $s);
			$titreserie->execute();
			if($rep = $titreserie->fetch(PDO::FETCH_NUM))
				//traçage
				echo'<div class="subject-link">
					<a href="../forum.php" id="tracage">Accueil du forum</a> > <a href="viewseries.php" id="tracage">Séries</a> > <span class="current">'.$rep[0].'</span>
				</div>';
			
			echo 
				'<div class="forum_post">
						<div id="forum_post_header">
							<table>
								<tr>
									<td id="avatar_user">
										<img src="'.load_user_avatar($db, $_SESSION['pseudo']).'"/>
									</td>
									<td id="posting">
										<p>Poste ton message !</p>
									</td>
								</tr>
							</table>
						</div>
						<div id="post">
							<form method="post" action="poster.php">
								<p id="alert_title" style="display:none;margin:1.5%;color:#BC0404;font-weight:bold;font-size:13px;text-align:center;">Vous devez indiquer un titre pour valider votre post !</p>
								<input id="new_message_title" class="title" type="text" name="t" placeholder="Titre du sujet">
								<p id="alert_content" style="display:none;margin:1.5%;color:#BC0404;font-weight:bold;font-size:13px;text-align:center;">Vous devez remplir ce champ pour valider votre post !</p>
								<textarea id="new_message_content" name="post" placeholder="Message..." size="1024" maxlength="1024"></textarea>
								<input type="hidden" name="s" value="'.$s.'">
								<input type="hidden" name="f" value="'.$f.'">
								<button type="submit" id="post_msg" class="submit_message" disabled>ENVOYER</button>
							</form>
						</div> 
				</div>';
		}
		
		//on est dans les autres forums
		else if (isset($_GET['f']))
		{
			$f = htmlentities($_GET['f']);
			$f = (int) $f;
			
			//traçage
			switch ($f) {
			case 1:
				echo'<div class="subject-link">
					<a href="../forum.php" id="tracage">Accueil du forum</a> > <a href="viewforum.php?f=1" id="tracage">Présentation du forum</a> > <span class="current">Nouveau Sujet</span>
				</div>';
				break;
			
			case 2:
				header("Location: ../erreurs/404.php");
				break;
			
			case 3:
				echo'<div class="subject-link">
					<a href="../forum.php" id="tracage">Accueil du forum</a> > <a href="viewforum.php?f=3" id="tracage">Discussions diverses</a> > <span class="current">Nouveau Sujet</span>
				</div>';
				break;
			
			case 4:
				echo'<div class="subject-link">
					<a href="../forum.php" id="tracage">Accueil du forum</a> > <a href="viewforum.php?f=4" id="tracage">Suggestions et remarques</a> > <span class="current">Nouveau Sujet</span>
				</div>';
				break;
			
			case 0:
				break;
		}
			
			echo '<div class="forum_post">
						<div id="forum_post_header">
							<table>
								<tr>
									<td id="avatar_user">
										<img src="'.load_user_avatar($db, $_SESSION['pseudo']).'"/>
									</td>
									<td id="posting">
										<p>Poster un message</p>
									</td>
								</tr>
							</table>
						</div>
						<div id="post">
							<form method="post" action="poster.php">
								<p id="alert_title" style="display:none;margin:1.5%;color:#BC0404;font-weight:bold;font-size:13px;text-align:center;">Vous devez indiquer un titre pour valider votre post !</p>
								<input id="new_message_title" class="title" type="text" name="t" placeholder="Titre du sujet">
								<p id="alert_content" style="display:none;margin:1.5%;color:#BC0404;font-weight:bold;font-size:13px;text-align:center;">Vous devez remplir ce champ pour valider votre post !</p>
								<textarea id="new_message_content" name="post" placeholder="Message..." size="1024" maxlength="1024"></textarea>
								<input type="hidden" name="f" value="'.$f.'">
								<button class="submit_message" type="submit" id="post_msg" disabled>ENVOYER</button>
							</form>
					</div> 
				</div>';
		}

		else
		{
			header("Location: ../erreurs/404.php");
		}
	}
	else
	{
		header("Location: ../connexion.php");
	}
}
catch (PDOException $e) 
{
	    echo "\n[EXCEPTION] La connexion a échoué";
	    die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
}	
?>
	</div>
</div>
<?php require("../utiles/footer.php"); ?>
<?php require("../utiles/header_end.php"); ?>
