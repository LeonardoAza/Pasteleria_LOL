<?php
session_start();
session_destroy(); // Borra los datos 
header("Location: login.php"); // Lo manda alv a login
exit();
?>