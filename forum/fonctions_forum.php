<?php

function affiche_nb_sujets_forum($db, $id)
{
	$req = $db->prepare('SELECT COUNT(*) FROM messages WHERE ID_FORUM = :id');
	$req->bindValue(':id', $id);
	$req->execute();
	if($rep = $req->fetch(PDO::FETCH_NUM))
		echo $rep[0];
	else
		echo '0';
}

function affiche_nb_sujets_serie($db, $serie)
{
	$req = $db->prepare('SELECT COUNT(*) FROM messages WHERE ID_SERIE = :serie');
	$req->bindValue(':serie', $serie);
	$req->execute();
	if($rep = $req->fetch(PDO::FETCH_NUM))
		return $rep[0];
	else
		return '0';
}

//Dans cette fnction on compte le nombre de message et de 
//reponses d'un forum, puis on les additionne et on retourne cette somme
function affiche_nb_messages_forum($db, $id)
{
	$req = $db->prepare('SELECT COUNT(*) FROM messages WHERE ID_FORUM = :id');
	$req->bindValue(':id', $id);
	$req->execute();
	if($rep = $req->fetch(PDO::FETCH_NUM))
		$sum = $rep[0];
	else
		$sum = 0;
	
	$req = $db->prepare('SELECT COUNT(*) FROM reponses WHERE ID_FORUM = :id');
	$req->bindValue(':id', $id);
	$req->execute();
	if($rep = $req->fetch(PDO::FETCH_NUM))
		$sum += $rep[0];
	else
		$sum = 0;
	echo $sum;
}

//Dans cette fnction on compte le nombre de message et de 
//reponses d'un utilisateur, puis on les additionne et on retourne cette somme
function affiche_nb_messages_utilisateur($db, $pseudo)
{
	$req = $db->prepare('SELECT COUNT(*) FROM messages WHERE PSEUDO = :pseudo');
	$req->bindValue(':pseudo', $pseudo);
	$req->execute();
	if($rep = $req->fetch(PDO::FETCH_NUM))
		$sum = $rep[0];
	else
		$sum = 0;
	
	$req = $db->prepare('SELECT COUNT(*) FROM reponses WHERE PSEUDO = :pseudo');
	$req->bindValue(':pseudo', $pseudo);
	$req->execute();
	if($rep = $req->fetch(PDO::FETCH_NUM))
		$sum += $rep[0];
	else
		$sum = 0;
	return $sum;
}

function affiche_date_insc($db, $pseudo)
{
	$req = $db->prepare('SELECT DATE_INSC FROM utilisateurs WHERE PSEUDO = :pseudo');
	$req->bindValue(':pseudo', $pseudo);
	$req->execute();
	if($rep = $req->fetch(PDO::FETCH_NUM))
		return formater_date($rep[0]);
	else
		return '0';
}

//fonction servant à afficher les infos concernant le dernier message de chaque forum
function affiche_dernier_message_forum($db, $id)
{
	$datelastrep = 0;
	$datelastmsg = 0;
	$msg = 0;
	
	//on selectionne ET les messages ET les reponses pour pouvoir afficher le dernier message
	$lastmsg = $db->prepare('SELECT PSEUDO, DATE_MSG FROM messages WHERE ID_FORUM = :id order by ID_MSG DESC');
	$lastmsg->bindValue(':id', $id);
	
	$lastrep = $db->prepare('SELECT PSEUDO, DATE_RPS FROM reponses WHERE ID_FORUM = :id order by ID_RPS DESC');
	$lastrep->bindValue(':id', $id);
	
	$lastmsg->execute();
	if($rlastmsg = $lastmsg->fetch(PDO::FETCH_NUM))
	{
		//Ici, on convertit le string de la date de la requete en date 
		//à proprement parler pour pouvoir faire des opérations dessus
		$datelastmsg = strtotime($rlastmsg[1]);
		$msg = 1;
	}
	else 
	{
		//S'il n'y a pas de message, il n'y a pas non plus de reponses
		echo 
			'Pas encore de messages postés';
			return;
	}
	
	$lastrep->execute();
	if($rlastrep = $lastrep->fetch(PDO::FETCH_NUM))
	
		//Idem que pour l'autre conversion
		$datelastrep = strtotime($rlastrep[1]);
		
	
	else if($msg == 0)
	{
		//S'il n'y a pas de message, il n'y a pas non plus de reponses
		echo 
			'Pas encore de messages postés';
			return;
	}
	
	//On compare quelle date est la plus grande, donc la plus récente
	if($datelastrep <= $datelastmsg)
		//La date du message est la plus récente
		echo 
			'Par '.$rlastmsg[0].'
				<div class="summary">'.formater_date($rlastmsg[1]).'
				</div>';
	else
		//Ici c'est l'inverse
		echo 
			'Par '.$rlastrep[0].'
				<div class="summary">'.formater_date($rlastrep[1]).'
				</div>';
		
}

//fonction servant à afficher les infos concernant le dernier message de chaque forum des séries
function affiche_dernier_message_serie($db, $id)
{
	$lastmsg = $db->prepare('SELECT PSEUDO, DATE_MSG FROM messages WHERE ID_SERIE = :id order by ID_MSG DESC');
	$lastmsg->bindValue(':id', $id);
	$lastmsg->execute();
	
	if($rlastmsg = $lastmsg->fetch(PDO::FETCH_NUM))
		return array("pseudo" => $rlastmsg[0], "date_msg" => $rlastmsg[1]);
	else
		return 0;
}

function affiche_nb_reponses($db, $id)
{
	$nbrep = $db->prepare('SELECT count(*) from reponses WHERE ID_MSG = :id');
	$nbrep->bindValue(':id', $id);
	$nbrep->execute();
	if($rep = $nbrep->fetch(PDO::FETCH_NUM))
		echo $rep[0];
	else
		echo 0;	
}

//Ici, on charge l'image d'un utilisateur, en comparant le pseudo encrypté 
//de l'utilisateur en question avec l'id de l'avatar qui lui correspond dans la base de donées.
//On vérifie au préalable que l'id de l'avatar ne correspond pas au nom de l'avatar de base encrypté, 
//sinon c'est celui -ci qui est chargé.
function load_user_avatar($db, $pseudo)
{
	$req = $db->prepare('SELECT AVATAR_ID FROM utilisateurs WHERE PSEUDO = :p');
	$req->bindValue(':p', $pseudo);
	$req->execute();
	if($rep = $req->fetch(PDO::FETCH_NUM))
	{
		if($rep[0]==sha1("basic_avatar.png"))
			$str="../avatars/basic_avatar.png";
		else
			$str="../avatars/".sha1($pseudo)."/".sha1($pseudo).".png";
		return $str;
	}
}

function formater_date($date_entree)
{
	$date=$date_entree."";
	//format de $date: 2017-05-08 21:38:18
	$jour=substr($date,8,2);
	$mois=substr($date,5,2);
	$annee=substr($date,0,4);
	$heure=substr($date,11,2);
	$min=substr($date,14,2);
	return "Le ".$jour."/".$mois."/".$annee.", à ".$heure."h".$min;
}
?>
