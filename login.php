<?php
    include_once "database.php";
    session_start();


    if(isset($_GET['cerrar_sesion'])){
        session_unset();

        session_destroy();
    }

    if(isset($_SESSION['rol'])){
        switch($_SESSION['rol']){
            case 1:
                header('location: admin.php');
                break;

            case 2:
                header('location: colab.php');
                break;

            default:
        }
    }

    if(isset($_POST['username']) && isset($_POST['password'])){

        $username = $_POST['username'];
        $password = $_POST['password'];

        $db = new Database();
        
        
        $query = $db->connect()->prepare('SELECT*FROM usuarios WHERE username = :username AND password =:password');
        
        
        
        $query->execute(['username'=>$username, 'password'=>$password]);
        
        $row = $query->fetch(PDO::FETCH_NUM);
        if($row==true){
            // validar el rol
            $rol = $row[3];
            $_SESSION['rol'] = $rol;

            switch($_SESSION['rol']){
                case 1:
                    header('location: admin.php');
                    break;
    
                case 2:
                    header('location: colab.php');
                    break;
    
                default:
            }




        }else{
            //no existe el usuario
            echo "El usuario o contraseña son incorrectos";
        }
    }





?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">

            <div class="login-container">
                <div class="fadeIn first">
                    <img src="img/Senamecf.jpg" id="icon" alt="User Icon">
                    <h1 class="text-center mb-4">Iniciar sesión</h1>
                </div>

                <form action="#" method="POST">
                    <div class="mb-3">
                        <label for="username" class="fadeIn second-label">Usuario</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="fadeIn Third">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                </form>


            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
