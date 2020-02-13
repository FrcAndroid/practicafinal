$(document).ready(function() {//entra aqui cuando la página ha cargado con exito
    
    // getdetails será nuestra función para enviar la solicitud ajax    
    var getdetails = function() {        
        var variables = $.getJSON("peticion_de_acceso.php", {
            
            "nombre": $("#nombre").val(),//selector jquery, equivalente a document.getElementById('nombre').value
            "cif": $("#cif").val(),
            "razonsocial" : $("#razonsocial").val(),
            "telefono": $("#tlf").val(),
            "correo": $("#email").val(),
            "nick": $("#nick").val(),
            "contraseña": $("#pass").val()

            
        });
        console.log(variables);
        console.log($("#nombre").val());
        return variables;

    }
    
    // Al hacer click sobre cualquier elemento que tenga el atributo data-user.....
    $('[data-user]').click(function() {

        $("#textFail").remove();//eliminamos el elemento de fallo por si ahora sale bien
        
        
        // this hace referencia al elemento que ha lanzado el evento click
        // con el método .data('user') obtenemos el valor del atributo data-user de dicho elemento y lo pasamos a la función getdetails definida anteriormente
        getdetails()
        
        .done(function(response) {//entra aqui cuando sale bien la llamada
            
            //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
            if (response.success) {
                //esto es si la llamada se ha hecho correctamente, ahora comprobamos la validez de los datos
                console.log(response);
                //nombre

                var output = "<h1>" + response.data.message + "</h1>";
                
                // recorremos cada usuario
                $.each(response.data.users, function(key, value) {
                    
                    output += "<h2>Detalles del usuario " + val()['ID'] + "</h2>";
                    
                    // recorremos los valores de cada usuario
                    $.each(val(), function(userkey, uservalue) {
                        
                        output += '<ul>';
                        output += '<li>' + userkey + ': ' + userval() + "</li>";
                        output += '</ul>';
                        
                    });
                    
                });
                
                // Actualizamos el HTML del elemento con id="#response-container"
                $("#response-container").html(output);
                
                } else {
                
                //response.success no es true
                $("#response-container").html('No ha habido suerte: ' + response.data.message);
                
            }
            
        })
        
        .fail(function(jqXHR, textStatus, errorThrown) {
            $("<div/>",{
                "id": "textFail",
                "class" : "text-danger",
                // .. you can go on and add properties
                "html" : "Algo ha fallado: " + textStatus,
            }).appendTo("body");
            
        });
        
    });
    
});