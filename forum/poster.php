<?php
	require("../utiles/header.php"); 
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
	require("../db.php");
	require("fonctions_forum.php");?>
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
		if(isset($_POST['post']) && !empty($_POST['post']))
		{
			$post = htmlentities($_POST['post']);
			$f = htmlentities($_POST['f']);
			$t = htmlentities($_POST['t']);
			$today = date("Y-m-d H:i:s");
			if(isset($_POST['s']))
			{
				$s = htmlentities($_POST['s']);
				$req = $db->prepare('INSERT INTO messages(ID_FORUM, PSEUDO, ID_SERIE, TITRE_MSG, TXT_MSG, DATE_MSG) VALUES(:f, :p, :s, :t, :post, :today)');
				$req->bindValue(':s', $s);
			}
			else
			{
				$s = 'NULL';
				$req = $db->prepare('INSERT INTO messages(ID_FORUM, PSEUDO, TITRE_MSG, TXT_MSG, DATE_MSG) VALUES(:f, :p, :t, :post, :today)');
			}
			$req->bindValue(':f', $f);
			$req->bindValue(':p', $_SESSION['pseudo']);
			$req->bindValue(':t', $t);
			$req->bindValue(':post', $post);
			$req->bindValue(':today', $today);
			if($req->execute())
			{
				$redirect = $db->prepare('SELECT ID_MSG from messages WHERE DATE_MSG = :today AND ID_FORUM = :f');
				$redirect->bindValue(':today', $today);
				$redirect->bindValue(':f', $f);
				$redirect->execute();
				if($rep = $redirect->fetch(PDO::FETCH_NUM))
					echo "<div class=\"post_message\"><p>Votre message a bien été posté !<div class='subject-link'><a href=viewtopic.php?f=".$f."&t=".$rep[0]."><button class=\"back_to_post\">Voir le post</button></a></div></p></div>";
				else 
					header("Location: ../erreurs/500.php");
			}
			else 
				header("Location: ../erreurs/500.php");
		}
	}
	else
		header("Location: ../erreurs/401.php");
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
