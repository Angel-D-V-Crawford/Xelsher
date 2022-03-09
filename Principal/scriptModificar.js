

function abrirArchivo() {

    var archivo = document.querySelector("input[type=file]").files[0];
    var lector = new FileReader();

    lector.onloadend = function() {

        var imagenCargada = lector.result;
        //console.log(imagenCargada);

        var imagen = new Image();
        imagen.src = imagenCargada;
        imagen.onload = function() {
            
            var validacion = validarArchivo(archivo);
            if(validacion) {

                var imgHTML = document.getElementById("imagen");
                imgHTML.src = imagenCargada;

            } // fin if
            
        } // fin function

    } // fin function

    if(archivo) {

        lector.readAsDataURL(archivo);

    } // fin if

} // fin abrirArchivo


function validarArchivo(arch) {

    var bandera = true;

    var tamano = arch.size;
    var nombre = arch.name;

    if(tamano > 16776900) {

        alert(nombre + " es demasiado grande, debe de ser menor de 17 MB");
        bandera = false;

    }

    return bandera;

} // fin validarArchivo





