let circulo = document.querySelector(".circulo-Progreso"),
    valor = document.querySelector(".valor-Progreso"),
    respuestas = document.querySelectorAll(".form-check-input"),
    totalPreguntas = document.querySelectorAll(".pregunta").length,
    respuestasContestadas = 0;

function actualizarProgreso() {
    let porcentaje = Math.round((respuestasContestadas / totalPreguntas) * 100);
    valor.textContent = `${porcentaje}%`;
    circulo.style.background = `conic-gradient(blue ${porcentaje * 3.6}deg, #ededed 0deg)`;
}

respuestas.forEach((respuesta) => {
    respuesta.addEventListener("change", function () {
        let preguntaId = this.closest(".pregunta").id;
        
        // Solo contar si es la primera vez que se responde la pregunta
        if (!this.closest(".pregunta").dataset.respondida) {
            this.closest(".pregunta").dataset.respondida = "true";
            respuestasContestadas++;
            actualizarProgreso();
        }
    });
});

// Actualizar el progreso al iniciar
actualizarProgreso();
