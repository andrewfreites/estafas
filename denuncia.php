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
    <script src="js/jquery-3.4.1.js"></script>
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
<!-- Script para número de teléfono -->
<script type="text/javascript">
    $(document).ready(function(){
    var maxField = 5; //Input fields increment limitation
    var addButton = $('.add_phone'); //Add button selector
    var wrapper = $('.phone_wrapper'); //Input field wrapper
    var fieldHTML = '<tr><th><label for="telefono_sospechoso">Otro: </label></th><td><input type="tel" name="telefono_sospechoso[]" id="telefono_sospechoso" size="16" maxlength="11" placeholder="ejemplo: 04141234567"> <input type="button" class= "remove_phone" value="-" onClick="javascript:void(0);" title="Quitar campo" style="width:25px"></td></tr>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
        } else{
            alert('Ha alzando el máximo permitido de números telefónicos -5- por cada denuncia realizada')
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
    <h1>Crear denuncia</h1>
    <!-- complaint form -->
    <form action="modules/reg-denun.php" method="POST">
        <h3>Datos de la víctima:</h3>
        <table width="350px">
        <tr>
            <th><label for="expedient">Expediente: </label></th>
            <td><input type="text" name="expedient" id="expedient" pattern="^[A-Za-z]-\d{2}-\d{4}-\d{5}" title="K-19-1234-12345" maxlength="15" size="18" placeholder="K-12-1234-12345" required></td>
        </tr>            
        <tr>
            <th><label for="cedula_victima">Cédula de identidad: </label></th>
            <td><input type="text" name="cedula_victima" id="cedula_victima" size="18" maxlength="8" placeholder="sin puntos ni separadores" required></td>
        </tr>
        <tr>
            <th><label for="nombre_victima">Nombre: </label></th>
            <td><input type="text" name="nombre_victima" id="nombre_victima" size="18" required></td>
        </tr>
        <tr>
            <th><label for="telefono_victima">Teléfono: </label></th>
            <td><input type="tel" name="telefono_victima" id="telefono_victima" size="18" maxlength="11" placeholder="ejemplo: 04141234567"></td>
        </tr>
        <tr>
            <th><label for="fecha">Fecha de la denuncia: </label></th>
            <td><input type="date" name="fecha" id="fecha" style="width:155px" required></td>
        </tr>
        </table>
        <h3>Datos Bancarios de la víctima: </h3>
        <table width="350px">
        <tr>
            <th><label for="banco_victima">Entidad Bancaria: </label></th>
            <td><select name="banco_victima" id="banco_victima"> <!-- select used for bank selection -->
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
                </select></td>
        </tr>
        <tr>
            <th><label for="numero_victima">Número de cuenta: </label></th>
            <td><input type="text" name="numero_victima" id="numero_victima" size="18" maxlength="20" placeholder="Ingresar sin separadores"></td>
        </tr>
        <tr>
            <th><label for="monto-estafado">Monto estafado: </label></th>
            <td><input type="number" name="monto_estafado" id="monto_estafado" size="18" style="width:155px"></td>
            </tr>
        </table>
        <h3>Datos del sospechoso:</h3>
        <table class="phone_wrapper" width="350px">
        <tr>
            <th><label for="cedula_sospechoso">Cédula de identidad: </label></th>
            <td><input type="text" name="cedula_sospechoso" id="cedula_sospechoso" size="20" maxlength="8" placeholder="sin puntos ni separadores"></td>
        </tr>
        <tr>
            <th><label for="nombre_sospechoso">Nombre: </label></th>
            <td><input type="text" name="nombre_sospechoso" id="nombre_sospechoso" size="20"></td>
        </tr>
        <tr>
            <th><label for="telefono_sospechoso">Teléfono: </label></th>                
            <td><input type="tel" name="telefono_sospechoso[]" id="telefono_sospechoso" size="16" maxlength="11" placeholder="ejemplo: 04141234567">
            <input type="button" class= "add_phone" value="+" onClick="javascript:void(0);" title="Añadir campo" style="width:25px"></td>
        </tr>
        </table>
<!-- Script para cuenta bancaria -->
<script type="text/javascript">
    $(document).ready(function(){
    var maxField = 5; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.bank_wrapper'); //Input field wrapper
    var fieldHTML = '<tr><td><select name="banco_sospechoso[]" id="banco_sospechoso"><option value="100% Banco">100% Banco</option><option value="Activo">Activo</option><option value="Bancamiga">Bancamiga</option><option value="Bancaribe">Bancaribe</option><option value="Banesco">Banesco</option><option value="Banfanb">Banfanb</option><option value="Banplus">Banplus</option><option value="Bicentenario">Bicentenario</option><option value="BOD">BOD</option><option value="Caroni">Caroni</option><option value="Delsur">Delsur</option><option value="Exterior">Exterior</option><option value="Mercantil">Mercantil</option><option value="Plaza">Plaza</option><option value="Provincial">Provincial</option><option value="Venezolano de Credito">Venezolano de Credito</option><option value="Venezuela">Venezuela</option><option value="No aplica">No aplica</option></select></td><td><input type="text" name="cuenta_sospechoso[]" value="" size="17" maxlength="20" /> <input type="button" class= "remove_button" value="-" onClick="javascript:void(0);" title="Quitar campo" style="width:25px"></td></tr>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
        } else{
            alert('Ha alzando el máximo permitido de cuentas bancarias -5- por cada denuncia realizada')
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('td').parent('tr').remove(); //Remove field html
        x--; //Decrement field counter
        });
    });
</script>
        <h3>Datos Bancarios: </h3>
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
                <option value="No aplica">No aplica</option>
                </select></td>
            <td><input type="text" name="cuenta_sospechoso[]" value="" id="cuenta_sospechoso" maxlength="20" size="17"/>
            <input type="button" class="add_button" value="+" onClick="javascript:void(0);" title="Añadir campo" style="width:25px"></td>
        </tr>
        </table>
        <h3>Descripción del hecho:</h3>
        <textarea name="descripcion_denuncia" id="descripcion_denuncia" cols="47" rows="10" placeholder="Descripción detallada de lo ocurrido" maxlength="500"></textarea>
        <p><input type="submit" value="Registrar Denuncia"> <!-- register complaint -->
        <input type="reset" value="Borrar todo"></p> <!-- reset form button -->
    </form>
    </main>
</body>
</html>