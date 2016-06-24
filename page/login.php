<?php
/**
 * Forma completa
 * Created by Joe of ExchangeCore.com
 */
 
$msg = "";

if(isset($_POST['username']) && isset($_POST['password'])) {
    $msg = Usuario::valida($_POST['username'], $_POST['password']);
    if ($msg == "") {
        Utils::gobackok('');
    }
}