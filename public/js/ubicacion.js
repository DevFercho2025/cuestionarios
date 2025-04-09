

    /*const obtenerUbicacion = () => {

        navigator.geolocation.getCurrentPosition(permitido, error);
        
        const permitido = () => (posicion) => {
            console.log(posicion)
        }
        const error = () => {
            console.log("no se dio permiso para la ubicación")
        }
    }*/
    
    const obtenerCiudadPais = (lat, lon) => {
        const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=14&addressdetails=1`;
        fetch(url)
            .then(response => response.json())
            .then(data => {
    
                const localidad = data.address.suburb ||
                                  data.address.hamlet ||
                                  data.address.quarter ||
                                  data.address.neighbourhood ||
                                  "Desconocida";
    
                const ciudad = data.address.city ||
                               data.address.town ||
                               data.address.village ||
                               data.address.state_district ||
                               data.address.state ||
                               "Desconocida";
    
                const pais = data.address.country || "Desconocido";
    
                console.log(`Localidad: ${localidad}, Ciudad: ${ciudad}, País: ${pais}`);
    
                //Cierra el SweetAlert cuando obtiene la ubicación :D
                //Swal.close();
                return true;
            })
            .catch(error => {
                console.error("Error al obtener la ubicación:", error);
                Swal.fire("Error", "No se pudo obtener la ubicación.", "error");
            });
    }


