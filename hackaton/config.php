<?php

define('DB_SERVER', 'localhost');   // Servidor de la base de datos
define('DB_USERNAME', 'alex');     // Nombre de usuario de la base de datos
define('DB_PASSWORD', 'alex'); // Contraseña de la base de datos
define('DB_NAME', 'hackathon');   // Nombre de la base de datos

/* Intentar conectarse a la base de datos MySQL */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verificar la conexión
if($link === false){
    die("Error: No se pudo conectar a la base de datos. " . mysqli_connect_error());
}
?>
