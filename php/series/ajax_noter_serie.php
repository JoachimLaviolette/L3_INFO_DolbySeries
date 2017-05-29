<?php 
	session_start();
	$note=htmlentities($_POST['note']);
	$review=htmlentities($_POST['review']);
	$pseudo=$_SESSION['pseudo'];
	$series_id=htmlentities($_POST['id']);
	$avatar_url="";
	require("../../db.php");
	try
	{
		if(isset($_POST['id']) && isset($_POST['note']) && isset($_POST['review']))
		{
			//on vériie que l'utilisateur n'a pas déjà saisi de note/critique pour cette série
			$sql="select count(note_ns) as sum from noter_series where pseudo=:pseudo";
			$req=$db->prepare($sql);
			$req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
			$req->execute();
			$res=$req->fetch(PDO::FETCH_ASSOC);
			if($res['sum']==0)
			{
				echo "<p>Vous avez déjà saisi une note</p>";
			}
			//insertions dans la bdd
			$date=date('Y-m-d H:i:s');
			$sql="insert into noter_series values(:pseudo,:id,:note,:review,:date)";
			$req=$db->prepare($sql);
			$req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
			$req->bindValue(':id', $series_id, PDO::PARAM_INT);
			$req->bindValue(':note', $note, PDO::PARAM_INT);
			$req->bindValue(':review', $review, PDO::PARAM_STR);
			$req->bindValue(':date', $date);
			$req->execute();
			//récupération de de l'avatar de l'utilisateur pour afficher correctement la review dans la page
			$sql="select avatar_id from utilisateurs where pseudo=:pseudo";
			$req=$db->prepare($sql);
			$req->bindValue(':pseudo', $pseudo, PDO::PARAM_INT);
			$req->execute();
			$res=$req->fetch(PDO::FETCH_ASSOC);
			if(isset($res) && !empty($res))
			{
				if($res['avatar_id']==sha1("basic_avatar.png"))
					$avatar_url="../../avatars/basic_avatar.png";
				else
					$avatar_url="../../avatars/".sha1($pseudo)."/".sha1($pseudo).".png";
			}
			//on prépare le renvoi de html	
			echo "<div class=\"review\">
					<div id=\"review_header\">
						<table>
							<tr>
								<td id=\"avatar_user\">
									<img src=\"".$avatar_url."\"/></p>
								</td>
								<td id=\"pseudo_user\">
									<p>".$pseudo."</p>
								</td>
								<td id=\"note_user\">
									<p>".$note."/10</p>
								</td>
							</tr>
						</table>
					</div>
					<div id=\"review_commentary\">
						<p>".$review."</p>
					</div>
					<div id=\"review_date\">
						<p>".$date."</p>
					</div>
				</div>";
			}
	}
	catch (PDOException $e) 
	{
	    echo "\n[EXCEPTION] La connexion a échoué";
	    die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
	}	
?>