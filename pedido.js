'use strict'
//ajax que llamamos cuando añadimos un producto

$(document).ready(function() {//entra aqui cuando la página ha cargado con exito
    //creamos variable de carrito
    let carrito = new Object;
    let i = 0;
    let precios = [];

    let getdetails = function (values) {
        let parametros = {};
        parametros = {
            "valores" : values
        }
        let peticion = $.ajax({
            url: "datos_carrito.php",
            method: "POST",
            data: parametros,
            dataType: "json"
        })
        return peticion;
    };
    
    $("form").submit(function(e){//añadir articulos a carrito
        console.log('a');
        e.preventDefault();
        let val = $(this); //guardamos cantidad para futuro
        let form = $(this).serialize();
        console.log(form);
        getdetails(form)
        
        .done(function(response) {//entra aqui cuando sale bien la llamada
            console.log(response);
            console.log(response.COD_ARTICULO);
            //ahora metemos cosas en el carrito
            //primero miramos si el carrito tiene elementos, y si no, lo creamos
            if(Object.keys(carrito).length > 0){
                console.log('tiene cosas');
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
                    articulo.appendChild(borrar);

                    articulos = document.getElementById("articulos");

                    articulos.appendChild(articulo);
                    carrito[i] = response;
                    precios[i] = val[0][1].value * response.PRECIO;
                    let precio = 0;
                    for(let j=0; j<precios.length; j++){
                        precio+= precios[j];
                    }
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
                caja.style.cssText= "text-align: left; font-size: 20px; position: fixed; right: 0; bottom: 0; width: 30%; background-color: blue; color: white";
                
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
                console.log(val);
                let articulo = document.createElement('div');
                articulo.id = i;
                articulo.innerText = response.NOMBRE + " (" + val[0][1].value + ")   " + (val[0][1].value * response.PRECIO) + "€";
                articulo.appendChild(borrar1);

                caja2.appendChild(articulo);
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








});