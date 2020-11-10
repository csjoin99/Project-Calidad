const editbutton = document.getElementsByName('editbutton');
const deletebutton = document.getElementsByName('deletebutton');
const idArticulo = document.getElementsByName('idArticulo');
const nombreArticulo = document.getElementsByName('nombreArticulo');
const categoriaArticulo = document.getElementsByName('categoriaArticulo');
const precioArticulo = document.getElementsByName('precioArticulo');
const generoArticulo = document.getElementsByName('generoArticulo');
/* const fotoArticulo = document.getElementsByName('fotoArticulo'); */
for (let i = 0; i < precioArticulo.length; i++) {
    precioArticulo[i].addEventListener("input", function() {
        let tempval = precioArticulo[i].value
        if (tempval < 0) {
            precioArticulo[i].value = 1;
        }
        if (String(tempval).split('.')[1].length > 2) {
            precioArticulo[i].value = parseFloat(this.value).toFixed(2);
        }
    });
}
for (let i = 0; i < editbutton.length; i++) {
    editbutton[i].addEventListener("click", function() {
        let row = editbutton[i].closest('tr');
        idArticulo[0].value = row.children[0].value
        nombreArticulo[1].value = row.children[1].textContent
        nombreArticulo[1].value = row.children[1].textContent
        categoriaArticulo[1].value = row.children[2].textContent
        precioArticulo[1].value = row.children[3].textContent
        let gender = row.children[5].textContent
        switch (gender) {
            case "Hombre":
                generoArticulo[1].value = 1;
                break;
            case "Mujer":
                generoArticulo[1].value = 2;
                break;
            case "Unisex":
                generoArticulo[1].value = 3;
                break;
        }
    });
}
for (let i = 0; i < deletebutton.length; i++) {
    deletebutton[i].addEventListener("click", function() {
        let row = editbutton[i].closest('tr');
        idArticulo[1].value = row.children[0].value
    });
}