<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

require_once "config.php";

$username = $lastname = $password = "";
$username_err = $lastname_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor, ingrese un nombre de usuario.";
    } else{
        $sql = "SELECT id FROM usuarios WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = trim($_POST["username"]);
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Este nombre de usuario ya está en uso.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "¡Uy! Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Por favor, ingrese su apellido.";
    } else{
        $lastname = trim($_POST["lastname"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor, ingrese una contraseña.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($lastname_err) && empty($password_err)){
        $sql = "INSERT INTO usuarios (username, lastname, passwordd) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_lastname, $param_password);
            
            $param_username = $username;
            $param_lastname = $lastname;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            
            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
            } else{
                echo "¡Uy! Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrarse</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Registrarse</h2>
        <p>Por favor complete este formulario para crear una cuenta.</p>
        <form action="<?php echo htmlspecialchars($_SERVER
["PHP_SELF"]); ?>" method="post">
<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
<label>Nombre de usuario</label>
<input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
<span class="help-block"><?php echo $username_err; ?></span>
</div>
<div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
<label>Apellido</label>
<input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
<span class="help-block"><?php echo $lastname_err; ?></span>
</div>
<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
<label>Contraseña</label>
<input type="password" name="password" class="form-control">
<span class="help-block"><?php echo $password_err; ?></span>
</div>
<div class="form-group">
<input type="submit" class="btn btn-primary" value="Registrarse">
<input type="reset" class="btn btn-default" value="Limpiar">
</div>
<p>¿Ya tienes una cuenta? <a href="login.php">Iniciar sesión aquí</a>.</p>
</form>
</div>

</body>
</html>