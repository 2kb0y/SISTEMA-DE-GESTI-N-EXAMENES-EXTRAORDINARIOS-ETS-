<?php
// Verificar que el usuario esté autenticado
require_once '../php/check_session.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../loader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 16px;
            background: linear-gradient(135deg, rgba(0, 59, 142, 0.08) 0%, rgba(0, 86, 214, 0.04) 100%);
            border-radius: 12px;
            border: 1px solid rgba(100, 181, 246, 0.2);
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #003B8E;
            font-weight: 600;
        }

        .admin-info i {
            font-size: 20px;
        }

        .btn-logout {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(220, 38, 38, 0.2);
        }

        .btn-logout:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>

<main class="main">

    <!-- HEADER CON INFORMACIÓN DEL ADMIN Y BOTÓN LOGOUT -->
    <div class="admin-header">
        <div class="admin-info">
            <i class="fas fa-user-shield"></i>
            <span>Bienvenido, <?php echo htmlspecialchars($_SESSION["admin_usuario"]); ?></span>
        </div>
        <a href="../php/logout.php" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
        </a>
    </div>

    <div style="margin-bottom: 20px;">
        <a href="../index.html" class="btn-buscar" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
            <i class="fas fa-arrow-left"></i> Volver a inicio
        </a>
    </div>

    <section class="filtros">

        <h2>Registrar ETS</h2>

        <div class="filtros-grid">

            <div class="campo">
                <label><i class="fas fa-graduation-cap"></i> Carrera</label>
                <select id="carrera" name="carrera" required>
                    <option value="">Seleccionar carrera</option>
                    <option value="ISC">ISC</option>
                    <option value="IIA">IIA</option>
                    <option value="LCD">LCD</option>
                </select>
            </div>

            <div class="campo">
                <label><i class="fas fa-calendar"></i> Semestre</label>
                <select id="semestre" name="semestre" required>
                    <option value="">Seleccionar semestre</option>
                    <option value="1">1°</option>
                    <option value="2">2°</option>
                    <option value="3">3°</option>
                    <option value="4">4°</option>
                    <option value="5">5°</option>
                    <option value="6">6°</option>
                    <option value="7">7°</option>
                    <option value="8">8°</option>
                </select>
            </div>

            <div class="campo">
                <label><i class="fas fa-book"></i> Materia</label>
                <input type="text" id="materia" name="materia" placeholder="Nombre de la materia" required>
            </div>

            <div class="campo">
                <label><i class="fas fa-calendar-alt"></i> Fecha</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>

            <div class="campo">
                <label><i class="fas fa-clock"></i> Hora de inicio</label>
                <input type="time" id="hora_inicio" name="hora_inicio" required>
            </div>

            <div class="campo">
                <label><i class="fas fa-sun"></i> Turno</label>
                <select id="turno" name="turno" required>
                    <option value="">Seleccionar turno</option>
                    <option value="Matutino">Matutino</option>
                    <option value="Vespertino">Vespertino</option>
                </select>
            </div>

            <div class="campo">
                <label><i class="fas fa-building"></i> Edificio</label>
                <select id="edificio" name="edificio" required>
                    <option value="">Seleccionar edificio</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <div class="campo">
                <label><i class="fas fa-door-open"></i> Salón</label>
                <input type="text" id="salon" name="salon" placeholder="Número de salón" required>
            </div>

            <div class="campo">
                <label><i class="fas fa-user"></i> Profesor Evaluador</label>
                <input type="text" id="profesor" name="profesor" placeholder="Nombre del profesor" required>
            </div>

        </div>

        <div style="margin-top: 32px; display: flex; flex-direction: column; gap: 16px;">
            <button class="btn-buscar" onclick="guardarETS()" style="width: 100%;">
                <i class="fas fa-save"></i> Guardar ETS
            </button>
            <p id="mensaje"></p>
        </div>

    </section>


    <!--  SOLO UNA SECCIÓN DE LISTADO -->
    <section class="filtros" style="margin-top:30px;">

        <h2>ETS registrados</h2>

        <div class="filtros-grid" style="margin-top:15px;">

    <div class="campo">
        <label><i class="fas fa-graduation-cap"></i> Filtrar carrera</label>
        <select id="filtroCarrera" name="filtroCarrera" onchange="cargarETS()">
            <option value="">Todas</option>
            <option value="ISC">ISC</option>
            <option value="IIA">IIA</option>
            <option value="LCD">LCD</option>
        </select>
    </div>

    <div class="campo">
        <label><i class="fas fa-layer-group"></i> Filtrar semestre</label>
        <select id="filtroSemestre" name="filtroSemestre" onchange="cargarETS()">
            <option value="">Todos</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
        </select>
    </div>

    <div class="campo">
        <label><i class="fas fa-book"></i> Buscar materia</label>
        <input type="text" id="filtroMateria" name="filtroMateria" placeholder="Nombre de la materia..." oninput="cargarETS()">
    </div>

</div>

        <div id="tabla-ets"></div>

<div id="paginacion-ets" class="paginacion-container"></div>

        
    </section>

</main>

<!-- MODAL DE EDICIÓN (ANTES DEL SCRIPT) -->
<div id="modalEditar" class="modal-overlay">

    <div class="modal-box">

        <div class="modal-header">
            <div class="modal-header-content">
                <div class="modal-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h2>Editar Examen ETS</h2>
                    <p>Actualiza los detalles del examen</p>
                </div>
            </div>
            <button class="close-btn" onclick="cerrarModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="modal-body">

            <input type="hidden" id="edit_id" name="edit_id">

            <!-- Fila 1: Materia y Carrera -->
            <div class="modal-fields-row">
                <div class="modal-field">
                    <label><i class="fas fa-book"></i> Materia</label>
                    <input type="text" id="edit_materia" name="edit_materia" placeholder="Nombre de la materia" required>
                </div>
                <div class="modal-field">
                    <label><i class="fas fa-graduation-cap"></i> Carrera</label>
                    <select id="edit_carrera" name="edit_carrera" required>
                        <option value="">Seleccionar carrera</option>
                        <option value="ISC">ISC</option>
                        <option value="IIA">IIA</option>
                        <option value="LCD">LCD</option>
                    </select>
                </div>
            </div>

            <!-- Fila 2: Semestre y Fecha -->
            <div class="modal-fields-row">
                <div class="modal-field">
                    <label><i class="fas fa-layer-group"></i> Semestre</label>
                    <select id="edit_semestre" name="edit_semestre" required>
                        <option value="">Seleccionar semestre</option>
                        <option value="1">1°</option>
                        <option value="2">2°</option>
                        <option value="3">3°</option>
                        <option value="4">4°</option>
                        <option value="5">5°</option>
                        <option value="6">6°</option>
                        <option value="7">7°</option>
                        <option value="8">8°</option>
                    </select>
                </div>
                <div class="modal-field">
                    <label><i class="fas fa-calendar-alt"></i> Fecha</label>
                    <input type="date" id="edit_fecha" name="edit_fecha" required>
                </div>
            </div>

            <!-- Fila 3: Hora y Turno -->
            <div class="modal-fields-row">
                <div class="modal-field">
                    <label><i class="fas fa-clock"></i> Hora de inicio</label>
                    <input type="time" id="edit_hora_inicio" name="edit_hora_inicio" required>
                </div>
                <div class="modal-field">
                    <label><i class="fas fa-sun"></i> Turno</label>
                    <select id="edit_turno" name="edit_turno" required>
                        <option value="">Seleccionar turno</option>
                        <option value="Matutino">Matutino</option>
                        <option value="Vespertino">Vespertino</option>
                    </select>
                </div>
            </div>

            <!-- Fila 4: Edificio y Salón -->
            <div class="modal-fields-row">
                <div class="modal-field">
                    <label><i class="fas fa-building"></i> Edificio</label>
                    <input type="text" id="edit_edificio" name="edit_edificio" placeholder="Número del edificio" required>
                </div>
                <div class="modal-field">
                    <label><i class="fas fa-door-open"></i> Salón</label>
                    <input type="text" id="edit_salon" name="edit_salon" placeholder="Número de salón" required>
                </div>
            </div>

            <!-- Fila 5: Profesor (ancho completo) -->
            <div class="modal-fields-row">
                <div class="modal-field" style="grid-column: 1/-1;">
                    <label><i class="fas fa-chalkboard-user"></i> Profesor Evaluador</label>
                    <input type="text" id="edit_profesor" name="edit_profesor" placeholder="Nombre del profesor evaluador" required>
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button class="btn-cancel" onclick="cerrarModal()">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <button class="btn-save" onclick="guardarEdicion()">
                <i class="fas fa-check"></i> Guardar Cambios
            </button>
        </div>

    </div>
</div>

<script>

let idEditar = null;
let datosTabla = [];
let paginaActual = 1;
const registrosPorPagina = 6;

// =====================
// GUARDAR / EDITAR
// =====================
async function guardarETS() {

    // Verificar que ningún campo esté vacío
    if (!carrera || !semestre || !materia || !fecha || !hora_inicio || !turno || !edificio || !salon || !profesor) {
        Swal.fire({
            title: "⚠️ Campos Incompletos",
            html: `
                <div style="text-align: left; background: #FEF2F2; padding: 20px; border-radius: 8px; border-left: 4px solid #DC2626;">
                    <p style="margin: 0 0 12px 0; font-weight: 600; color: #DC2626;">
                        <i class="fas fa-exclamation-circle"></i> Por favor completa estos campos:
                    </p>
                    <ul style="margin: 0; padding-left: 20px; color: #991B1B;">
                        ${!carrera ? "<li>Carrera</li>" : ""}
                        ${!semestre ? "<li>Semestre</li>" : ""}
                        ${!materia ? "<li>Materia</li>" : ""}
                        ${!fecha ? "<li>Fecha</li>" : ""}
                        ${!hora_inicio ? "<li>Hora de inicio</li>" : ""}
                        ${!turno ? "<li>Turno</li>" : ""}
                        ${!edificio ? "<li>Edificio</li>" : ""}
                        ${!salon ? "<li>Salón</li>" : ""}
                        ${!profesor ? "<li>Profesor Evaluador</li>" : ""}
                    </ul>
                </div>
            `,
            icon: "error",
            confirmButtonColor: "#DC2626",
            confirmButtonText: "Entendido",
            background: "rgba(255, 255, 255, 0.95)",
            backdrop: "rgba(15, 23, 42, 0.5) url('')",
            zIndex: 99999,
            didOpen: (modal) => {
                modal.style.backdropFilter = "blur(10px)";
                modal.style.zIndex = "99999";
                document.querySelector('.swal2-container').style.zIndex = "99999";
            }
        });
        return;
    }

    const datos = new FormData();

    datos.append("carrera", carrera);
    datos.append("semestre", semestre);
    datos.append("materia", materia);
    datos.append("fecha", fecha);
    datos.append("turno", turno);
    datos.append("edificio", edificio);
    datos.append("salon", salon);
    datos.append("profesor", profesor);
    datos.append("hora_inicio", hora_inicio);

    try {
        const res = await fetch("../php/agregar.php", {
            method: "POST",
            body: datos
        });

        const text = await res.text();
        console.log("Respuesta del servidor:", text);

        // 🔴 MANEJO DE TRASLAPE
        if (text.includes("TRASLAPE")) {
            Swal.fire({
                title: "⚠️ Conflicto detectado",
                html: text,
                icon: "warning",
                confirmButtonColor: "#0056D6",
                confirmButtonText: "Entendido",
                background: "rgba(255, 255, 255, 0.85)",
                backdrop: "rgba(15, 23, 42, 0.5) url('')",
                didOpen: (modal) => {
                    modal.style.backdropFilter = "blur(10px)";
                }
            });
            return;
        }

        // ✅ ÉXITO
        if (text.includes("OK")) {
            Swal.fire({
                title: "✔️ ¡Éxito!",
                text: "ETS registrado correctamente",
                icon: "success",
                confirmButtonColor: "#0056D6",
                confirmButtonText: "Continuar",
                background: "rgba(255, 255, 255, 0.85)",
                backdrop: "rgba(15, 23, 42, 0.5) url('')",
                didOpen: (modal) => {
                    modal.style.backdropFilter = "blur(10px)";
                }
            });

            limpiarFormulario();
            cargarETS();
            return;
        }

        // ❌ ERROR DESCONOCIDO
        Swal.fire({
            title: "❌ Error",
            text: text || "Error desconocido al guardar ETS",
            icon: "error",
            confirmButtonColor: "#DC2626",
            confirmButtonText: "Entendido",
            background: "rgba(255, 255, 255, 0.85)",
            backdrop: "rgba(15, 23, 42, 0.5) url('')",
            didOpen: (modal) => {
                modal.style.backdropFilter = "blur(10px)";
            }
        });
    } catch (error) {
        console.error("Error en guardarETS:", error);
        Swal.fire({
            title: "❌ Error de conexión",
            text: error.message,
            icon: "error",
            confirmButtonColor: "#DC2626",
            confirmButtonText: "Entendido",
            background: "rgba(255, 255, 255, 0.85)",
            backdrop: "rgba(15, 23, 42, 0.5) url('')",
            didOpen: (modal) => {
                modal.style.backdropFilter = "blur(10px)";
            }
        });
    }
}

// =====================
// MOSTRAR CON PAGINACIÓN
// =====================
async function cargarETS(){
    const carrera = document.getElementById("filtroCarrera")?.value || "";
    const semestre = document.getElementById("filtroSemestre")?.value || "";
    const materia = document.getElementById("filtroMateria")?.value || "";

    const url = `../php/listar.php?carrera=${carrera}&semestre=${semestre}&materia=${materia}`;

    const res = await fetch(url);
    datosTabla = await res.json();
    paginaActual = 1;

    const contenedor = document.getElementById("tabla-ets");

    if (!datosTabla.length) {
        contenedor.innerHTML = `
            <div style='text-align:center; padding:40px; background:linear-gradient(135deg, rgba(0, 59, 142, 0.06) 0%, rgba(0, 86, 214, 0.04) 100%); 
            border:2px dashed rgba(100, 181, 246, 0.4); border-radius:12px; color:#0f6aa4; font-weight:500;'>
                <i class="fas fa-inbox" style="font-size:2rem; margin-bottom:10px; display:block;"></i>
                No hay resultados
            </div>
        `;
        document.getElementById("paginacion-ets").innerHTML = "";
        return;
    }

    mostrarPagina(1);
}

function mostrarPagina(numeroPagina) {
    paginaActual = numeroPagina;
    const inicio = (numeroPagina - 1) * registrosPorPagina;
    const fin = inicio + registrosPorPagina;
    const datosPagina = datosTabla.slice(inicio, fin);

    const contenedor = document.getElementById("tabla-ets");
    
    // Agregar clase de animación
    contenedor.classList.add("tabla-animada");
    
    // Remover la clase después de la animación para poder repetirla
    setTimeout(() => {
        contenedor.classList.remove("tabla-animada");
    }, 300);

    let html = `
    <div class="tabla-container">
        <table class="tabla-ets">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Materia</th>
                    <th>Carrera</th>
                    <th>Semestre</th>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Turno</th>
                    <th>Edificio</th>
                    <th>Salón</th>
                    <th>Profesor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
    `;

    datosPagina.forEach(e => {
        html += `
        <tr>
            <td><strong>#${e.id_examen}</strong></td>
            <td>${e.materia}</td>
            <td><span style="background:rgba(0, 86, 214, 0.1); padding:4px 8px; border-radius:6px; font-weight:600; color:#0056D6;">${e.carrera}</span></td>
            <td>${e.semestre}°</td>
            <td><strong>${e.fecha}</strong></td>
            <td>${e.hora_inicio} - ${e.hora_fin}</td>
            <td>${e.turno}</td>
            <td>${e.edificio}</td>
            <td>${e.salon}</td>
            <td>${e.profesor_evaluador}</td>
            <td>
                <button onclick="eliminar(${e.id_examen})" style="gap:6px;">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
                <button onclick="cargarParaEditar(${e.id_examen})" style="gap:6px;">
                    <i class="fas fa-edit"></i> Editar
                </button>
            </td>
        </tr>
        `;
    });

    html += "</tbody></table></div>";
    contenedor.innerHTML = html;

    generarPaginacion();
}

function generarPaginacion() {
    const totalPaginas = Math.ceil(datosTabla.length / registrosPorPagina);
    const contenedor = document.getElementById("paginacion-ets");

    if (totalPaginas <= 1) {
        contenedor.innerHTML = "";
        return;
    }

    let html = `
        <span class="paginacion-info">
            Página ${paginaActual} de ${totalPaginas} 
            <strong style="color:#003B8E;">(${datosTabla.length} registros)</strong>
        </span>

        <button class="paginacion-btn" onclick="mostrarPagina(1)" ${paginaActual === 1 ? 'disabled' : ''}>
            <i class="fas fa-chevron-left"></i> Inicio
        </button>
        <button class="paginacion-btn" onclick="mostrarPagina(${paginaActual - 1})" ${paginaActual === 1 ? 'disabled' : ''}>
            <i class="fas fa-chevron-left"></i> Anterior
        </button>

        <div class="paginacion-numeros">
    `;

    let inicio = Math.max(1, paginaActual - 2);
    let fin = Math.min(totalPaginas, paginaActual + 2);

    if (inicio > 1) {
        html += `<button class="paginacion-num" onclick="mostrarPagina(1)">1</button>`;
        if (inicio > 2) html += `<span style="padding:8px 4px; color:#999;">...</span>`;
    }

    for (let i = inicio; i <= fin; i++) {
        html += `<button class="paginacion-num ${i === paginaActual ? 'activo' : ''}" onclick="mostrarPagina(${i})">${i}</button>`;
    }

    if (fin < totalPaginas) {
        if (fin < totalPaginas - 1) html += `<span style="padding:8px 4px; color:#999;">...</span>`;
        html += `<button class="paginacion-num" onclick="mostrarPagina(${totalPaginas})">${totalPaginas}</button>`;
    }

    html += `
        </div>

        <button class="paginacion-btn" onclick="mostrarPagina(${paginaActual + 1})" ${paginaActual === totalPaginas ? 'disabled' : ''}>
            Siguiente <i class="fas fa-chevron-right"></i>
        </button>
        <button class="paginacion-btn" onclick="mostrarPagina(${totalPaginas})" ${paginaActual === totalPaginas ? 'disabled' : ''}>
            Final <i class="fas fa-chevron-right"></i>
        </button>
    `;

    contenedor.innerHTML = html;
}


// =====================
// ELIMINAR
// =====================
async function eliminar(id){

    Swal.fire({
        title: "¿Eliminar ETS?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DC2626",
        cancelButtonColor: "#6B7280",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar",
        background: "rgba(255, 255, 255, 0.85)",
        backdrop: "rgba(15, 23, 42, 0.5) url('')",
        didOpen: (modal) => {
            modal.style.backdropFilter = "blur(10px)";
        }
    }).then(async (result) => {
        if (result.isConfirmed) {
            await fetch("../php/eliminar.php?id=" + id);
            
            Swal.fire({
                title: "✔️ Eliminado",
                text: "ETS eliminado correctamente",
                icon: "success",
                confirmButtonColor: "#0056D6",
                confirmButtonText: "Aceptar",
                background: "rgba(255, 255, 255, 0.85)",
                backdrop: "rgba(15, 23, 42, 0.5) url('')",
                didOpen: (modal) => {
                    modal.style.backdropFilter = "blur(10px)";
                }
            });
            
            cargarETS();
        }
    });
}


// =====================
// EDITAR (MODAL)
// =====================
window.cargarParaEditar = async function(id) {

    idEditar = id;

    try {
        const res = await fetch("../php/obtener.php?id=" + id);
        const data = await res.json();

        const modal = document.getElementById("modalEditar");
        if (!modal) return;

        const set = (id, value) => {
            const el = document.getElementById(id);
            if (el) el.value = value ?? "";
        };

        set("edit_id", id);
        set("edit_materia", data.materia);
        set("edit_carrera", data.carrera);
        set("edit_semestre", data.semestre);
        set("edit_fecha", data.fecha);
        set("edit_turno", data.turno);
        set("edit_edificio", data.edificio);
        set("edit_salon", data.salon);
        set("edit_profesor", data.profesor_evaluador);
        set("edit_hora_inicio", data.hora_inicio); // si existe input

        modal.style.display = "flex";

        // ✅ RESALTAR CAMPOS VACÍOS
        resaltarCamposVacios();

    } catch (error) {
        console.log("ERROR MODAL:", error);
        alert("Error al cargar datos");
    }
};

// ✅ FUNCIÓN PARA RESALTAR CAMPOS VACÍOS
function resaltarCamposVacios() {
    const campos = [
        "edit_materia", "edit_carrera", "edit_semestre", "edit_fecha", 
        "edit_hora_inicio", "edit_turno", "edit_edificio", "edit_salon", "edit_profesor"
    ];

    campos.forEach(id => {
        const campo = document.getElementById(id);
        if (campo) {
            if (!campo.value || campo.value.trim() === "") {
                // Resaltar con borde rojo
                campo.style.borderColor = "#DC2626";
                campo.style.borderWidth = "2px";
                campo.style.boxShadow = "0 0 0 3px rgba(220, 38, 38, 0.1)";
            } else {
                // Remover resalte
                campo.style.borderColor = "";
                campo.style.borderWidth = "";
                campo.style.boxShadow = "";
            }
        }
    });
}


// =====================
// GUARDAR EDICIÓN
// =====================
async function guardarEdicion() {

    // ✅ VALIDAR QUE TODOS LOS CAMPOS ESTÉN LLENOS
    const id = document.getElementById("edit_id").value.trim();
    const materia = document.getElementById("edit_materia").value.trim();
    const carrera = document.getElementById("edit_carrera").value.trim();
    const semestre = document.getElementById("edit_semestre").value.trim();
    const fecha = document.getElementById("edit_fecha").value.trim();
    const hora_inicio = document.getElementById("edit_hora_inicio").value.trim();
    const turno = document.getElementById("edit_turno").value.trim();
    const edificio = document.getElementById("edit_edificio").value.trim();
    const salon = document.getElementById("edit_salon").value.trim();
    const profesor = document.getElementById("edit_profesor").value.trim();

    // Verificar que ningún campo esté vacío
    if (!materia || !carrera || !semestre || !fecha || !hora_inicio || !turno || !edificio || !salon || !profesor) {
        
        // Construir lista de campos faltantes
        let camposFaltantes = "";
        if (!materia) camposFaltantes += "• Materia\n";
        if (!carrera) camposFaltantes += "• Carrera\n";
        if (!semestre) camposFaltantes += "• Semestre\n";
        if (!fecha) camposFaltantes += "• Fecha\n";
        if (!hora_inicio) camposFaltantes += "• Hora de inicio\n";
        if (!turno) camposFaltantes += "• Turno\n";
        if (!edificio) camposFaltantes += "• Edificio\n";
        if (!salon) camposFaltantes += "• Salón\n";
        if (!profesor) camposFaltantes += "• Profesor Evaluador\n";
        
        Swal.fire({
            title: "⚠️ Campos Incompletos",
            text: "Por favor completa los siguientes campos:\n\n" + camposFaltantes,
            icon: "warning",
            confirmButtonColor: "#DC2626",
            confirmButtonText: "Entendido",
            background: "rgba(255, 255, 255, 0.95)",
            backdrop: "rgba(15, 23, 42, 0.5)",
            zIndex: 99999,
            didOpen: (modal) => {
                modal.style.backdropFilter = "blur(10px)";
                modal.style.zIndex = "99999";
                document.querySelector('.swal2-container').style.zIndex = "99999";
            }
        });
        return;
    }

    const datos = new FormData();

    datos.append("id", id);
    datos.append("materia", materia);
    datos.append("carrera", carrera);
    datos.append("semestre", semestre);
    datos.append("fecha", fecha);
    datos.append("turno", turno);
    datos.append("edificio", edificio);
    datos.append("salon", salon);
    datos.append("profesor", profesor);
    datos.append("hora_inicio", hora_inicio);
    
    const res = await fetch("../php/editar.php", {
        method: "POST",
        body: datos
    });

    const text = await res.text();

    if (text.includes("TRASLAPE")) {
        Swal.fire({
            title: "⚠️ Conflicto detectado",
            html: text,
            icon: "warning",
            confirmButtonColor: "#0056D6",
            confirmButtonText: "Entendido",
            background: "rgba(255, 255, 255, 0.85)",
            backdrop: "rgba(15, 23, 42, 0.5) url('')",
            didOpen: (modal) => {
                modal.style.backdropFilter = "blur(10px)";
            }
        });
        return;
    }

    Swal.fire({
        title: "✔️ ¡Actualizado!",
        text: "ETS editado correctamente",
        icon: "success",
        confirmButtonColor: "#0056D6",
        confirmButtonText: "Continuar",
        background: "rgba(255, 255, 255, 0.85)",
        backdrop: "rgba(15, 23, 42, 0.5) url('')",
        didOpen: (modal) => {
            modal.style.backdropFilter = "blur(10px)";
        }
    });

    cerrarModal();
    cargarETS();
}


// =====================
// MODAL
// =====================
function cerrarModal(){

    const modal = document.getElementById("modalEditar");

    if(modal){
        modal.style.display = "none";
    }
}


// =====================
// LIMPIAR
// =====================
function limpiarFormulario(){

    document.getElementById("carrera").value = "";
    document.getElementById("semestre").value = "";
    document.getElementById("materia").value = "";
    document.getElementById("fecha").value = "";
    document.getElementById("turno").value = "";
    document.getElementById("edificio").value = "";
    document.getElementById("salon").value = "";
    document.getElementById("profesor").value = "";
}


// =====================
// INICIO
// =====================
document.addEventListener("DOMContentLoaded", () => {
    cargarETS();
});

</script>

<!-- LOADER MODERNO -->
<script src="../loader.js"></script>

</body>
</html>
