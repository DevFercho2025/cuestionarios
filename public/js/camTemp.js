
if (document.readyState === "complete") {
    iniciarTemporizador();
    iniciarCamara();
    console.log(document.querySelector('input[name="rango_inicio"]'));
    console.log(document.querySelector('input[name="rango_fin"]'));

    /*
    let recordingContainer = document.querySelector(".recording-container");

    if (recordingContainer) {
        recordingContainer.addEventListener("click", mostrarVideo);
    } else {
        console.error("No se encontró el elemento .recording-container");
    }*/

} else {
    window.addEventListener("load", iniciarCamara);
}


function mostrarVideo() {
    console.log("clic a mostrarVideo");
    let videoContainer = document.getElementById('videoContainer');
    if (videoContainer.style.display === 'none' || videoContainer.style.display === '') {
        videoContainer.style.display = 'block';
    } else {
        videoContainer.style.display = 'none';
    }
}

//Camara
function iniciarCamara() {
    console.log("script para tomar fotos funcionando.");

    const progresoTexto = document.querySelector(".texto-Progreso");
    const idSeccion = progresoTexto?.dataset.idSeccion;

    const temporizadorElemento = document.getElementById("temporizador-" + idSeccion);
    if (!temporizadorElemento) {
        console.error("No se encontró el temporizador para idSeccion:", idSeccion);
        return;
    }

    //elementos
    const video = document.querySelector(".video");
    const foto = document.querySelector(".fotoUsuario");
    //mediaDevices permite interactuar con archivos o parte multimedia/hardward de pc

    //constraints
    const constraints = {
        video: { width: "420", height: "420" },
        audio: false
    }//En controller de camara se guardan

    //petición de acceso a webCam *async
    const obtenerVideo = async (stream) => {
        try {
            //*promesa await, una promesa es un obj que representa una operación que aún no termina pero lo hará en el futuro.
            const stream = await navigator.mediaDevices.getUserMedia(constraints)
            console.log("Cámara accesible:", stream);
            handleSuccess(stream);
        } catch (error) {
            console.log("x Cámara no accesible", error);
        }
    }

    //si la promesa tiene éxito
    const handleSuccess = (stream) => {
        video.srcObject = stream //foto estático
        video.play() //ver video

        stream.getTracks().forEach(track => {
            track.onended = () => {
                console.log("El flujo de la cámara se ha detenido"); //<-- esto aparece si el permiso se quita repentinamente
                //video.srcObject = null; // Limpiar el srcObject cuando se detiene
            };
        });

        // Verificar el estado de reproducción
        video.onplay = () => {
            console.log("El video está reproduciendo correctamente");
        };
        video.onpause = () => {
            console.log("El video se ha pausado");
            video.play().catch(error => console.log("No se pudo reanudar el video:", error));
        };
        video.onerror = (error) => {
            console.log("Error en la reproducción del video:", error);
        };
    }

    //llamar funcino get
    obtenerVideo()
    if (!video) {
        console.error("Error: No se encontró el elemento <video> con la clase 'video'");
        return;
    }

    //definir cada cuánto tomar foto automática
    setTimeout(() => {
        const temporizadorElemento = document.getElementById("temporizador-" + idSeccion);
        if (!temporizadorElemento) {
            console.error("Temporizador no encontrado para idSeccion:", idSeccion);
            return;
        }
    
        const tiempoTextoMatch = temporizadorElemento.textContent.match(/\d{1,2}:\d{2}/);
        if (!tiempoTextoMatch) {
            console.error("No se pudo encontrar el formato de tiempo en el temporizador.");
            return;
        }
    
        let [minutos, segundos] = tiempoTextoMatch[0].split(":").map(num => parseInt(num, 10));
        let tiempoRestante = (minutos * 60) + segundos;
        let tomarFotoCada = Math.floor(tiempoRestante / 3);
        console.log(tomarFotoCada);
        iniciarCronometro(tomarFotoCada);
    }, 1000);

    function iniciarCronometro(x) {
        let tiempoTranscurrido = 0;

        let intervalo = setInterval(() => {
            tiempoTranscurrido++;
            console.log(`Tiempo transcurrido: ${tiempoTranscurrido} segundos`);

            if (tiempoTranscurrido % x === 0) {
                console.log(`Han pasado ${x} segundos`);
                tomarFoto();
            }
        }, 1000);
    }

    function tomarFoto() {
        let canvas = document.createElement('canvas'); // Crear un canvas temporal
        canvas.width = 420;
        canvas.height = 420;

        let contexto = canvas.getContext('2d')
        contexto.drawImage(video, 0, 0, 420, 420)
        //pasar canvas a png
        let data = canvas.toDataURL('image/png')
        foto.setAttribute('src', data)

        fetch(`${document.querySelector('meta[name="base-url"]').getAttribute('content')}/guardar-foto`, {

            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ image: data }) // Enviar la imagen en Base64
        })
            .then(response => response.json())
            .then(data => {
                console.log("Imagen guardada:", data);
                //alert("Imagen guardada en: " + data.file_path); // Muestra la URL en un alert
            })
            .catch(error => console.error('Error al guardar la imagen:', error));
    };

};

//Temporizador para las secciones
function iniciarTemporizador() {
    console.log("script para temporizador de evaluación cargado");

    const progresoTexto = document.querySelector(".texto-Progreso");
    const idSeccion = progresoTexto.dataset.idSeccion;

    const temporizadorElemento = document.getElementById("temporizador-" + idSeccion);
    let tiempoAgotadoInput = document.getElementById("tiempo_agotado");
    temporizadorElemento.style.display = "block";

    let tiempoTexto = temporizadorElemento.textContent.match(/\d{1,2}:\d{2}/);
    let [minutos, segundos] = tiempoTexto[0].split(":").map(num => parseInt(num, 10)); //guarda min y seg por separado, los pone entre :
    let tiempoRestante = (minutos * 60) + segundos; //convierte el tiempo a segundos

    let intervalo = setInterval(() => {
        if (tiempoRestante > 0) {
            tiempoRestante--;
            let min = Math.floor(tiempoRestante / 60);
            let seg = tiempoRestante % 60;
            temporizadorElemento.textContent = `Tiempo restante: ${min}:${seg.toString().padStart(2, '0')}`;
        } else {
            clearInterval(intervalo);
            temporizadorElemento.textContent = "Tiempo agotado";
            tiempoAgotadoInput.value = "1";

            //desabilitar respuestas
            let respuestas = document.querySelectorAll(".pregunta .respuesta");
            document.querySelectorAll(".pregunta .form-check-input").forEach(input => {
                input.disabled = true;
            });


            //alert("Se agotó el tiempo para esta sección.");
            document.querySelector("form").submit(); //click a siguiente automáticamente
        }
    }, 1000);
}