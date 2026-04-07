<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="public/css/style.css">
    <script src="public/js/jquery-4.0.0.min.js"></script>
    <script src="public/js/auth.js"></script>
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Iniciar Sesión</h2>

            <form id="formLogin">
                <div class="form-group">
                    <label>Usuario</label>
                    <input class="form-control" name="username" id="username">
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <button type="submit" class="btn btn-primary btn-full">Ingresar</button>
            </form>

            <p class="auth-link"><a href="index.php?page=registro">Registrarse</a></p>
        </div>
    </div>
    <div id="mensaje"></div>
</body>

</html>