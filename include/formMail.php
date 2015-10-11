<?php

function EnvoieMail(){
//if (!$_POST['subject'] ) {
//       $errSubject = 'Entrez un objet';
//        $valid= False;
//        }
//if (!$_POST['subject'] ) {
//        $errSubject = 'Entrez un objet';
//	$valid= False;
//        }

$to = 'kouishadow@gmail.com';
$subject = "Frais en remboursement";
$body = "Vos frais du  pour un montant de vient d'etre remboursé<br/></br>";
$from = "Mail automatique du service Comptabilité";
mail($to, $subject, $body, $from);
}