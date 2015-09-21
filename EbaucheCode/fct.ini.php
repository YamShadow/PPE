<?php
//connexion
require 'config.ini.php';
function connexion()
{
try
{
$con= new PDO ('mysql:host='.HOTE.';dbname='.BASE,UTILISATEUR,MDP, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
return $con;
}
catch(PDOException $e)
{
	echo "Probleme de connexion".$e->getMessage();
	return false;
}
}
?>