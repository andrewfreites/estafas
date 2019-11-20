<?php
session_start();
header("Cache-control:private"); 
if($_SESSION['loggedin']=="") 
{ 
 header("Location: index.html"); 
 exit; 
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Crear Denuncia</title>
</head>
<body class="wrapper">
    <header>
        <!-- navigation menu -->
        <nav> 
            <ul>
                <a href="admin.php"><li>Menú</li></a>
                <a href="modules/logout.php"><li>Salir</li></a>
            <ul>
        </nav>
        <!-- end navigation menu -->
    </header>
    <main role="main">
        <h1>Crear denuncia</h1>
        <!-- complaint form -->
        <form action="modules/reg-denun.php" method="POST">
            <h2>Datos de la víctima:</h2>
            <label for="cedula_victima">Cédula de identidad: </label> <!-- every label allows point to every input -->
            <input type="text" name="cedula_victima" id="cedula_victima" size="20" maxlength="9" placeholder="sin puntos ni separadores" required>
            <label for="nombre_victima">Nombre: </label>
            <input type="text" name="nombre_victima" id="nombre_victima" size="20" required>
            <label for="telefono_victima">Teléfono: </label>
            <input type="tel" name="telefono_victima" id="telefono_victima" size="20" maxlength="11" placeholder="ejemplo: 04141234567">
            <label for="email_victima">Email: </label>
            <input type="email" name="email_victima" id="email_victima" size="20">
            <label for="fecha">Fecha de la denuncia: </label>
            <input type="date" name="fecha" id="fecha" required>
            <br>
            <h2>Datos Bancarios de la víctima: </h2>
            <label for="banco_victima">Entidad Bancaria: </label>
            <select name="banco_victima" id="banco_victima"> <!-- select used for bank selection -->
                <option value="100% Banco">100% Banco</option>
                <option value="Activo">Activo</option>
                <option value="Bancamiga">Bancamiga</option>
                <option value="Bancaribe">Bancaribe</option>
                <option value="Banesco">Banesco</option>
                <option value="Banfanb">Banfanb</option>
                <option value="Banplus">Banplus</option>
                <option value="Bicentenario">Bicentenario</option>
                <option value="BOD">BOD</option>
                <option value="Caroni">Caroni</option>
                <option value="Delsur">Delsur</option>
                <option value="Exterior">Exterior</option>
                <option value="Mercantil">Mercantil</option>
                <option value="Plaza">Plaza</option>
                <option value="Provincial">Provincial</option>
                <option value="Venezolano de Credito">Venezolano de Credito</option>
                <option value="Venezuela">Venezuela</option>
                <option value="No aplica">No aplica</option>
            </select>
            <label for="numero_victima">Número de cuenta: </label>
            <input type="text" name="numero_victima" id="numero_victima" size="20" maxlength="20" placeholder="Ingresar sin separadores">
            <label for="monto-estafado">Monto estafado: </label>
            <input type="number" name="monto_estafado" id="monto_estafado" size="20">
            <br>
            <h2>Datos del sospechoso:</h2>
            <label for="cedula_sospechoso">Cédula de identidad: </label>
            <input type="text" name="cedula_sospechoso" id="cedula_sospechoso" size="20" maxlength="9" placeholder="sin puntos ni separadores">
            <label for="nombre_sospechoso">Nombre: </label>
            <input type="text" name="nombre_sospechoso" id="nombre_sospechoso" size="20">
            <label for="telefono_sospechoso">Teléfono: </label>
            <input type="tel" name="telefono_sospechoso" id="telefono_sospechoso" size="20" maxlength="11" placeholder="ejemplo: 04141234567">
            <label for="email_sospechoso">Email: </label>
            <input type="email" name="email_sospechoso" id="email_sospechoso" size="20">
            <h2>Datos Bancarios del sospechoso: </h2>
            <label for="banco_sospechoso">Entidad Bancaria: </label>
            <select name="banco_sospechoso" id="banco_sospechoso">
                <option value="100% Banco">100% Banco</option>
                <option value="Activo">Activo</option>
                <option value="Bancamiga">Bancamiga</option>
                <option value="Bancaribe">Bancaribe</option>
                <option value="Banesco">Banesco</option>
                <option value="Banfanb">Banfanb</option>
                <option value="Banplus">Banplus</option>
                <option value="Bicentenario">Bicentenario</option>
                <option value="BOD">BOD</option>
                <option value="Caroni">Caroni</option>
                <option value="Delsur">Delsur</option>
                <option value="Exterior">Exterior</option>
                <option value="Mercantil">Mercantil</option>
                <option value="Plaza">Plaza</option>
                <option value="Provincial">Provincial</option>
                <option value="Venezolano de Credito">Venezolano de Credito</option>
                <option value="Venezuela">Venezuela</option>
                <option value="No aplica">No aplica</option>
            </select>
            <label for="numero_sospechoso">Número de cuenta: </label>
            <input type="text" name="numero_sospechoso" id="numero_sospechoso" size="20" maxlength="20" placeholder="Ingresar sin separadores">
            <br>
            <h2>Descripción del hecho:</h2>
            <textarea name="descripcion_denuncia" id="descripcion_denuncia" cols="30" rows="10"
                placeholder="Descripción detallada de lo ocurrido"></textarea>
            <br>
            <input type="submit" value="Registrar Denuncia"> <!-- register complaint -->
            <input type="reset" value="Borrar todo"> <!-- reset form button -->
        </form>
    </main>
</body>
</html>