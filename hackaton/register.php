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
                header("location: index.php");
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
        body {
            font: 14px sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .wrapper {
            width: 350px;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #e2e2e2;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        
        .wrapper h2 {
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .wrapper
        p {
margin-bottom: 20px;
}
.form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 5px;
    }
    
    .form-control {
        width: 100%;
        padding: 8px;
        font-size: 14px;
        border: 1px solid #e2e2e2;
        border-radius: 4px;
    }
    
    .help-block {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
    }
    
    .btn-primary {
        width: 100%;
    }
    
    .btn-default {
        width: 100%;
    }
    
    .form-footer {
        margin-top: 20px;
        text-align: center;
    }
    
    .form-footer p {
        margin-bottom: 0;
    }
    
    .form-footer a {
        color: #007bff;
        text-decoration: none;
    }
</style>
</head>
<body>
    <div class="wrapper">
        <h2>Registrarse</h2>
        <p>Por favor complete este formulario para crear una cuenta.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
            </div>
            <div class="form-footer">
                <p>¿Ya tienes una cuenta? <a href="index.php">Iniciar sesión aquí</a>.</p>
            </div>
        </form>
    </div>
</body>
</html>