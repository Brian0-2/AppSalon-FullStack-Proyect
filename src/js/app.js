//mi variable de mi paginacion en citas/index.php para mi navegacion
let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;
//Funcion para cuando este cargando mi archivo index.php tome ese evento de cargar el archivo
document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});
//Objeto cita
const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []

}

function iniciarApp() {
    mostrarSeccion();//Mustra y oculta las secciones
    tabs();//Cambiar sesion cuando se precionen los tabs
    botonesPaginador();//Agregar o quitar botones del paginador
    paginaSiguiente();
    paginaAnterior();

    consultarAPI(); //Consultar API en el backend php

    idCliente();
    nombreCliente();//Anadir nombre cliente al objeto de cita
    seleccionarCita();//Añadir fecha de la cita en el objeto cita
    seleccionarHora();//Añadir la hora de la cita en el objeto cita

    mostrarResumen();//Mostrar el resumen de su cita
    buscarPorFecha();//Muestra las citas ocupadas por citas
}



// Obtener referencias a los inputs de fecha y hora
const fechaInput = document.querySelector('#fecha');
const horaInput = document.querySelector('#hora');

// Agregar eventos de cambio a los inputs con un callback para que llamen la funcion asi mismos
fechaInput.addEventListener('input', function () {
    validarCitas();
});

horaInput.addEventListener('input', function () {
    validarCitas();
});

//VALIDAR CITAS SI YA HAY
async function validarCitas() {
    try {
        const url = 'http://localhost:3000/api/citas';
        const resultado = await fetch(url);
        const citas = await resultado.json();
        console.log(citas);
        console.log(cita);

        // Obtiene la fecha seleccionada por el usuario
        const fechaSeleccionada = fechaInput.value;

        // Obtiene la hora seleccionada por el usuario y le agrega los segundos ':00'
        const horaSeleccionada = horaInput.value.slice(0, 5) + ':00';

        // Convierte la hora seleccionada por el usuario en un objeto Date y lo convierte a un timestamp
        const horaSeleccionadaTimestamp = Date.parse(`01/01/2000 ${horaSeleccionada}`);

        // Define una constante para representar una hora en milisegundos
        const unaHoraEnMilisegundos = 3600000;

        // Recorre el array de citas para validar si hay alguna cita en la misma fecha y hora seleccionada
        for (let i = 0; i < citas.length; i++) {
            const cita = citas[i];

            // Convierte la hora de la cita en un objeto Date y lo convierte a un timestamp
            const citaTimestamp = Date.parse(`01/01/2000 ${cita.hora}`);

            // Calcula la diferencia en horas entre la hora de la cita y la hora seleccionada por el usuario
            //  Math.abs se utiliza para asegurarse de que la diferencia sea siempre positiva
            const diferenciaHoras = Math.abs((citaTimestamp - horaSeleccionadaTimestamp) / unaHoraEnMilisegundos);

            // Comprueba si hay una cita
            if (cita.fecha === fechaSeleccionada && diferenciaHoras <= .99) {
                mostrarAlerta('Ya Hay una Cita. Procura dentro de 1 hora', 'error', '#paso-1 p');
                horaInput.value = '';
                break;
            }
        }

        if (horaInput.value === '') {
            cita.hora = '';
            console.log(cita);
            return;
        }

    } catch (error) {
        console.log(error);
    }
}

//BUSCAR CITAS QUE YA HAYA EN UNA
 function buscarPorFecha(){
     const fechaInput = document.querySelector('#fecha');
     fechaInput.addEventListener('input', function(e){
         const fechaSeleccionada =  e.target.value;
        
         window.location = `?addFecha=${fechaSeleccionada}`;
     });

     cita.fecha = fechaInput.value;
 }
console.log(cita);

//BUSCADOR de servicos
document.addEventListener("keyup", e => {
    if (e.target.matches('#buscar')) {
        document.querySelectorAll('.servicio').forEach(partitura =>{

            partitura.textContent.toLocaleLowerCase().includes(e.target.value.toLocaleLowerCase())

            ?partitura.classList.remove('filtro')
            :partitura.classList.add('filtro');
        });
    }
});
console.log(cita);

//MOSTRANDO SECCIONES SEGUN LA PAGINACION
function mostrarSeccion() {
    //Ocultar la seccion que tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }
    //Seleccionar la seccion dependiendo el paso
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    //Quitar la clase acutal al tab anterior
    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior) {
        tabAnterior.classList.remove('actual');
    }

    //Resaltar el tab actual o mi paso actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

//FONDO DE BOTONES
function tabs() {
    //seleccionar botones
    const botones = document.querySelectorAll('.tabs button');

    //funcion para recorrer todos mis botones con el evento click
    botones.forEach(boton => {
        boton.addEventListener('click', function (e) {
            //selecciono los atributos que me arroja
            paso = parseInt(e.target.dataset.paso);

            mostrarSeccion();
            botonesPaginador();

        })
    })
}

//PAGINADOR DE BOTONES
function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');
    //pagina 1
    if (paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
        //pagina 2
    } else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');

        mostrarResumen();
        //pagina 3
    } else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    //mando llamar mis vistas
    mostrarSeccion();
}

//PAGINACION POR PAGINA con el movimiento de dictan los botones
function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function () {
        if (paso <= pasoInicial) return;
        //pagina a la izquierda
        paso--;
        botonesPaginador();
    });
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function () {
        if (paso >= pasoFinal) return;
        //pagina a la derecha
        paso++;
        botonesPaginador();
    });
}

//API PARA ARRASTRAR MIS DATOS DE APPSALON.SQL
async function consultarAPI() {
    try {
        const url = 'http://localhost:3000/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();

        mostrarServicios(servicios);
        //en caso de no haber echo la peticion recoje el error
    } catch (error) {
        console.log(error);
    }
}

//CREAR TEMPLATES PARA LOS SERVICIOS
function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        // destructuring o destructuracion
        const { id, nombre, precio } = servicio;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;

        servicioDiv.onclick = function () {
            seleccionarServicio(servicio);
        }

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;


        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDiv);
    });
}

//FUNCION PARA LA SELECCION DE LOS SERVICIOS
function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;

    //Identificar el elemento que se le de click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    //comprobar si un servicio ya fue agregado
    if (servicios.some(agregado => agregado.id === id)) {
        //Eliminarlo
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');
    } else {
        //Agregarlo
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }

}

function idCliente() {
    cita.id = document.querySelector('#id').value;
}

//Agregar a mi arreglo cita el nombre
function nombreCliente() {
    cita.nombre = document.querySelector('#nombre').value;
}

//SELECCIONAR fecha de las citas
function seleccionarCita() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function (e) {
      const dia = new Date(e.target.value).getUTCDay();
  
      if ([0].includes(dia)) {
        e.target.value = '';
        e.stopImmediatePropagation(); // Detiene la propagación del evento
        
        Swal.fire({
          title: 'los Domingos no estan disponibles',
          icon: 'warning',
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'OK',
       
          customClass: {
            popup: 'tamaño-alerta'
          }
        });
  
        cita.fecha = '';
      } 
    });
  }
  

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function (e) {
        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];
        const dia = new Date(cita.fecha).getUTCDay();

        if (dia === 6) { // Es Sabado              //4           //8
            if ((hora >= 6 && hora < 14) || (hora >= 16 && hora <= 20)) {
                cita.hora = horaCita;
                //Horarios de Comida
            } else if (hora >= 14 && hora < 16) {
                e.target.value = '';
                mostrarAlerta('Hora no valida en horarios de comida', 'error', '#paso-1 p');
                cita.hora = '';
            } else {
                //Horarios que no se labora
                e.target.value = '';
                mostrarAlerta('Hora no valida fuera de servicio', 'error', '#paso-1 p');
                cita.hora = '';
            }
        } else { // Es día de semana de labor
            if ((hora >= 9 && hora < 14) || (hora >= 16 && hora <= 20)) {
                cita.hora = horaCita;

            } else if (hora >= 14 && hora < 16) {
                //Horarios de Comida
                e.target.value = '';
                mostrarAlerta('Hora no valida en horarios de comida', 'error', '#paso-1 p');
                cita.hora = '';
            } else {
                //Horarios que no se labora
                e.target.value = '';
                mostrarAlerta('Hora no valida fuera de servicio', 'error', '#paso-1 p');
                cita.hora = '';
            }
        }
    });
}

//MOSTRAR ALERTAS DE FECHAS
//mensaje es para lo que le digo al cliente , tipo pues eñ tipo de mensaje , elemento es en donde lo quiero aparecer y desaparece es en el resumen
function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
    // metodo para que no se creen mas alertas si lo ejecutan varias veces
    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) {
        alertaPrevia.remove();
    }

    //Para el mensaje creo un div
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;

    //Agregamos la clase de tipo error que esta definida en mi SCSS
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    //Paginacion 2 despues del parrafo agregar la informacion al usuario
    const referencia = document.querySelector(elemento);

    //Mostrar templates
    referencia.appendChild(alerta);


    if (desaparece) {
        //Metodo para que cada 5 segundos que se quite mi elemento html
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }

}


function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    //limpiar contenido del resumen
    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    //verifico que mi objeto no este vacio. Verifico que hayan seleccionado servicios
    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Faltan datos de Servicios, Fecha u Hora.', 'error', '.contenido-resumen', false);
        // console.log(cita);
        return;
    }

    //Formatear el div de resumen con  destructuring o destructuracion
    const { nombre, fecha, hora, servicios } = cita;

    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de Cita';
    resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    //Darle formato a la fecha
    const fechaOBJ = new Date(fecha);
    const mes = fechaOBJ.getMonth();
    const dia = fechaOBJ.getDate() + 2;
    const year = fechaOBJ.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));

    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    //Darle formato a hora
    //slice(posicion que empieza a tomar la cadena , lo que va a tomar); cadena a onbtener =  "HH:mm:ss"
    const hora24 = hora.slice(0, 2); // Extrae las primeras dos cifras de la cadena hora, que corresponden a las horas en formato 24 horas
    const minutos = hora.slice(3, 5);
    const hora12 = hora24 > 12 ? hora24 - 12 : hora24; // Convierte las horas en formato 24 horas a formato 12 horas
    const amPm = hora24 >= 12 ? 'PM' : 'AM'; // Determina si es "AM" o "PM"
    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora12}:${minutos} ${amPm}`; // Establece el contenido del elemento "P" con la hora en formato 12 horas

    //Mostrar resumen
    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);


    let total = 0;
    //Iterando y mostrando los servicios
    servicios.forEach(servicio => {
        const { id, precio, nombre } = servicio;

        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);

        total += parseFloat(precio);
    });

    const totalPrecio = document.createElement('P');
    totalPrecio.classList.add('total');
    totalPrecio.innerHTML = `<span>Total:</span> $${total}`;
    resumen.appendChild(totalPrecio);

    //Boton para reservar cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.id ='reservar';
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = function(event) {
        Swal.fire({
          title: '¿Está seguro que desea reservar la cita?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Sí, reservar cita',
          cancelButtonText: 'Cancelar',
          customClass: {
            popup: 'tamaño-alerta'
        }
        }).then((result) => {
          if (result.isConfirmed) {
            reservarCita();
          } else {
            event.preventDefault();
          }
        });
      };

    resumen.appendChild(botonReservar);

}



async function reservarCita() {

    const { fecha, hora, servicios, id } = cita;
    const idServicios = servicios.map(servicio => servicio.id);
    // console.log(idServicios);

    const datos = new FormData();

    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuario_id', id);
    datos.append('servicios', idServicios);

    // console.log(...datos);
    try {
        //Peticion hacia la API
        const url = 'http://localhost:3000/api/citas'
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();
        // console.log(resultado);
        //Alerta de insercion correcta
            Swal.fire({
                icon: 'success',
                title: 'Cita Creada',
                text: 'Tu Cita Fue Creada Correctamente',
                button: 'OK',
                customClass: {
                    popup: 'tamaño-alerta'
                }
            }).then(() => {
                window.location.reload();
            });
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un Error al Guardar la Cita',
            customClass: {
                popup: 'tamaño-alerta'
            }
        });
    }

}

 // console.log([...datos]); forma para ver los datos que estare enviando en FormData
// ../build/img/imagen.png'