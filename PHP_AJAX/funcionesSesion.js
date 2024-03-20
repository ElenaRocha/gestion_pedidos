function login() {
    var XMLHttpRequestObject = new XMLHttpRequest();

    XMLHttpRequestObject.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText==="FALSE") {
                alert("Revise usuario y contraseña");
            } else {
                var usiario_json = JSON.parse(this.responseText);
                document.getElementById("principal").style.display="block";
                document.getElementById("login").style.display="none";
                document.getElementById("cabecera").innerHTML = "Usuario: " + usiario_json[0]["email"];
            }
        }
    }

    var usuario = document.getElementById("usuario").ariaValueMax;
    var clave = document.getElementById("clave").ariaValueMax;
    var params = "usuario="+usuario + "&clave="+clave;

    XMLHttpRequestObject.open("POST", "server_login.php", true);
    XMLHttpRequestObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    return false;
}

function logout() {
    var XMLHttpRequestObject = new XMLHttpRequest();

    XMLHttpRequestObject.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 100) {
            document.getElementById("principal").style.display="none";
            document.getElementById("login").style.display="block";
            document.getElementById("título").innerHTML="";
            document.getElementById("contenido").innerHTML="";
        }
    }

    XMLHttpRequestObject.open("GET", "server_logout.php", true);
    XMLHttpRequestObject.send();
    return false;
}