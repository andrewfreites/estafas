<?php
session_start();
header("Cache-control:private");
include 'modules/checkUser.php'; 
if($_SESSION['loggedin']=="") 
{ 
    header("Location: ./modules/error.php"); 
 exit; 
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script src="js/jquery-3.4.1.js"></script>
    <title>Crear Denuncia</title>
</head>
<body>
<header>
    <nav class="topnav" id="myTopnav">
        <a href="admin.php">Menú</a>
        <a href="consultas.php">Consultas</a>
        <a href="denuncia.php" class="active">Tomar denuncia</a>
        <a href="modules/logout.php">Salir</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()"><i class="fa fa-bars"></i></a>
        </nav>
        <script src="js/nav.js"></script>
</header>
<!-- Script para número de teléfono -->
<script type="text/javascript">
    $(document).ready(function(){
    var maxField = 5; //Input fields increment limitation
    var addButton = $('.add_phone'); //Add button selector
    var wrapper = $('.phone_wrapper'); //Input field wrapper
    var fieldHTML = '<tr><th><label for="telefono_sospechoso">Otro: </label></th><td><input type="tel" name="telefono_sospechoso[]" id="telefono_sospechoso" size="16" maxlength="11" value="No Disponible" placeholder="ejemplo: 04141234567"> <input type="button" class= "remove_phone" value="-" onClick="javascript:void(0);" title="Quitar campo" style="width:25px"></td></tr>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
        } else{
            alert(`Ha alzando el máximo permitido de números telefónicos ${maxField} por cada denuncia realizada`)
        }
    });
    $(wrapper).on('click', '.remove_phone', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('td').parent('tr').remove(); //Remove field html
        x--; //Decrement field counter
        });
    });
</script>
<main role="main">
    <h2 style="text-align:center">Crear denuncia</h2>
    <!-- complaint form -->
    <form action="modules/reg-denun.php" method="POST" class="denuncia">
    <div class="datosVictima">
    <h3 style="text-align:center">Datos de la víctima:</h3>
        <table width="350px">
        <tr>
            <th><label for="expedient">Expediente: </label></th>
            <td><input type="text" name="expedient" id="expedient" pattern="^[A-Za-z]-\d{2}-\d{4}-\d{5,6}" title="K-19-1234-12345" maxlength="16" size="18" placeholder="K-12-1234-12345" required></td>
        </tr>            
        <tr>
            <th><label for="cedula_victima">Cédula de identidad: </label></th>
            <td><input type="text" name="cedula_victima" id="cedula_victima" size="18" maxlength="8" placeholder="sin puntos ni separadores" required></td>
        </tr>
        <tr>
            <th><label for="nombre_victima">Nombre: </label></th>
            <td><input type="text" name="nombre_victima" id="nombre_victima" pattern="[A-Za-z\s\u00f1\u00d1]+" title="Sólo se permiten letras" maxlength="40" size="18" required></td>
        </tr>
        <tr>
            <th><label for="monto-estafado">Monto estafado: </label></th>
            <td><input type="number" name="monto_estafado" id="monto_estafado" size="18" style="width:155px"></td>
            </tr>
        </table>
    </div>
    <div class="datosSospechoso">
        <h3 style="text-align:center">Datos del sospechoso:</h3>
        <table class="phone_wrapper" width="350px">
        <tr>
            <th><label for="cedula_sospechoso">Cédula de identidad: </label></th>
            <td><input type="text" name="cedula_sospechoso" id="cedula_sospechoso" size="20" maxlength="8" placeholder="sin puntos ni separadores"></td>
        </tr>
        <tr>
            <th><label for="nombre_sospechoso">Nombre: </label></th>
            <td><input type="text" name="nombre_sospechoso" id="nombre_sospechoso" pattern="[A-Za-z\s\u00f1\u00d1]+" title="Sólo se permiten letras" size="20" maxlength="40"></td>
        </tr>
        <tr>
            <th><label for="telefono_sospechoso">Teléfono: </label></th>                
            <td><input type="text" name="telefono_sospechoso[]" id="telefono_sospechoso" size="16" maxlength="11" value="No Disponible">
            <input type="button" class= "add_phone" value="+" onClick="javascript:void(0);" title="Añadir campo" style="width:25px"></td>
        </tr>
        </table>
<!-- Script para cuenta bancaria -->
<script type="text/javascript">
    $(document).ready(function(){
    var maxField = 5; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.bank_wrapper'); //Input field wrapper
    var fieldHTML = '<tr><td><select name="banco_sospechoso[]" id="banco_sospechoso"><option value="100% Banco">100% Banco</option><option value="Activo">Activo</option><option value="Bancamiga">Bancamiga</option><option value="Bancaribe">Bancaribe</option><option value="Banesco">Banesco</option><option value="Banfanb">Banfanb</option><option value="Banplus">Banplus</option><option value="Bicentenario">Bicentenario</option><option value="BOD">BOD</option><option value="Caroni">Caroni</option><option value="Delsur">Delsur</option><option value="Exterior">Exterior</option><option value="Mercantil">Mercantil</option><option value="Plaza">Plaza</option><option value="Provincial">Provincial</option><option value="Venezolano de Credito">Venezolano de Credito</option><option value="Venezuela">Venezuela</option><option value="No Disponible" SELECTED>No Disponible</option></select></td><td><input type="text" name="cuenta_sospechoso[]" value="" size="17" maxlength="20" /> <input type="button" class= "remove_button" value="-" onClick="javascript:void(0);" title="Quitar campo" style="width:25px"></td></tr>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
        } else{
            alert(`Ha alzando el máximo permitido de cuentas bancarias ${maxField} por cada denuncia realizada`)
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('td').parent('tr').remove(); //Remove field html
        x--; //Decrement field counter
        });
    });
</script>
</div>
<div class="cuentas">
        <h3 style="text-align:center">Datos Bancarios: </h3>
        <table class="bank_wrapper" width="350px">
        <tr>
            <th><label for="banco_sospechoso">Entidad Bancaria: </label></th>
            <th><label for="cuenta_sospechoso">Número: </label></th>
        </tr>
        <tr>
            <td><select name="banco_sospechoso[]" id="banco_sospechoso">
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
                <option value="No Disponible" SELECTED>No Disponible</option>
                </select></td>
            <td><input type="text" name="cuenta_sospechoso[]" id="cuenta_sospechoso" value="No Disponible" maxlength="20" size="17"/>
            <input type="button" class="add_button" value="+" onClick="javascript:void(0);" title="Añadir campo" style="width:25px"></td>
        </tr>
        </table>
        </div>
        <div class="descripción">
        <h3 style="text-align:center">Descripción del hecho:</h3>
        <textarea name="descripcion_denuncia" id="descripcion_denuncia" cols="47" rows="10" placeholder="Descripción detallada de lo ocurrido" maxlength="500"></textarea>
        <p><input type="submit" value="Registrar Denuncia"> <!-- register complaint -->
        <input type="reset" value="Borrar todo"></p> <!-- reset form button -->
        </div>
    </form>
    </main>
    <script src="js/outTime.js"></script>
    <script src="js/rest.js"></script>
    <p id="countdown"></p>
</body>
</html>