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
