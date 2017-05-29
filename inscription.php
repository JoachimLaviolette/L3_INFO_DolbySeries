<?php 
require("utiles/header.php");
/////////////////////////////// -- Changement du thème (couleur) -- ///////////////////////////////////
if(isset($_SESSION['theme']))
{
	if($_SESSION['theme']=="Rouge")
		echo "<link href=\"styles/inscription_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
	else if($_SESSION['theme']=="Bleu")
		echo "<link href=\"styles/inscription_css_blue.css\" rel=\"stylesheet\" type=\"text/css\"/>";
	else
		echo "<link href=\"styles/inscription_css_green.css\" rel=\"stylesheet\" type=\"text/css\"/>";
}
else
	echo "<link href=\"styles/inscription_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
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
		<script src="/js/inscription/functions.js"></script>
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
			<div id="sign_up_form">
				<form action="/php/inscription/inscription_script.php" method="post">
					<div id="sign_up_msg">
						<p>Inscris-toi !</p>
					</div>
					<div class="sign_up_mail">
						<p id="alert_mail_wrong" style="display:none;color:#BC0404;font-weight:bold;font-size:13px;text-align:center;">Ce mail est déjà pris !</p>
						<label for="sign_up_mail"><p>Adresse-mail</p></label>
						<input id="mail" type="email" name="sign_up_mail" size="50" maxlength="50" placeholder="mail@exemple.com"><img id="check_mail" src="/medias/check.png" style="position:relative;display:none;width:30px;height:30px;margin:0 0 0 10px;top:10px;"/>
					</div>
					<div class="sign_up_pseudo">
						<p id="alert_pseudo_wrong" style="display:none;color:#BC0404;font-weight:bold;font-size:13px;text-align:center;">Ce pseudo est déjà pris !</p>
						<label for="sign_up_pseudo"><p>Pseudo / Nom d'utilisateur</p></label>
						<input id="pseudo" type="text" name="sign_up_pseudo" size="50" maxlength="15" placeholder="Entrez votre pseudo (15 caractères maximum)"><img id="check_pseudo" src="/medias/check.png" style="position:relative;display:none;width:30px;height:30px;margin:0 0 0 10px;top:10px;"/>
					</div>
					<p id="alert_pwd_wrong" style="display:none;color:#BC0404;font-weight:bold;font-size:13px;text-align:center;">Les deux mots de passe que vous indiquez ne correspondent pas !</p>
					<p id="alert_pwd_right" style="display:none;color:#1eb716;font-weight:bold;font-size:13px;text-align:center;">Les deux mots de passe que vous indiquez correspondent !</p>
					<div class="sign_up_pwd">
						<label for="sign_up_pwd"><p>Mot de passe</p></label>
						<input id="pwd" type="password" name="sign_up_pwd" size="50" maxlength="50" placeholder="Choisissez votre mot de passe">
					</div>
					<div class="sign_up_pwd_confirmed">
						<label for="sign_up_pwd_confirmed"><p>Confirmation du mot de passe</p></label>
						<input id="pwd_cfd" type="password" name="sign_up_pwd_confirmed" size="50" maxlength="50" placeholder="Retapez votre mot de passe">
					</div>
					<div class="sign_up_sex">
						<label for="sign_up_sex"><p>Sexe</p></label>
						<div id="radio_zone">
							<p>H</p>
							<input type="radio" name="sign_up_sex" value="M">
							<p>F</p>
							<input type="radio" name="sign_up_sex" value="F">
						</div>
					</div>	
					<div id="sign_up_login">
						<p><a href="connexion.php">Déjà inscrit ? Connecte-toi !</a></p>
					</div>
					<input name="calling_page" type="hidden" value=<?php echo $_SERVER['HTTP_REFERER'];?>>							
					<button type="submit" id="sign_up_submit_button" disabled>JE M'INSCRIS !</button>
				</form> 
			</div>
		</div>
<?php require("utiles/footer.php"); ?>
<?php require("utiles/header_end.php"); ?>
