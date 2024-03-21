function cargarCategorias() {
    var XMLHttpRequestObject = new XMLHttpRequest();

    XMLHttpRequestObject.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var titulo = document.getElementById("titulo");
            var contenido = document.getElementById("contenido");
            titulo.innerHTML = "Categorías";

            var categorias_json = JSON.parse(this.responseText);
            var lista = document.createElement("ul");
            for(var i = 0; i<categorias_json.length; i++) {
                var elem = document.createElement("li");
                vinculo = crearVinculoCategorias(categorias_json[i].nombre, categorias_json[i].categoria_id);
                elem.appendChild(vinculo);
                lista.appendChild(elem);
            }

            contenido.innerHTML = "";
            contenido.appendChild(lista);
        }
    }

    XMLHttpRequestObject.open("GET", "server_categorias.php", true);
    XMLHttpRequestObject.send();
    return false;
}

function crearVinculoCategorias(nombre, codCategoria) {
    var vinculo = document.createElement("a");
    var ruta = "server_productos.php?categoria=" + codCategoria;
    vinculo.href = ruta;
    vinculo.innerHTML = nombre;
    vinculo.onclick = function(){return cargarProductos(this);}
    return vinculo;
}

function cargarProductos(destino) {
    var XMLHttpRequestObject = new XMLHttpRequest();

    XMLHttpRequestObject.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var titulo = document.getElementById("titulo");
            var contenido = document.getElementById("contenido");
            titulo.innerHTML = "Productos";

            try {
                var productos_json = JSON.parse(this.responseText);
                var tabla = crearTablaProductos(productos_json);
                contenido.innerHTML = "";
                contenido.appendChild(tabla);
            } catch(e) {
                var mensaje = document.createElement("p");
                mensaje.innerHTML = "Categoria sin productos";
                contenido.innerHTML = "";
                contenido.appendChild(mensaje);
            }
        }
    };

    XMLHttpRequestObject.open("GET", destino, true);
    XMLHttpRequestObject.send();
    return false;
}

function crearTablaProductos(productos) {
    var tabla = document.createElement("tabla");
    var cabecera = crearFila(["Código", "Nombre", "Descripción", "Stock", "Comprar"], "th");
    tabla.appendChild(cabecera);
    for(var i = 0; i<productos.length; i++) {
        formulario = crearFormulario("Añadir", productos[i]["producto_id"], anadirProductos);
        fila = crearFila([productos[i]["producto_id"],
                                productos[i]["nombre"],
                                productos[i]["descripción"],
                                productos[i]["stock"]], "td");
        celda = document.createElement("td");
        celda.appendChild(formulario);
        fila.appendChild(celda);
        tabla.appendChild(fila);
    }
    return tabla;
}

function crearFormulario(texto, cod, funcion) {
    var formulario = document.createElement("form");
    var unidades = document.createElement("input");
    unidades.value = 1;
    unidades.name = "unidades";
    var codigo = document.createElement("input");
    codigo.value = cod;
    codigo.type = "hidden";
    codigo.name = "cod";
    var boton = document.createElement("input");
    boton.type = "submit";
    boton.value = texto;
    formulario.onsubmit = function(){return funcion(this);}
    formulario.appendChild(unidades);
    formulario.appendChild(codigo);
    formulario.appendChild(boton);
    return formulario;
}

function crearFila(elementos, tipo) {
    var tr = document.createElement("tr");

    for(var i = 0; i<elementos.length; i++){
        var datos = document.createElement(tipo);
        datos.innerHTML = elementos[i];
        tr.appendChild(datos);
    }

    return tr;
}

function cargarCarrito(){
    var XMLHttpRequestObject = new XMLHttpRequest();

    XMLHttpRequestObject.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var contenido = document.getElementById("contenido");
            var titulo = document.getElementById("titulo");
            titulo.innerHTML = "Carrito";
            try {
                var productos_json = JSON.parse(this.responseText);
                var tabla = crearTablaCarrito(productos_json);
                contenido.innerHTML = "";
                contenido.appendChild(tabla);

                var confirmar = document.createElement("a");
                confirmar.href = "#";
                confirmar.onclick = function(){return procesarPedido();}
                confirmar.innerHTML = "Confirmar pedido";
                contenido.appendChild(confirmar);
            } catch(e) {
                var mensaje = document.createElement("p");
                mensaje.innerHTML = "Carrito sin producto";
                contenido.innerHTML = "";
                contenido.appendChild(mensaje);
            }
        }
    };
    XMLHttpRequestObject.open("GET", "server_carrito.php", true);
    XMLHttpRequestObject.send();
    return false;
}

function crearTablaCarrito(productos) {
    var tabla = document.createElement("tabla");
    var cabecera = crearFila(["Código", "Nombre", "Descripción", "Unidades", "Eliminar"], "th");
    tabla.appendChild(cabecera);
    for(var i = 0; i<productos.length; i++){
        formulario = crearFormulario("Eliminar", productos[i]["producto_id"], eliminarProductos);
        fila = crearFila([productos[i]["producto_id"],
                        productos[i]["nombre"],
                        productos[i]["descripción"],
                        productos[i]["unidades"]], "td");
        celda = document.createElement("td");
        celda.appendChild(formulario);
        fila.appendChild(celda);
        tabla.appendChild(fila);
    }
    return tabla;
}

function anadirProductos(formulario) {
    var XMLHttpRequestObject = new XMLHttpRequest();

    XMLHttpRequestObject.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("Producto añadido con éxito");
            cargarCarrito();
        }
    };
    var params = "cod=" + formulario.elements["cod"].value + "&unidades=" + formulario.elements["unidades"].value;
    XMLHttpRequestObject.open("POST", "server_productosAnadir.php", true);
    XMLHttpRequestObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XMLHttpRequestObject.send(params);
    return false;
}

function procesarPedido() {
    var XMLHttpRequestObject = new XMLHttpRequest();

    XMLHttpRequestObject.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("Entra");
            var contenido = document.getElementById("contenido");
            var titulo = document.getElementById("título");
            contenido.innerHTML = "";
            titulo.innerHTML = "Estado del pedido";
            if(this.responseText == "TRUE") {
                contenido.innerHTML = "Pedido realizado";
            } else {
                contenido.innerHTML = "Error al procesar el pedido";
            }
        }
    };

    XMLHttpRequestObject.open("GET", "server_procesarPedido.php", true);
    XMLHttpRequestObject.send();
    return false;
}
