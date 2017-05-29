<?php
    try
    {
        $db=new PDO('mysql:host=localhost;dbname=joadev','JoaDev','dev1996');
        $db->query("SET NAMES 'utf8'");
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
		echo "\n[EXCEPTION] La connexion a échoué";
    	die("<p>Erreur[" . $e->getCode() . "] :" . $e->getMessage(). "</p>");
    }
?>
