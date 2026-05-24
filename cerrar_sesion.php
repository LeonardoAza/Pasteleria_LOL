<?php
session_start();
session_destroy(); // Borra los datos de la sesión
header("Location: login.php"); // Lo manda al login
exit();
?>