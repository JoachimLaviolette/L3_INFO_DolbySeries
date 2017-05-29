<?php 
	require("../utiles/header.php"); 
	if(isset($_SESSION['theme']))
	{
		if($_SESSION['theme']=="Rouge")
			echo "<link href=\"/styles/erreurs/erreurs_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
		else if($_SESSION['theme']=="Bleu")
			echo "<link href=\"/styles/erreurs/erreurs_css_blue.css\" rel=\"stylesheet\" type=\"text/css\"/>";
		else
			echo "<link href=\"/styles/erreurs/erreurs_css_green.css\" rel=\"stylesheet\" type=\"text/css\"/>";
	}
	else
		echo "<link href=\"/styles/erreurs/erreurs_css.css\" rel=\"stylesheet\" type=\"text/css\"/>";
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
						<li><a href="../forum.php">FORUM</a></li>
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
				<div id="error_content">
					<img src="../medias/logo_403.png"/>
					<p>Accès refusé !</p>
				</div>
			</div>
<?php require("../utiles/footer.php"); ?>
<?php require("../utiles/header_end.php"); ?>
