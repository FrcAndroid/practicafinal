'use strict';
//recibimos evento tras cambiar el td
$(document).ready(function() {//entra aqui cuando la página ha cargado con exito
    //cargamos la funcion ajax

    let getdetails = function (values, link) {
        return $.ajax({
            url: link,
            method: "POST",
            data: values,
            dataType: "json"
        });
    };

    $(".editable").focusout(function(event){
        //primero sacamos el valor nuevo
        let valor = $(this);

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
        getdetails(values, "comprobarModificar.php")
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