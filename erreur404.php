<?php 
if (preg_match('^/SLAM5/PPE/([a-zA-Z0-9_-]+)^', $_SERVER['REDIRECT_URL'], $match)) { 
  //modification du code retour 
  header("Status: 200 OK", false, 200); 
  //alimentation du paramètre GET 
  $_GET['param'] = $match[1]; 
  $_REQUEST['param'] = $match[1]; 
  // header('location: index.php?uc=validationFrais&action=selectionVisiteur');
  include('index.php?uc=validationFrais&action=selectionVisiteur'); 
} 
?> 