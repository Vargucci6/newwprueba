<!-- 
Autor: Daniel Vargas Martínez
Fecha: 20/08/21 
-->
<!DOCTYPE html>
<html lang="en">
<?php

//Obtener conexión a base de datos

include_once("conection.php");
$conexion = Conexion::conectar();

// Iniciar sesión

session_start();

// Pasos para realizar si submit existe

if (isset($_POST['submit'])) {

    // Declaración de variables de acuerdo a los datos obtenidos por formularios

    $correo = htmlspecialchars($_POST['correo'], ENT_QUOTES);
    $contrasenia = htmlspecialchars($_POST['contrasenia'], ENT_QUOTES);

    // Diferenciar formulario de registro e inicio de sesión

    if (isset($_POST['nombre']) != null) {
        $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES);

        // Secuencia SQL

        $sql = "INSERT INTO usuarios(correo, nombre, contrasenia) VALUES ('$correo','$nombre', '$contrasenia')";

        // Añadir secuencia a la base de datos

        if ($conexion->query($sql)) {
            $sqlRegister = "SELECT * FROM usuarios WHERE correo = '$correo' AND contrasenia = '$contrasenia'";
            $result = mysqli_query($conexion, $sqlRegister);
            $mostrar = mysqli_fetch_array($result);

            if ($mostrar) {
                $_SESSION["nombre"] = $mostrar['nombre'];
                $_SESSION["correo"] = $mostrar['correo'];
                $_SESSION["contrasenia"] = $mostrar['contrasenia'];
            }
        } else {
?>
            <script>
                alert("Correo ya utilizado");
                history.back();
            </script>
        <?php
        }
    } else {
        $sql = "SELECT * FROM usuarios WHERE correo = '$correo' AND contrasenia = '$contrasenia'";
        $result = mysqli_query($conexion, $sql);
        $mostrar = mysqli_fetch_array($result);

        if ($mostrar) {
            $_SESSION["nombre"] = $mostrar['nombre'];
            $_SESSION["correo"] = $mostrar['correo'];
            $_SESSION["contrasenia"] = $mostrar['contrasenia'];
        } else {
        ?>
            <script>
                alert("Correo o contraseña incorrecta");
                history.back();
            </script>
<?php
        }
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba Técnica New W</title>
</head>

<body>
    <div class="fullWidth">
        <div class="container">

            <!-- Datos a mostrar si no hay una sesión iniciada -->

            <?php
            if (isset($_SESSION['nombre']) == null) {
            ?>
                <div class="displayFlex">
                    <button class="button" onclick="btnRegistro()">Registrarse</button>
                    <button class="button" onclick="btnInicio()">Iniciar sesión</button>
                </div>
                <div class="displayFlex">

                    <!-- Formulario de registro -->

                    <div class="form hide" id="formRegistro">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="registro" method="post" onsubmit="verificarContra(); var a = false; return a ">
                            <fieldset>
                                <div id="errorValidacion" class="hide" role="alert">
                                    Las contraseñas no coinciden, vuelve a intentar!
                                </div>
                                <div id="errorCaracteres" class="hide" role="alert">
                                    Las contraseñas deben ser mayor a 8 caracteres
                                </div>
                                <legend>Registro</legend>
                                <div class="displayFlex directionFlex">
                                    <div class="itemForm">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" name="nombre" id="nombre" required>
                                    </div>
                                    <div class="itemForm">
                                        <label for="correo">Correo Electrónico</label>
                                        <input type="email" name="correo" id="correo" required>
                                    </div>
                                    <div class="itemForm">
                                        <label for="contrasenia">Contraseña</label>
                                        <input type="password" name="contrasenia" id="contrasenia" required>
                                    </div>
                                    <div class="itemForm">
                                        <label for="conContrasenia">Confirmar Contraseña</label>
                                        <input type="password" name="conContrasenia" id="conContrasenia" required>
                                    </div>
                                </div>
                                <button class="button" type="submit" name="submit" id="enviar">Enviar</button>
                            </fieldset>
                        </form>
                    </div>

                    <!-- Formulario de inicio de sesión -->

                    <div class="form hide" id="formInicio">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="registro" method="post">
                            <fieldset>
                                <legend>Inicia sesión</legend>
                                <div class="displayFlex directionFlex">
                                    <div class="itemForm">
                                        <label for="correo">Correo Electrónico</label>
                                        <input type="email" name="correo" id="correo" required>
                                    </div>
                                    <div class="itemForm">
                                        <label for="contrasenia">Contraseña</label>
                                        <input type="password" name="contrasenia" id="contrasenia" required>
                                    </div>
                                </div>
                                <button class="button" type="submit" name="submit" id="enviar">Enviar</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            <?php

            // Datos a mostrar si hay una sesión iniciada

            } else {
            ?>                
                <div class="form">

                    <!-- Formulario de actualizar datos -->

                    <form action="actualizar.php" id="registro" method="post" onsubmit="verificarContraActualizada(); var a = false; return a ">
                        <fieldset>
                            <div id="errorValidacion" class="hide" role="alert">
                                Las contraseñas no coinciden, vuelve a intentar!
                            </div>
                            <div id="errorCaracteres" class="hide" role="alert">
                                Las contraseñas deben ser mayor a 8 caracteres
                            </div>
                            <legend>Actualiza tus datos</legend>
                            <div class="displayFlex directionFlex">
                                <div class="itemForm">
                                    <label for="correo">Correo Electrónico</label>
                                    <input type="email" name="correo" id="correo" required disabled>
                                </div>
                                <div class="itemForm">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" name="nombre" id="nombre" required>
                                </div>
                                <div class="itemForm">
                                    <label for="contrasenia">Nueva contraseña</label>
                                    <input type="password" name="contrasenia" id="contrasenia">
                                </div>
                                <div class="itemForm">
                                    <label for="conContrasenia">Confirmar contraseña</label>
                                    <input type="password" name="conContrasenia" id="conContrasenia">
                                </div>
                            </div>
                            <button class="button" type="submit" name="submit" id="enviar">Enviar</button>
                            <script>
                                document.getElementById("correo").value = "<?php echo $_SESSION['correo'] ?>";
                                document.getElementById("nombre").value = "<?php echo $_SESSION['nombre'] ?>";
                            </script>
                        </fieldset>
                    </form>
                    <button class="button" onclick="location.href = 'logout.php'">Cerrar sesión</button>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

<!-- Scripts utilizados para validaciones -->

<script>

    // Verificar que la contraseña cumpla requisitos

    function verificarContra() {
        contra = document.getElementById("contrasenia").value;
        conContra = document.getElementById("conContrasenia").value;
        if (contra.length < 8) {
            document.getElementById('errorCaracteres').className = "show";
            a = false;
        } else {
            if (contra != conContra) {
                document.getElementById('errorValidacion').className = "show";
                a = false;
            } else {
                document.getElementById('errorValidacion').className = "hide";
                document.getElementById('registro').submit();
            }
        }
    }

    // Verficar si la contraseña actualizada tienen los requisitos

    function verificarContraActualizada() {
        contra = document.getElementById("contrasenia").value;
        conContra = document.getElementById("conContrasenia").value;
        if (contra.length < 8) {
            if (contra.length == 0) {
                document.getElementById('registro').submit();
            } else {
                document.getElementById('errorCaracteres').className = "show";
                a = false;
            }
        } else {
            if (contra != conContra) {
                document.getElementById('errorValidacion').className = "show";
                a = false;
            } else {
                document.getElementById('errorValidacion').className = "hide";
                document.getElementById('registro').submit();
            }
        }
    }

    // Mostrar formulario de registro

    function btnRegistro() {
        var clase = document.getElementById('formRegistro');
        var claseTwo = document.getElementById('formInicio');
        if (clase.className == "form hide") {
            if (claseTwo.className = "form show") {
                clase.className = "form show";
                claseTwo.className = "form hide"
            } else {
                clase.className = "form show";
            }
        } else {
            clase.className = "form hide";
        }
    }

    //Mostrar formulario de registro

    function btnInicio() {
        var clase = document.getElementById('formInicio');
        var claseTwo = document.getElementById('formRegistro');
        if (clase.className == "form hide") {
            if (claseTwo.className == "form show") {
                clase.className = "form show";
                claseTwo.className = "form hide";
            } else {
                clase.className = "form show";
            }
        } else {
            clase.className = "form hide";
        }
    }
</script>

</html>