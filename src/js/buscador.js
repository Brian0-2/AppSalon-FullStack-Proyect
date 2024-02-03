document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});

function iniciarApp(){
    buscarPorFecha();
}
//Buscador en tiempo real
document.addEventListener("keyup", e => {
    if (e.target.matches('#buscador')) {
        document.querySelectorAll('.cada-uno').forEach(partitura =>{

            partitura.textContent.toLocaleLowerCase().includes(e.target.value.toLocaleLowerCase())
            
            ?partitura.classList.remove('filtro')
            :partitura.classList.add('filtro');
        });
    }
});



function buscarPorFecha(){
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', function(e){
        const fechaSeleccionada =  e.target.value;

        window.location = `?fecha=${fechaSeleccionada}`;
    });
}

