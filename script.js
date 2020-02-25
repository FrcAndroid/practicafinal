//IMPORTANTE: Usa form-control en las clases de html
$(document).ready(function() {//entra aqui cuando la página ha cargado con exito
    // getdetails será nuestra función para enviar la solicitud ajax
    let valido = new Object; //variable de cuantos campos no tienen fallos, se reinicia al reiniciar la pagina
    let formValues = $('#form')[0].length;
    console.log($('#form')[0]);
    console.log(formValues);
    for (let i=0; i< formValues; i++){
        console.log('entra');
        if($("#"+$('#form')[0][i].id).hasClass('form-control')){//es una variable a controlar
            valido[$('#form')[0][i].id] = false;//asignamos el valor inicial de valido
        }
    }
    console.log(valido.length);
    //tras este bucle, tenemos un array de validos que tiene solo las variables que tenemos que controlar y no depende del formulario que
    //estemos usando.

    let permitido = true;
    let getdetails = function (values) {
        let parametros = {};
        parametros['usuario'] = $("#usuario").val();
        console.log(parametros);
        parametros[values.attr('id')] = values.val();
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
        valor = this; //guardamos para usarlo luego ya que this se cambia despues de la llamada
        console.log($(this));
    //cada vez que un campo pierda focus, se llama a ajax y se pasa el atributo de this ($(this).val())
        getdetails($(this))
            .done(function(response) {
                //primero eliminamos el mensaje de fallo anterior

                $("#"+valor.id).removeClass('is-invalid is-valid');
                $("#"+valor.id+"Mensaje").remove();
                //console.log($("#"+valor.id+"Error"));

                //response es lo que recibimos por json
                //recibimos un array con un valor bool y un array de errores
                //si hemos pasado nombre, tendremos success: true si es válido, false si tiene errores y
                //el array asociativo contendra nombre como key
                mensaje = document.createElement("div");
                mensaje.id = valor.id + "Mensaje";
                console.log(mensaje);

                if(response.success === true){//eliminamos y mostramos valid, no hay error
                    $("#"+valor.id).addClass('is-valid');
                    mensaje.innerText = "Campo válido";
                    $("#"+mensaje.id).addClass(' offset-md-3 valid-feedback');
                    $("#"+mensaje.id).insertAfter("#"+valor.id);

                    //añadimos valor al array de validos
                        valido[valor.id] = true;
                        console.log(valido);


                }

                else{//mostramos invalid, hay error

                    $("#"+valor.id).addClass('form-control form-inline col-md-4 is-invalid');
                    mensaje.innerText = response.errores[valor.id];
                    $("#"+mensaje.id).addClass(' offset-md-3 valid-feedback');
                    $("#"+mensaje.id).insertAfter("#"+valor.id);
                    console.log($("#"+mensaje.id));

                    //añadimos valor al array de validos
                    valido[valor.id] = false;
                    console.log(valido.length);

                }


            })

            .fail(function(jqXHR, textStatus, errorThrown) {
                $("#textFail").remove();
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
        let values = $('#form').serialize();

        $("#textFail").remove();//eliminamos el elemento de fallo por si ahora sale bien
        e.preventDefault();

        //la funcion del boton es primero comprobar si no existen errores en el formulario, aqui iteramos el array de validos
        let permitido = true;
        console.log(valido);
        $.each(valido, function(key, value) {
            console.log('each');
            if(value === false){
                permitido = false;
            }
        });
        //si no existen errores, pasamos llamada ajax para introducir el usuario en la base de datos de solicitudes, pasando una variable
        //especial llamada insertar, le pasamos la variable y  el form serializado

        let insertar = function (parametros) {
            let peticion = $.ajax({
                url: "peticion_de_acceso.php",
                method: "POST",
                data: parametros,
            })
            return peticion;
        };
        parametros = {
            "valores": values,
            "insertar": true,
            "usuario": $("#usuario").val()
        }
        //entramos a la solicitud desde aqui
        if(permitido == true){
            console.log(permitido);
            insertar(parametros)
                .done(function(response) {//entra aqui cuando sale bien la llamada
                    console.log(response);
                    //los errores estan en response.errores
                    //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido

                    if (response.success === false) {

                    }
                    else {

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
        }

        
    });
    
});