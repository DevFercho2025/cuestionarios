const video  = document.querySelector(".video");
const btn    = document.querySelector(".answer-photo-btn");
const btnView = document.querySelector(".toggle-photo-btn");
const aPhoto  = document.querySelector(".answer-photo");

const constraints = {
    video: {
        width: { ideal: 800 }, 
        height: { ideal: 600 },
        aspectRatio: 4/3
    },
    audio: false
};

async function obtenerVideo() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        video.srcObject = stream;
        video.play();
        video.addEventListener("loadedmetadata", () => {
            //console.log(video.videoWidth, video.videoHeight);
        });
    } catch (error) {
        console.error("No se pudo acceder a la cámara", error);
    }
}

obtenerVideo();


btn.addEventListener("click", (e) => {
    e.preventDefault();

    //canvas temporal
    let canvas = document.createElement("canvas");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    let context = canvas.getContext("2d");
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    //convertir a base64
    let data = canvas.toDataURL("image/png");

    //mostrar a usuario
    aPhoto.src = data;

    //activar botón de ver foto
    btnView.disabled = false;
    btnView.classList.remove("btn-secondary");
    btnView.classList.add("btn-primary");
    btnView.classList.add("active");

    //animación
    btnView.classList.remove("pulse");
    void btnView.offsetWidth;
    btnView.classList.add("pulse");
});

btnView.addEventListener("click", (e) => {
    e.preventDefault();
    if (!btnView.classList.contains("active")) return;

    if (aPhoto.style.display === "none" || aPhoto.style.display === "") {
        aPhoto.style.display = "block";
        btnView.textContent = "Ocultar foto";
    } else {
        aPhoto.style.display = "none";
        btnView.textContent = "Ver foto";
    }
});