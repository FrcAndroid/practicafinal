'use strict'
let arrayProcesos = [];
//creamos evento cuando clica en boton

let getdetails = function (values) {
    return $.ajax({
        url: "comprobarPedidoAlbaran.php",
        method: "POST",
        data: values,
        dataType: "json"
    });
};

$(document).on('click', ".proceso", function(){
    //simplemente colocamos en un array los valores
    arrayProcesos.push(this.value)//valor de la linea del pedido
    console.log(arrayProcesos);

    //ahora cambiamos el estado del boton a procesando
    $(this).html("Procesando...");
    $(this).removeClass("btn-success proceso");
    $(this).addClass("btn-warning procesando");
    });

$(document).on('click', ".procesando", function(){
    //quitamos el valor del array
    arrayProcesos.splice($.inArray(this.value, arrayProcesos), 1);
    console.log(arrayProcesos);
    //ahora cambiamos el estado del boton a procesar
    $(this).html("Procesar");
    $(this).removeClass("btn-warning procesando");
    $(this).addClass("btn-success proceso");
});

$(document).on('click', ".procesofinal", function(){
    //pedimos el concepto
    let concepto = prompt("Introduce el concepto del albarán.")
    //detectamos si hay lineas por procesar
    if(Array.isArray(arrayProcesos) && arrayProcesos.length){
        //hay lineas para procesar y las mandamos por jquery junto al codigo del pedido que queremos modificar
        let values = {
            "lineas": arrayProcesos,
            "pedido": this.value,
            "concepto": concepto
        }

        getdetails(values)
            .done(function (response) {
                if(typeof response.success != "undefined"){
                    alert(response.success);
                    window.location.href = "ver_pedido_gestor.php";
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
});