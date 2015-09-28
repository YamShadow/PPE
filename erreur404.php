<?php 
if (ereg('^/page-([0-9]+).html$', $_SERVER['REDIRECT_URL'], $match)) { 
  //modification du code retour 
  header("Status: 200 OK", false, 200); 
  //alimentation du paramètre GET 
  $_GET['param'] = $match[1]; 
  $_REQUEST['param'] = $match[1]; 
  include('page.php'); 
} 
?> 