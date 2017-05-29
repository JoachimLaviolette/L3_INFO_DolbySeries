<?php 
require("utiles/header.php"); 
/////////////////////////////// -- Changement du thème (couleur) -- ///////////////////////////////////
if(isset($_SESSION['theme']))
{
	if($_SESSION['theme']=="Rouge")
		echo "<link href=\"styles/compte_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
	else if($_SESSION['theme']=="Bleu")
		echo "<link href=\"styles/compte_css_blue.css\" rel=\"stylesheet\" type=\"text/css\"/>";
	else
		echo "<link href=\"styles/compte_css_green.css\" rel=\"stylesheet\" type=\"text/css\"/>";
}
else
	echo "<link href=\"styles/compte_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
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
		<script src="/js/compte/functions.js"></script>
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
									echo '<li id="selected">> MON COMPTE</li>';
								else
									header("Location: erreurs/401.php");
							?>
					</ul>
				</div>
			</div>
			<div id="sep">
				<marquee>DOLBY SERIES EST UN NOUVEAU SITE DEDIE AUX SERIES DU MOMENT !</marquee>
			</div>					
			<div id="main">
				<div id="account_title">
					<p style="margin: 2% 0 0% 0;"">Page profil</p>
					<p style="font-size: 25px;margin: 1% 0 4% 0;">Bienvenue <?php echo $_SESSION['pseudo']; ?> !</p>
				</div>
				<div id="account_desc"><p>Depuis votre page personnelle, vous pouvez modifier les informations concernant votre profil ou choisir de vous déconnecter du site.</p></div>
				<div id="account_action">
					<button onclick="open_popup_infos_compte()">Modifier ses informations</button>
					<button onclick="open_popup_preferences()">Choisir ses préférences</button>
					<button><a href="/php/connexion/deconnexion_script.php">Se déconnecter du site</a></button>
				</div>
				<div id="popup_infos_compte_bg">
				</div>
				<div id="popup_preferences_bg">
				</div>
				<div id="popup_preferences">
					<div id="preferences_form">
						<div id="close_popup"><img onclick="close_popup_preferences()" src="../medias/croix_popup.jpg"/></div>
						<form action="/php/compte/modif_preferences.php" method="get" enctype="multipart/form-data">
							<div id="pref_title">
								<p>Changer ses préférences</p>
							</div>
							<div class="pref_color">
								<label for="pref_color"><p>Couleur / Thème</p></label>		
								<select id="select_color" name="color">
									<option value="Rouge">Rouge ardent</option>
									<option value="Bleu">Bleu nuit</option>
									<option value="Vert">Vert floral</option>
								</select>
								<span id="ex_color" style="background-color:#BC0404;color:#fff;padding-left: 2%;">Exemple en couleur...</span>
							</div>
							<div class="pref_typo">
								<label for="pref_typo"><p>Police de caractères</p></label>
								<select id="select_typo" name="typo">
									<option value="Trebuchet">Trebuchet MS</option>
									<option value="Arial">Arial</option>
									<option value="Calibri">Calibri</option>
								</select>				
								<span id="ex_typo" style="padding-left: 2%;">Exemple en texte...</span>				
							</div>
							<button type="submit" id="pref_submit_button">Valider les modifications</button>
						</form>
					</div>
				</div>
				<div id="popup_infos_compte">
					<div id="infos_compte_form">
						<div id="close_popup"><img onclick="close_popup_infos_compte()" src="../medias/croix_popup.jpg"/></div>
						<form action="/php/compte/modif_infos_perso_script.php" method="post" enctype="multipart/form-data">
							<div id="infos_compte_title">
								<p>Modifier ses informations</p>
							</div>
							<div class="infos_compte_avatar">
								<label for="infos_compte_avatar"><p>Avatar</p></label>
								<input type="file" name="infos_compte_avatar" id="infos_compte_avatar" accept=".jpg, .jpeg, .png, .bmp">								
							</div>
							<div class="infos_compte_pwd">
								<input id="user_u" type="hidden" value=<?php echo ("\"".$_SESSION['pseudo']."\"");?>>
								<label for="infos_compte_pwd"><p>Mot de passe</p></label>
								<p id="alert_pwd" style="display:none;color:#BC0404;font-weight:bold;font-size:13px;text-align:center;">Le mot de passe que vous indiquez ne correspond pas à votre mot de passe actuel</p>
								<input type="password" id="pwd" name="infos_compte_old_pwd" size="45" maxlength="50" placeholder="Entrez votre mot de passe actuel"><img id="check" src="/medias/check.png" style="position:relative;display:none;width:30px;height:30px;margin:0 0 0 10px;top:10px;"/>
								<p id="alert_new_pwd_wrong" style="display:none;color:#BC0404;font-weight:bold;font-size:13px;text-align:center;">Les deux nouveaux mots de passe que vous indiquez ne correspondent pas !</p>
								<p id="alert_new_pwd_right" style="display:none;color:#1eb716;font-weight:bold;font-size:13px;text-align:center;">Les deux nouveaux mots de passe que vous indiquez correspondent !</p>
								<input type="password" id="new_pwd" name="infos_compte_new_pwd" size="45" maxlength="50" placeholder="Entrez votre nouveau mot de passe">
								<input type="password" id="new_pwd_cfd" name="infos_compte_new_pwd_confirmed" size="45" maxlength="50" placeholder="Retapez votre nouveau mot de passe">
							</div>
							<div class="infos_compte_mail">
								<label for="infos_compte_mail"><p>Adresse-mail</p></label>
								<input type="email" name="infos_compte_old_mail" size="45" maxlength="50" placeholder=<?php echo ("\"".$_SESSION['adr_mail']."\"");?> disabled>
								<p id="alert_mail_wrong" style="display:none;color:#BC0404;font-weight:bold;font-size:13px;text-align:center;">Ce mail est déjà pris !</p>
								<input id="mail" type="email" name="infos_compte_new_mail" size="45" maxlength="50" placeholder="Entrez votre nouvelle adresse-mail"><img id="check_mail" src="/medias/check.png" style="position:relative;display:none;width:30px;height:30px;margin:0 0 0 10px;top:10px;"/>
							</div>
							<div class="infos_compte_sexe">
								<label for="infos_compte_sexe"><p>Sexe</p></label>
								<div id="radio_zone">
									<p>H</p>
									<input id="sexe1" type="radio" name="infos_compte_sexe" value="M" <?php if($_SESSION['sexe']=='M') echo 'checked="checked"'?>>
									<p>F</p>
									<input id="sexe2" type="radio" name="infos_compte_sexe" value="F" <?php if($_SESSION['sexe']=='F') echo 'checked="checked"'?>>
								</div>
							</div>
							<div class="infos_compte_anniv">
								<label for="infos_compte_anniv"><p>Date d'anniversaire</p></label>
								<input id="anniv" type="date" name="infos_compte_anniv" size="45">
							</div>						
							<button type="submit" id="infos_compte_submit_button">Valider les modifications</button>
						</form>
					</div>
				</div>
			</div>
<?php require("utiles/footer.php"); ?>
<?php require("utiles/header_end.php"); ?>
