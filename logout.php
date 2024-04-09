<?php
 
//iniciar a seção antes de destruir
session_start();
session_unset();
session_destroy();

header('Location: login_pabx2.php');

?>