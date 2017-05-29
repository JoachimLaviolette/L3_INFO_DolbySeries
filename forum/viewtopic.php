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
try
{
	if (isset($_GET['f']) && isset($_GET['t']))
	{
		$f = htmlentities($_GET['f']);
		$t = htmlentities($_GET['t']);
		$f = (int) $f;
		$t = (int) $t;
		$req = $db->prepare('SELECT PSEUDO, TITRE_MSG, DATE_MSG, TXT_MSG, ID_SERIE FROM messages WHERE ID_MSG = :t AND ID_FORUM = :f');
		$req->bindValue(':t', $t);
		$req->bindValue(':f', $f);
		$req->execute();


		if ($rep = $req->fetch(PDO::FETCH_NUM))
		{
			//Une sorte de traçage à été mis en place pour permettre à l'utilisateur de se retrouver lors de sa navigation sur le forum
			switch ($f) //On regarde ce que vaut $f (qui est l'indice du forum en question) et on affiche le traçage en conséquence 
			{
				case 1:
					echo'<div class="subject-link">
						<a href="../forum.php" id="tracage">Accueil du forum</a> > <a href="viewforum.php?f=1" id="tracage">Présentation du forum</a> > <span class="current">'.$rep[1].'</span>
					</div>';
					break;
				
				case 2://petit cas particulier pour les séries, qui possèdent une vue supplémentaire au 
				//sein du forum, donc on va chercher l'id de la série pour afficher son nom dans le traçage
					$titreserie = $db->prepare('SELECT TITRE_SERIE from series WHERE ID_SERIE = :s');
					$titreserie->bindValue(':s', $rep[4]);
					$titreserie->execute();
					if ($titrerep = $titreserie->fetch(PDO::FETCH_NUM))
						echo'<div class="subject-link">
							<a href="../forum.php" id="tracage">Accueil du forum</a> > <a href="viewseries.php?f=2" id="tracage">Séries</a> > 
							<a href="viewforum.php?f=2&s='.$rep[4].'" id="tracage">'.$titrerep[0].'</a> > <span class="current">'.$rep[1].'</span>
						</div>';
					break;
				
				case 3:
					echo'<div class="subject-link">
						<a href="../forum.php" id="tracage">Accueil du forum</a> > <a href="viewforum.php?f=3" id="tracage">La pluie et le beau temps</a> > <span class="current">'.$rep[1].'</span>
					</div>';
					break;
				
				case 4:
					echo'<div class="subject-link">
						<a href="../forum.php" id="tracage">Accueil du forum</a> > <a href="viewforum.php?f=4" id="tracage">Suggestions et remarques</a> > <span class="current">'.$rep[1].'</span>
					</div>';
					break;
				
				case 0:
					break;
			}
			//on affiche le message du topic
			$titre = $rep[1];
			echo '<p id="topic_title">'.$titre.'</p>';
			echo
			'<div class="forum_post">
				<div id="forum_post_header">
					<table>
						<tr>
							<td id="avatar_user">
								<img src="'.load_user_avatar($db, $rep[0]).'"/>
							</td>
							<td id="pseudo_user">
								<p>'.$rep[0].'</p>
								<p id="nb_post">Messages: '.affiche_nb_messages_utilisateur($db, $rep[0]).'</p>
								<p id="date-insc">Enregistré(e) : '.affiche_date_insc($db, $rep[0]).'</p>
							</td>
						</tr>
					</table>
				</div>
				<div id="post">
					<p>'.$rep[3].'</p>
				</div>
				<div id="date">
					<p>'.formater_date($rep[2]).'</p>
				</div>
			</div>';		
			//On affiche ensuite toutes les réponses de ce message
			$req = $db->prepare('SELECT PSEUDO, DATE_RPS, TXT_RPS FROM reponses WHERE ID_MSG = :t order by ID_RPS asc');
			$req->bindValue(':t', $t);
			$req->execute();
			while ($rep = $req->fetch(PDO::FETCH_NUM))
			{					
				echo
				'<div class="forum_post">
					<div id="forum_post_header">
						<table>
							<tr>
								<td id="avatar_user">
									<img src="'.load_user_avatar($db, $rep[0]).'"/>
								</td>
								<td id="pseudo_user">
									<p>'.$rep[0].'</p>
									<p id="nb_post">Messages: '.affiche_nb_messages_utilisateur($db, $rep[0]).'</p>
									<p id="date-insc">Enregistré(e) : '.affiche_date_insc($db, $rep[0]).'</p>
								</td>
							</tr>
						</table>
					</div>
					<div id="post">
						<p>'.$rep[2].'</p>
					</div>
					<div id="date">
						<p>'.formater_date($rep[1]).'</p>
					</div>
				</div>';
			}
			echo '<div id="load"></div>';
			
			//Si l'utilisateur est connceté, il aura la possibilité de poster une réponse, sinon le formulaire lui est invisible
			if(isset($_SESSION['connected']))
			{
				echo 
				'<div class="forum_post" id="form-rep">
					<div id="forum_post_header">
						<table>
							<tr>
								<td id="avatar_user">
									<img src="'.load_user_avatar($db, $_SESSION['pseudo']).'"/>
								</td>
								<td id="reply">
									<p>Poster une réponse</p>
								</td>
							</tr>
						</table>
					</div>
					<div id="post">
						<form method="post">
								<textarea id="reponse" name="reply" placeholder="Poster un message..." size="1024" maxlength="1024"></textarea>
								<input type="hidden" name="t" value="'.$t.'">
								<input type="hidden" name="f" value="'.$f.'">
								<button type="submit" id="post_msg" class="submit_message">ENVOYER</button> 
						</form>
					</div>
				</div>';
			}
			echo '</div>';
		}

		else
		{
			header("Location: ../erreurs/404.php");
		}
	}
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
<script>
$(document).ready(function()
{	//Ici, on gère l'affichage automatique des messages quand l'utilisateur a posté son message
	
	//On a besoin de récupérer les paramètres de l'url pour pouvoir poster la reponse dans la base
	t ="<?php Print($_GET['t']); ?>";
	f ="<?php Print($_GET['f']); ?>";
	$('#post_msg').on('click', function()
	{
		$.get('repondre.php',{reply: $('#reponse').val(), t: t, f: f},
		function(rep)
		{
			if(rep)
			{
				console.log(rep);
				//on affiche le message juste avant le formulaire(car l'utilisateur est connecté quand il poste son message.)
				$(".forum_post").eq(-1).before(rep);
			}
			else
				console.log("nope");
		});
			//on se met au niveau de la réponse qui a été postée
			window.location.hash = '#reponse';
	});	
});
</script>
<?php require("../utiles/footer.php"); ?>
<?php require("../utiles/header_end.php"); ?>
