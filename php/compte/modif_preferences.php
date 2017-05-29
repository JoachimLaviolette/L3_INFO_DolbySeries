<?php
	session_start();
	if(isset($_GET['color']) && isset($_GET['typo']))
	{
		$color=htmlentities($_GET['color']);
		$typo=htmlentities($_GET['typo']);
		$_SESSION["theme"]=$color; // Possibilités : Rouge, Bleu, Vert
		$_SESSION["typo"]=$typo; //Possibilités : Trebuchet, Arial, Calibri
	}
	header("Location: ../../index.php");
?>