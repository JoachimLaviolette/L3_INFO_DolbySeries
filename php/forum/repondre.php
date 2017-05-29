<?php 
	session_start();
	require("../db.php");
	require("fonctions_forum.php");
	try
	{
		//Dans cette page de traitement, on insère les données contenues dans le formulaire dans la base (apres quelques vérifications)
		//et on renvoie la réponse postée pour pouvoir l'afficher en JS dans viewtopic.php
		if($_SESSION['connected']==true)
		{
			if(isset($_GET['reply']) && !empty($_GET['reply']))
			{
				$reply = htmlentities($_GET['reply']);
				$f = htmlentities($_GET['f']);
				$t = htmlentities($_GET['t']);
				$today = date("Y-m-d H:i:s");
				$req = $db->prepare('INSERT INTO reponses(ID_FORUM, PSEUDO, ID_MSG, TXT_RPS, DATE_RPS) VALUES(:f, :p, :t, :reply, :today)');
				$req->bindValue(':f', $f);
				$req->bindValue(':p', $_SESSION['pseudo']);
				$req->bindValue(':t', $t);
				$req->bindValue(':reply', $reply);
				$req->bindValue(':today', $today);
				if($req->execute())
				{
					echo 
					'<div class="forum_post">
						<div id="forum_post_header">
							<table>
								<tr>
									<td id="avatar_user">
										<img src="'.load_user_avatar($db, $_SESSION['pseudo']).'"/>
									</td>
									<td id="pseudo_user">
										<p>'.$_SESSION['pseudo'].'</p>
										<p id="nb_post">Messages: '.affiche_nb_messages_utilisateur($db, $_SESSION['pseudo']).'</p>
										<p id="date-insc">Enregistré(e) le: '.affiche_date_insc($db, $_SESSION['pseudo']).'</p>
									</td>
								</tr>
							</table>
						</div>
						<div id="post">
							<p>'.$reply.'</p>
						</div>
						<div id="date">
							<p>'.$today.'</p>
						</div>
					</div>';
				}
					
				else 
					echo "<div><p>erreur</p></div>";
			}
			else 
					echo "<div><p>erreur</p></div>";
		}
		else 
			echo "<div><p>erreur</p></div>";
	}
	catch (PDOException $e) 
	{
		    echo "\n[EXCEPTION] La connexion a échoué";
		    die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
	}	
?>
