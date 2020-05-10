'use strict'
//ajax para alta, baja, aceptar y rechazar solicitudes
$(document).ready(function(){
    //cargamos la funcion ajax
    let getdetails = function (values) {
        return $.ajax({
            url: "comprobar_clientes.php",
            method: "POST",
            data: values,
            dataType: "json"
        });
    };

    $('.alta').click(function(event){
        //cuando damos de alta, hacemos update a la tabla
        //recogemos el codigo del cliente
        let values = {
            "cod": $(this).parent().parent().children().first().attr('data-value'),
            "alta": true
        }
        getdetails(values)
            .done(function(response) {
                if(typeof response.success !== 'undefined'){
                    alert("Alta exitosa!");
                    location.reload();
                }
                else{
                    alert(response.error);
                    location.reload();
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

    $('.baja').click(function(event){
        let values = {
            "cod": $(this).parent().parent().children().first().attr('data-value'),
            "baja": true
        }

        getdetails(values)
            .done(function(response) {
                if(typeof response.success !== 'undefined'){
                    alert("Baja exitosa!");
                    location.reload();
                }
                else{
                    alert(response.error);
                    location.reload();
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

    $('.aceptar').click(function(event){
        let values = {
            "cod": $(this).parent().parent().children().first().attr('data-value'),
            "aceptar": true
        }

        getdetails(values)
            .done(function(response) {
                if(typeof response.success !== 'undefined'){
                    alert("Solicitud aceptada!");
                    location.reload();
                }
                else{
                    alert(response.error);
                    location.reload();
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

    $('.rechazar').click(function(event){
        console.log('entra')
        let values = {
            "cod": $(this).parent().parent().children().first().attr('data-value'),
            "rechazar": true
        }

        getdetails(values)
            .done(function(response) {
                if(typeof response.success !== 'undefined'){
                    alert("Solicitud rechazada!");
                    location.reload();
                }
                else{
                    alert(response.error);
                    location.reload();
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

    $(".editable").focusout(function(event){
        //primero sacamos el valor nuevo
        console.log('aaa');

        let valor = $(this).parent();
        console.log($(this).parent());

        //de esto queremos saber headers, value, la linea del pedido y el codigo
        let values = {
            "header": $(this).attr("headers"),
            "value": $(this).prop("innerText"),
            "linea": $(this).parent().children().first().prop("innerText"),
            "cod": $(this).parent().children().first().attr('value')
        };
        console.log(values);
        console.log(valor);
        //llamamos a ajax
        getdetails(values, "comprobar_clientes.php")
            .done(function(response) {
                //response es el json
                console.log(response);
                if(typeof response.exito !== 'undefined'){
                    $("#success").remove();
                    $("<div/>",{
                        "id": "success",
                        "class" : "text-success",
                        "html" : response.success,
                    }).appendTo("body");
                }
                else{
                    $("#fail").remove();

                    $("<div/>",{
                        "id": "fail",
                        "class" : "text-danger",
                        "html" : response.error,
                    }).appendTo("body");
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




});