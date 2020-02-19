$(document).ready(function() {//entra aqui cuando la página ha cargado con exito
    // getdetails será nuestra función para enviar la solicitud ajax
    let getdetails = function (values) {
        let peticion = $.ajax({
            url: "peticion_de_acceso.php",
            type: "post",
            data: values,
            contentType: "application/json; charset=utf-8"
        })
        return peticion;
    };

    // Al hacer click sobre cualquier elemento que tenga el atributo data-user.....
    $('#alta').click(function(e) {
        console.log($('form'));
        let values = $('#form').serialize();
        console.log(values);


        $("#textFail").remove();//eliminamos el elemento de fallo por si ahora sale bien
        $(".errores").remove();//eliminamos los errores


        e.preventDefault();
        // this hace referencia al elemento que ha lanzado el evento click
        // con el método .data('user') obtenemos el valor del atributo data-user de dicho elemento y lo pasamos a la función getdetails definida anteriormente
        getdetails(values)        
        .done(function(response) {//entra aqui cuando sale bien la llamada
            //los errores estan en response.errores
            //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido

    
            if (response.success === false) {
                //esto es si la llamada se ha hecho correctamente
                
                errores = response.errores;
                
                $.each(errores, function(key, value) {
                    if(typeof errores[key] !== undefined){
                        console.log(key);
                        //cont = "<div>"+value+"</div>";
                        //$(cont).addClass("col-md-2 offset-md-3");
                        $("#"+key).addClass('form-control is-invalid col-md-2  offset-md-3');
                        $("<div class='text-danger small offset-md-5 errores'>"+value+"</div>").insertAfter("#"+key);
                    }
                });
                /*var output = "<h1>" + response.data.message + "</h1>";
                
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
                $("#response-container").html(output);*/
                
            } 
            else {
            console.log('entra pero falla');
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