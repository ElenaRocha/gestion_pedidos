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
