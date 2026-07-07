function verErrorGeolocalizacion(code) {
    switch(code) {
        case 1:
            Swal.fire({
                title: 'ALERTA!',
                text: "Se ha bloqueado la localización. Se debe permitir para poner tomar las coordenadas",
                icon: 'error'
            });
            break;
        case 2:
            Swal.fire({
                title: 'ALERTA!',
                text: "Revise la configuración de su dispositivo y asegúrese de que la ubicación esté activa.",
                icon: 'error'
            });
            break;
        case 3:
            Swal.fire({
                title: 'ALERTA!',
                text: "Revise la señal del dispositivo y su conexión a internet.",
                icon: 'error'
            });
            break;
        default:
            Swal.fire({
                title: 'ALERTA!',
                text: "Ocurrió un error desconocido al tomar las coordenadas. Intente de nuevo más tarde.",
                icon: 'error'
            });
            break;
    }
}

const geolocalizar = async () => {
    try {
        const pos = await new Promise((resolve, reject) => {
            navigator.geolocation.getCurrentPosition(resolve, reject, {maximumAge:0.001, timeout:5000, enableHighAccuracy: true});
        });
        return {
            success: true,
            longitud: pos.coords.longitude,
            latitud: pos.coords.latitude,
            precision: Math.round(pos.coords.accuracy),
        };
    } catch (error) {
        console.error(error);
        verErrorGeolocalizacion(error.code);
        return {
            success: false,
            code: error.code
        };
    }
};