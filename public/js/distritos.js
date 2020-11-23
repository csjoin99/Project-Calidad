/* try {
    window.onload = function() {
        const select_state = document.getElementById("select-state");
        //Cargar json 
        fetch('/json/US_States_and_Cities.json').then(function(res) {
            return res.json();
        }).then(function(data) {
            //Mostrar lista de estados en select
            for (x in data) {
                option = document.createElement('option');
                option.text = x;
                option.value = x;
                select_state.add(option);
            }
        });
    };
} catch (error) {} */