<?php
require("utiles/header.php"); 
/////////////////////////////// -- Changement du thème (couleur) -- ///////////////////////////////////
if(isset($_SESSION['theme']))
{
	if($_SESSION['theme']=="Rouge")
		echo "<link href=\"styles/connexion_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
	else if($_SESSION['theme']=="Bleu")
		echo "<link href=\"styles/connexion_css_blue.css\" rel=\"stylesheet\" type=\"text/css\"/>";
	else
		echo "<link href=\"styles/connexion_css_green.css\" rel=\"stylesheet\" type=\"text/css\"/>";
}
else
	echo "<link href=\"styles/connexion_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
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
		<script src="/js/connexion/functions.js"></script>
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
							if(isset($_SESSION['theme'])=="Rouge")
								echo "<img src=\"/medias/logo_header_3.png\" alt=\"logo_header\"/>";
							else if(isset($_SESSION['theme'])=="Bleu")
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
						<li><a href="index.php">ACCUEIL</a></li>
						<li><a href="series.php">SERIES</a></li>
						<li><a href="forum.php">FORUM</a></li>
						<li><a href="personnalites.php">PERSONNALITES</a></li>
					</ul>
				</div>
				<div id="account">
					<ul>
						<?php 
							if(isset($_SESSION['connected']))
								header("Location: index.php");
							else
								echo '<li id="selected"> SE CONNECTER</li>';
						?>
					</ul>
				</div>
			</div>
			<div id="sep">
				<marquee>DOLBY SERIES EST UN NOUVEAU SITE DEDIE AUX SERIES DU MOMENT !</marquee>
			</div>					
			<div id="main">
				<div id="login_form">
					<form action="/php/connexion/connexion_script.php" method="post">
						<div id="login_msg">
							<p>Connecte-toi !</p>
						</div>
						<div class="login_pseudo">
							<label for="login_pseudo"><p>Pseudo</p></label>
							<p id="alert_pseudo_wrong" style="display:none;color:#BC0404;font-weight:bold;font-size:13px;text-align:center;">Le pseudo renseigné n'existe pas !</p>
							<input id="pseudo" type="text" name="login_pseudo" size="50" maxlength="50" placeholder="Entrez votre pseudo"><img id="check_pseudo" src="/medias/check.png" style="position:relative;display:none;width:30px;height:30px;margin:0 0 0 10px;top:10px;"/>
						</div>
						<div class="login_pwd">
							<label for="login_pwd"><p>Mot de passe</p></label>
							<p id="alert_pwd_wrong" style="display:none;color:#BC0404;font-weight:bold;font-size:13px;text-align:center;">Le mot de passe renseigné ne correspond pas à l'utilisateur indiqué !</p>
							<input id="pwd" type="password" name="login_pwd" size="50" maxlength="50" placeholder="Entrez votre mot de passe"><img id="check_pwd" src="/medias/check.png" style="position:relative;display:none;width:30px;height:30px;margin:0 0 0 10px;top:10px;"/>
						</div>
						<div id="login_sign_up">
							<p><a href="inscription.php">Pas encore inscrit ? Ne perds pas une minute de plus !</a></p>
						</div>		
						<input name="calling_page" type="hidden" value=<?php echo $_SERVER['HTTP_REFERER'];?>>					
						<button type="submit" id="login_submit_button" disabled>JE ME CONNECTE !</button>
					</form> 
				</div>
			</div>
<?php require("utiles/footer.php"); ?>
<?php require("utiles/header_end.php"); ?>
