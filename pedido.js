'use strict'
//ajax que llamamos cuando añadimos un producto

$(document).ready(function() {//entra aqui cuando la página ha cargado con exito
    //creamos variable de carrito
    let carrito = {};
    let i = 0;
    let precios = [];



    let getdetails = function (values) {

        return $.ajax({
            url: "datos_carrito.php",
            method: "POST",
            data: values,
            dataType: "json"
        });
    };
    
    $("form").submit(function(e){//añadir articulos a carrito
        e.preventDefault();
        let val = $(this); //guardamos cantidad para futuro
        let form = $(this).serialize();

        let parametros = {
            "valores" : form
        }

        getdetails(parametros)
        
        .done(function(response) {//entra aqui cuando sale bien la llamada
            //ahora metemos cosas en el carrito
            //primero miramos si el carrito tiene elementos, y si no, lo creamos
            if(Object.keys(carrito).length > 0){
                //añadimos objetos extra
                if(val[0][1].value > 0){

                    let borrar = document.createElement('button');
                    borrar.innerText = "Borrar";
                    borrar.id = i;
                    borrar.style.cssText ="margin-left: 10px; position: fixed; right: 0;";
                    $(borrar).addClass("btn-danger borrar");

                    let articulo = document.createElement('div');
                    articulo.id = i;
                    articulo.innerText = response.NOMBRE + " (" + val[0][1].value + ")   " + (val[0][1].value * response.PRECIO) + "€";
                    $(articulo).addClass("articulo");
                    articulo.appendChild(borrar);

                    let articulos = document.getElementById("articulos");

                    articulos.appendChild(articulo);
                    carrito[i] = response;
                    precios[i] = val[0][1].value * response.PRECIO;
                    var precio = 0;
                    for(let j=0; j<precios.length; j++){
                        precio+= precios[j];
                    }
                    total.value = precio;
                    total.innerText = "Total: " + precio + "€";
                    i++;           

                }
                
            }
            else{
                if(val[0][1].value > 0){
                //creamos el carrito
                let caja = document.createElement('div');
                caja.id = "carrito";
                caja.innerText = "Carrito";
                caja.style.cssText= "text-align: left; font-size: 20px; position: fixed; right: 0; bottom: 0; width: 30%; background-color: #9fcdff; color: white";
                
                let caja2 = document.createElement('div');
                caja2.id = "articulos";
                caja2.style.cssText = "font-size: 15px; background-color: white; color: black";
                caja.appendChild(caja2);
                //creamos el boton


                let total = document.createElement('div');
                total.id = "total";
                total.innerText = "Total ";
                total.style.cssText = "font-size: 15px; background-color: beige; color: black;";
                caja.appendChild(total);

                let boton = document.createElement('button');
                boton.id="generar";
                boton.innerText = "Generar pedido";
                boton.style.cssText = "right: 0; text-align: center; width: 100%; MARGIN-BOTTOM: 5%;"
                $(boton).addClass("btn-info");
                caja.appendChild(boton);
                
                let borrar1 = document.createElement('button');
                borrar1.innerText = "Borrar";
                borrar1.id = i;
                borrar1.style.cssText ="margin-left: 10px; position: fixed; right: 0;";
                $(borrar1).addClass("btn-danger borrar");

                
                document.body.appendChild(caja);

                //añadimos los datos del nuevo objeto al carrito
                //sacamos la cantidad del form
                let articulo = document.createElement('div');
                articulo.id = i;
                articulo.innerText = response.NOMBRE + " (" + val[0][1].value + ")   " + (val[0][1].value * response.PRECIO) + "€";
                $(articulo).addClass("articulo");
                articulo.appendChild(borrar1);

                caja2.appendChild(articulo);
                total.value = val[0][1].value * response.PRECIO;
                total.innerText +=" "+ (val[0][1].value * response.PRECIO) + "€";
                carrito[i] = response;
                precios[i] = val[0][1].value * response.PRECIO;
                i++;
                }
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

    $(document).on('click', '.borrar', function(){
        let valor = this.id;
        let dinero = $("#total").val() - precios[valor];
        $("#total").val(dinero);

        precios[valor] = 0;
        delete carrito[valor];
        total.innerText = "Total: " + dinero + "€";
        $(".articulo[id=" + valor + "]").remove();
        i--;

        if(Object.keys(carrito).length == 0){
            //destruimos el carrito
            $("#carrito").remove();
            precios = [];
            carrito = {};
        }
    });

    $(document).on('click', '#generar', function () {//generacion definitiva del pedido a partir del carrito
        //primero vemos si hay un pedido que generar para empezar
        let carritoGenerado = $("#carrito");



        if(typeof carritoGenerado !== undefined && Object.entries(carrito).length > 0){//existe un carrito y tiene valores
            //almacenaremos en PEDIDOS Y LINEA_PEDIDOS para lo que usaremos ajax para llamar a datos_carrito
            //tenemos que llevarnos PRECIO, CANTIDAD, COD_ARTICULO de cada item
            //Cada linea de pedido es un item del pedido y todos se unen por el COD_PEDIDO
            //Generamos los parámetros que necesitemos y llamamos a AJAX
            console.log(carritoGenerado);
            console.log(carrito);
            console.log(precios[0]);
            console.log(carrito[0].PRECIO);
            //precios[i] / carrito[i].PRECIO == CANTIDAD
            //cada indice no nulo del carrito es un elemento del pedido, por lo tanto hacemos un for y vamos montandolos patametros
            let pedido = {};//pedido completo con todas sus lineas
            let productos = 0;
            for(let i in carrito){
                if(typeof carrito[i] !== undefined && typeof precios[i] !== undefined){
                    productos = {
                        "ARTICULO" : carrito[i].COD_ARTICULO,
                        "PRECIO" : precios[i],
                        "CANTIDAD" : precios[i] / carrito[i].PRECIO,
                    }
                    pedido[i] = productos;
                }
            }

            let parametros = {
                "pedido" : pedido,
                "generar" : true
            }

            console.log(pedido);
            getdetails(parametros)
                .done(function(response) {//entra aqui cuando sale bien la llamada

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


    })

});