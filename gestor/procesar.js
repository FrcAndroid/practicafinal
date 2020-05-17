'use strict'
$(document).ready(function() {
    //cargamos la funcion ajax
let arrayProcesos = [];
    let getdetails = function (values, link) {
        return $.ajax({
            url: link,
            method: "POST",
            data: values,
            dataType: "json"
        });
    };

    $('.cliente').change(function(){
        //hacemos request ajax pasando el cliente
        let values = {
            cliente: $(this).val()
        }
        //quitamos los procesos por si los hubieran
        arrayProcesos = [];
        if(typeof $(this).val() !== undefined){
            getdetails(values, 'comprobarAlbaranFactura.php')
                .done(function(response){
                    if(typeof response.lista !== 'undefined') {
                        //primero quitamos los datos por si ya existieran
                        $(".cont").remove();
                        let lista = response.lista;
                        $.each(lista, function (i) {
                            console.log(lista);
                            $("tbody").append("<tr class='cont'>" +
                                "<td class='cod'>" + lista[i].COD_ALBARAN + "</td>" +
                                "<td>" + lista[i].COD_CLIENTE + "</td>" +
                                "<td>" + lista[i].FECHA + "</td>" +
                                "<td>" + lista[i].CONCEPTO + "</td>" +
                                "<td><button class= 'proceso btn btn-success btn-default' value='"+ lista[i].COD_CLIENTE + "'> Procesar a factura </button></td>"+
                                "</tr>");
                        });
                    }
                    else{
                        alert(response.error);
                    }

                });
        }

    });

    $(document).on('click', ".proceso", function(){
        //simplemente colocamos en un array los valores
        arrayProcesos.push($(this).parent().siblings('.cod').text())//valor de la linea del pedido

        //ahora cambiamos el estado del boton a procesando
        $(this).html("Procesando...");
        $(this).removeClass("btn-success proceso");
        $(this).addClass("btn-warning procesando");
    });

    $(document).on('click', ".procesando", function(){
        //quitamos el valor del array
        arrayProcesos.splice($.inArray(this.value, arrayProcesos), 1);
        //ahora cambiamos el estado del boton a procesar
        $(this).html("Procesar a factura");
        $(this).removeClass("btn-warning procesando");
        $(this).addClass("btn-success proceso");
    });


    $(document).on('click', ".procesofinal", function(){
        //pedimos el descuento
        let descuento = prompt("Introduce el descuento de la factura (opcional).");
        let concepto = prompt("Introduce el concepto de la factura.");

        if(descuento != null && concepto != null){
            if(descuento == ""){
                descuento = 0;
            }
            //detectamos si hay lineas por procesar
            if(Array.isArray(arrayProcesos) && arrayProcesos.length){
                //hay albaranes para procesar y las mandamos por jquery junto al codigo del albaran que queremos procesar
                let values = {
                    "concepto": concepto,
                    "codcliente": this.value,
                    "albaran": arrayProcesos,
                    "descuento": descuento
                }

                getdetails(values, "comprobarAlbaranFactura.php")
                    .done(function (response) {
                        if(typeof response.success != "undefined"){
                            alert(response.success);
                            window.location.href = "ver_albaranes_gestor.php";
                        }
                        else{
                            alert(response.error);
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
            }
        }

    });
});
