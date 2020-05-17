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



    $(".editable").focus(function(event){

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
                            if(typeof response.success !== 'undefined'){
                                alert(response.success);
                                window.location.reload();
                            }
                            else{
                                if(response.error !== "undefined"){
                                    console.log(response.error)
                                    alert(response.error);
                                    window.location.reload();
                                }
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

});