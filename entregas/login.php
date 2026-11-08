<?php
include_once "encabezado.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f0f0;
        }

        .container {
            margin-top: 5%;
        }

        .shadow-lg {
            border-radius: 15px;
        }

        .col-md-6 img {
            object-fit: cover;
            height: 100%;
            border-radius: 15px 0 0 15px;
        }

        .bg-white {
            border-radius: 0 15px 15px 0;
        }

        h3 {
            font-size: 2rem;
            color: #343a40;
        }

        .form-control {
            height: 50px;
            font-size: 1rem;
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 15px;
            font-size: 1rem;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .row.m-5 {
                margin: 0;
                box-shadow: none;
            }

            .col-md-6 {
                border-radius: 15px;
            }

            .col-md-6 img {
                border-radius: 15px 15px 0 0;
            }

            .bg-white {
                border-radius: 0 0 15px 15px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row m-5 no-gutters shadow-lg">
        <!-- Imagen para pantallas medianas y grandes -->
        <div class="col-md-6 d-none d-md-block">
            <img src="img/granvia.png" class="img-fluid" alt="Fiestas">
        </div>

        <!-- Formulario -->
        <div class="col-md-6 bg-white p-5">
            <h3 class="pb-3 text-center">Iniciar sesión</h3>
            <form action="iniciar_sesion.php" method="post">
                <div class="form-group pb-3">
                    <input type="text" placeholder="Usuario" class="form-control" name="usuario" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                </div>
                <div class="form-group pb-3">
                    <input type="password" placeholder="Contraseña" class="form-control" name="password" id="exampleInputPassword1" required>
                </div>
                <div class="pb-2">
                    <button type="submit" name="ingresar" class="btn btn-primary w-100 font-weight-bold mt-2">Ingresar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
