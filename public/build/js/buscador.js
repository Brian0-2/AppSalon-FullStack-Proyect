function iniciarApp(){buscarPorFecha()}function buscarPorFecha(){document.querySelector("#fecha").addEventListener("input",(function(e){const t=e.target.value;window.location="?fecha="+t}))}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()})),document.addEventListener("keyup",e=>{e.target.matches("#buscador")&&document.querySelectorAll(".cada-uno").forEach(t=>{t.textContent.toLocaleLowerCase().includes(e.target.value.toLocaleLowerCase())?t.classList.remove("filtro"):t.classList.add("filtro")})});