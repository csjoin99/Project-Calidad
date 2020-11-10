const buttonTalla = document.getElementsByClassName('button-talla');
const inputTallaArticulo = document.getElementById('idArticuloTalla');
const submitAddChart = document.getElementById('submit-add-chart');
const inputTalla = document.getElementById('nombreTalla');

window.addEventListener("load", function() {

    for (let i = 0; i < buttonTalla.length; i++) {
        if (parseInt(buttonTalla[i].name) === 0) {
            buttonTalla[i].disabled = true;
        }
    }
});

for (let i = 0; i < buttonTalla.length; i++) {
    buttonTalla[i].addEventListener("click", function() {
        inputTallaArticulo.value = buttonTalla[i].id;
        inputTalla.value = buttonTalla[i].textContent;
        submitAddChart.disabled = false;
    });
}