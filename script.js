// Función para obtener la lista de invitados almacenada en el navegador
function obtenerInvitadosGuardados() {
    var invitadosGuardados = localStorage.getItem("invitados");
    if (invitadosGuardados) {
        return JSON.parse(invitadosGuardados);
    } else {
        return [];
    }
}

// Función para guardar la lista de invitados en el navegador
function guardarInvitados(invitados) {
    localStorage.setItem("invitados", JSON.stringify(invitados));
}

// Función para cargar los invitados al cargar la página
window.onload = function() {
    var invitados = obtenerInvitadosGuardados();
    mostrarInvitados(invitados);
};

// Función para agregar invitado
function agregarInvitado() {
    var nombre = document.getElementById("nombre").value;
    if (nombre.trim() !== "") {
        var invitados = obtenerInvitadosGuardados();
        invitados.push(nombre);
        guardarInvitados(invitados);
        mostrarInvitados(invitados);
        document.getElementById("nombre").value = "";
    }
}

// Función para mostrar los invitados en la tabla
function mostrarInvitados(invitados) {
    var listaHTML = "";
    for (var i = 0; i < invitados.length; i++) {
        listaHTML += "<tr>";
        listaHTML += "<td>" + invitados[i] + "</td>";
        listaHTML += "<td><span class='delete-btn' onclick='eliminarInvitado(" + i + ")'>Eliminar</span></td>";
        listaHTML += "</tr>";
    }
    document.getElementById("lista-invitados").innerHTML = listaHTML;
}

// Función para eliminar invitado
function eliminarInvitado(index) {
    var confirmar = confirm("¿Estás seguro de que deseas eliminar este invitado?");
    if (confirmar) {
        var invitados = obtenerInvitadosGuardados();
        invitados.splice(index, 1);
        guardarInvitados(invitados);
        mostrarInvitados(invitados);
    }
}
