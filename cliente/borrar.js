'use strict'
//borrar y eliminar
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

    $(".borrar").click(function(event){
        //de esto queremos saber headers, value, la linea del pedido y el codigo
        let values = {
            "linea": $(this).parent().children()[0].nextSibling.data.trim(),
            "cod": $(this).parent().attr("value"),
            "borrar" : true
        };

        //llamamos a ajax
        getdetails(values, "comprobarBorrar.php")
            .done(function(response) {
                //response es el json
                if(typeof response.exito !== 'undefined'){
                    //exito
                    alert(response.exito);
                    if(response.borrado === true){
                        window.location.href = "ver_pedido.php";
                    }
                    else{
                        window.location.reload();
                    }

                }
                else{
                    //fracaso
                    alert('Ocurrio un problema, ' + response.error);
                    window.location.reload();
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

    $(".eliminar").click(function(event){

        var r = confirm("Esto borrará todo el pedido!");
        if (r == false) {
        } else {
            let values = {
                "cod": $(this).parent().children("table").children("tbody").children("tr").children("td").first().attr('value'),
                "eliminar": true
            };

            getdetails(values, "comprobarBorrar.php")
                .done(function(response) {


                });
        }
    });


});