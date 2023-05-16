<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style>
        body {
            font: 14px sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .wrapper {
            width: 350px;
            padding: 20px;
            background-color: #f7f7f7;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        
        .wrapper h2 {
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .wrapper p {
            text-align: center;
        }
        
        .wrapper a {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Bienvenido, <?php echo $_SESSION["username"]; ?></h2>
        <p>Has iniciado sesión correctamente ^.^</p>
        <p><a href="logout.php">Cerrar sesión</a></p>
    </div>    
</body>
</html>
