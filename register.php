<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro de Usuario</title>
</head>
<body>
    <!-- pasa por post el reg-act.php el registro del usuario -->
    <form action="modules/reg-act.php" method="post"> 
            <label for="name">Nombre de usuario: </label>
            <p><input type="text" id="name" name=name required></p>
            <label for="email">Email: </label>
            <p><input type="email" name="email" id="email" required></p>
            <label for="password">Contraseña</label>
            <p><input type="password" name="password" id="password" required></p>
            <input type="submit" value="Registrar">
            <input type="reset" value="Borrar datos">
    </form>
</body>
</html>