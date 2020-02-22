$(document).ready(function() {//entra aqui cuando la página ha cargado con exito
    // getdetails será nuestra función para enviar la solicitud ajax
    let permitido = true;
    let getdetails = function (values) {
        console.log(values);
        let parametros = {"nombre":values};
        let peticion = $.ajax({
            url: "peticion_de_acceso.php",
            method: "POST",
            data: parametros,
            dataType: "json"
        })
        return peticion;
    };
    //funcion de comprobacion de campos

    $("form#form :input").blur(function(){
        console.log($(this).val());
        valor = this; //guardamos para usarlo luego ya que this se cambia despues de la llamada

    //cada vez que un campo pierda focus, se llama a ajax y se pasa el atributo de this ($(this).val())
        getdetails($(this).val())
            .done(function(response) {
                //primero eliminamos el mensaje de fallo anterior

                //response es lo que recibimos por json
                //recibimos un array con un valor bool y un array de errores
                //si hemos pasado nombre, tendremos success: true si es válido, false si tiene errores y
                //el array asociativo contendra nombre como key
                console.log(response);
                if(response.success === true){//mostramos valid
                    console.log(this);
                    $("#"+valor.id).addClass('form-control is-valid col-md-2  offset-md-3');
                    $("<div class='valid-feedback'>Campo válido</div>").insertAfter("#"+this.id);
                }

                else{//mostramos invalid
                    console.log('klk');
                    errores = response.errores;

                    $.each(errores, function(key, value) {//solo hay una key
                        if(typeof errores[key] !== undefined){
                            console.log(key);

                            $("#"+key).addClass('is-invalid col-md-2  offset-md-3');
                            $("<div class='invalid-feedback'>"+value+"</div>").insertAfter("#"+key);
                        }
                    });
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

    //funcion de insercion de datos
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
                        $("<div class='invalid-feedback'>"+value+"</div>").insertAfter("#"+key);
                    }
                });

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