<?php include_once 'header.php'; ?>
<?php include_once '../../bd/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root{
    --azul1:#2e86de;
    --azul2:#5dade2;
    --azul3:#154360;
}

/* Base */
body,html{
    height:100%;
    margin:0;
    font-family: 'Segoe UI', sans-serif;
}

/* Contenedor */
.container-login{
    display:flex;
    height:100vh;
}

/* IZQUIERDA */
.left-side{
    flex:1;
    background: linear-gradient(135deg, var(--azul1), var(--azul2));
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    color:white;
    text-align:center;
    padding:20px;
}

.left-side img{
    width:320px;
    margin-bottom:15px;
    border-radius:20px;
    box-shadow:0 15px 30px rgba(0,0,0,0.3);
}

.left-side h1{
    font-size:42px;
    font-weight:800;
    margin-bottom:10px;
}

.left-side p{
    font-size:20px;
    opacity:0.9;
}

/* DERECHA */
.right-side{
    flex:1;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:30px;
    background:white;
}

/* LOGIN */
.login-box{
    width:100%;
    max-width:420px;
}

/* Título */
.login-box h3{
    font-size:32px;
    font-weight:800;
    color:var(--azul3);
    margin-bottom:20px;
}

/* Fecha */
.fecha{
    font-size:16px;
    margin-bottom:10px;
    color:#555;
}

/* Inputs grandes */
.form-control{
    border-radius:14px;
    padding:15px;
    font-size:18px;
}

.input-group-text{
    font-size:18px;
}

/* Botón */
.btn-login{
    background: linear-gradient(135deg, var(--azul1), var(--azul2));
    border:none;
    border-radius:14px;
    padding:15px;
    font-size:18px;
    font-weight:700;
    color:white;
    width:100%;
    transition:0.3s;
}

.btn-login:hover{
    transform: scale(1.03);
    box-shadow:0 12px 25px rgba(46,134,222,0.4);
}

/* Error */
.error{
    color:red;
    font-size:16px;
    font-weight:600;
}

/* Responsive */
@media(max-width:768px){
    .left-side{
        display:none;
    }

    .login-box h3{
        font-size:28px;
    }
}
</style>

</head>

<body>

<div class="container-login">

    <!-- IZQUIERDA -->
    <div class="left-side">
        <img src="../../img/granvia1.png">
        <h1>HOTEL GRAN VIA</h1>
        <p>Sistema de gestión</p>
    </div>

    <!-- DERECHA -->
    <div class="right-side">

        <div class="login-box">

            <div class="fecha">
                <script>
                    var d = new Date();
                    var dayname = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
                    var monthname = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
                    document.write(dayname[d.getDay()] + ", " + d.getDate() + " de " + monthname[d.getMonth()] + " de " + d.getFullYear());
                </script>
            </div>

            <h3>Iniciar sesión</h3>

            <form action="../../handler.php" method="POST">

                <div class="mb-3">
                    <label style="font-size:18px;">Usuario</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                        <input type="text" name="txtUsuario" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label style="font-size:18px;">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        <input type="password" name="txtPassword" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <button class="btn btn-login" name="btnAceptar">
                        <i class="fa fa-sign-in-alt"></i> Ingresar
                    </button>
                </div>

                <div class="mb-2 text-center">
                    <button type="reset" class="btn btn-outline-secondary w-100">Limpiar</button>
                </div>

                <?php if (isset($_GET["error"])): ?>
                    <div class="text-center error">
                        Usuario o contraseña incorrecta
                    </div>
                <?php endif; ?>

                <input type="hidden" name="c" value="login">
                <input type="hidden" name="a" value="Procesar">

            </form>

        </div>

    </div>

</div>

</body>
</html>