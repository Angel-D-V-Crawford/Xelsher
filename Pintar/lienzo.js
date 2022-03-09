
const lienzo = document.getElementById("lienzo");
const contexto = lienzo.getContext("2d");

const dimensionDefault = lienzo.width;

const canvasGrid = document.getElementById("capaGrid");
const ctxGrid = canvasGrid.getContext("2d");

var verGrid = true;
var borrando = false;

// Redimensionar
/*
lienzo.width = dimensionDefault;
lienzo.height = dimensionDefault;

canvasGrid.width = dimensionDefault;
canvasGrid.height = dimensionDefault;
*/

console.log(lienzo.width, lienzo.height);

// Creando un grid
var celdaDimension = 20;

var filas = Math.round(canvasGrid.height / celdaDimension);
var columnas = Math.round(canvasGrid.width / celdaDimension);

var imagenCargada = null;

function abrirArchivo() {

    var archivo = document.querySelector("input[type=file]").files[0];
    var lector = new FileReader();

    lector.onloadend = function() {

        imagenCargada = lector.result;
        console.log(imagenCargada);

        var imagen = new Image();
        imagen.src = imagenCargada;
        imagen.onload = function() {

            var validado = validarArchivo(archivo);
            if(validado) {

                contexto.beginPath();
                contexto.clearRect(0, 0, dimensionDefault, dimensionDefault);
                contexto.drawImage(imagen, 0, 0);

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

    if(tamano > 64000) {

        alert(nombre + " es demasiado grande, debe de ser menor de 64 KB");
        bandera = false;

    }

    return bandera;

} // fin validarArchivo

function cambiarModoDibujo(elemento) {

    var etiqueta = document.getElementById("modo");

    if(elemento.value == "Pincel") {

        borrando = false;
        etiqueta.innerHTML = "Modo: Pincel";
        console.log("Borrando: ", borrando);

    } else if(elemento.value == "Borrador") {

        borrando = true;
        etiqueta.innerHTML = "Modo: Borrador";
        console.log("Borrando: ", borrando)

    } // fin if else

} // fin cambiarModoDibujo

function cambiarGrid(elemento) {

    if(elemento.checked) {

        verGrid = true;

        canvasGrid.style.zIndex = "1";
        lienzo.style.zIndex = "0";

    } else {

        verGrid = false;

        canvasGrid.style.zIndex = "0";
        lienzo.style.zIndex = "1";

        ctxGrid.beginPath();
        ctxGrid.clearRect(0, 0, dimensionDefault, dimensionDefault);

    } // fin if else

    refrescar();

} // fin cambiarGrid

function refrescar() {

    if(verGrid) {

        for(var y = 0; y < columnas; y++) {

            for(var x = 0; x < filas; x++) {

                var posX = x * celdaDimension;
                var posY = y * celdaDimension;
                
                ctxGrid.strokeStyle = "#000000";
                ctxGrid.strokeRect(posX, posY, celdaDimension, celdaDimension);

            } // fin for

        } // fin for

        canvasGrid.style.zIndex = "1";
        lienzo.style.zIndex = "0";

    } // fin if

} // fin refrescar

window.addEventListener("load", () => {

    // Pintando fondo
    contexto.fillStyle = "#FFFFFF";
    contexto.fillRect(0, 0, dimensionDefault, dimensionDefault);

    ctxGrid.beginPath();
    ctxGrid.clearRect(0, 0, dimensionDefault, dimensionDefault);

    clientRect = lienzo.getBoundingClientRect();

    var topeIzquierda = clientRect.left;
    var topeSuperior = clientRect.top;

    refrescar();
    console.log("Inicializado");
    console.log("Ancho: ", columnas);
    console.log("Alto: ", filas);
    console.log("Ancho px: ", lienzo.width);
    console.log("Alto px: ", lienzo.height);
    document.getElementById("checkGrid").checked = true;

    // Variables
    let pintando = false;

    // Funciones
    /*
        1 -> Click izquierdo
        2 -> Click derecho
        3 -> Click izquierdo + derecho
        4 -> Click rueda
    */

    function posicionMouse(canvas, e) {

        var ClientRect = canvas.getBoundingClientRect();

        return { //objeto
            x: Math.round(e.clientX - ClientRect.left),
            y: Math.round(e.clientY - ClientRect.top)
        }

    } // fin-posicionMouse

    function botonesMouse(e) {

        if(e.buttons == 1) {

            pintando = true;
            dibujar(e);

        } // fin if

    } // fin botonesMouse

    function terminarTrazo() {

        pintando = false;
        var canvasURL = lienzo.toDataURL("image/png");
        console.log(canvasURL + "\n\n");
        document.getElementById("oculto").value = canvasURL;

    } // fin terminarTrazo

    function dibujar(e) {

        if(pintando) {

            pos = posicionMouse(lienzo, e);
            var encontrado = false;

            for(var y = 0; y < columnas && !encontrado; y++) {

                for(var x = 0; x < filas && !encontrado; x++) {

                    var posX = x * celdaDimension;
                    var posY = y * celdaDimension;

                    //console.log(posX, posY);
                    
                    if((pos.x >= posX && pos.y >= posY) && (pos.x < posX + celdaDimension && pos.y < posY + celdaDimension)) {
                        
                        if(!borrando) {

                            var color = document.getElementById("colores").value;
                            contexto.fillStyle = color;
                            contexto.fillRect(posX, posY, celdaDimension, celdaDimension);

                        } else {

                            contexto.fillStyle = "#FFFFFF";
                            contexto.fillRect(posX, posY, celdaDimension, celdaDimension);

                        }

                        refrescar();
                        encontrado = true;
                        //console.log("Presionado en: ", pos.x, pos.y);

                    } // fin if
        
                } // fin for
        
            } // fin for

        } // fin if

    } // fin-dibujar

    // EventListeners
    lienzo.addEventListener("mousedown", botonesMouse);
    lienzo.addEventListener("mouseup", terminarTrazo);
    lienzo.addEventListener("mousemove", dibujar);
    lienzo.addEventListener("mouseout", terminarTrazo);
    lienzo.addEventListener("mouseenter", botonesMouse);

    canvasGrid.addEventListener("mousedown", botonesMouse);
    canvasGrid.addEventListener("mouseup", terminarTrazo);
    canvasGrid.addEventListener("mousemove", dibujar);
    canvasGrid.addEventListener("mouseout", terminarTrazo);
    canvasGrid.addEventListener("mouseenter", botonesMouse);

    var link = document.getElementById("descarga");
    link.addEventListener("click", function(ev) {

        link.href = lienzo.toDataURL("image/png");
        link.download = "dibujo.png";

    }, false);

});


