<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css">
    <title>Menú de Navegación</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 0;
        }

        main{
            padding: 5%
        }

        nav {
            display: flex;
            justify-content: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }

        nav a:hover {
            background-color: #575757;
        }

        .menu {
            display: flex;
            gap: 20px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="menu">
                <a href="./dashboard">Inicio</a>
                <a href="./agregar">Agregar tarea <i class="fa-solid fa-plus"></i></a>
                <button type="button" class="btn btn-success" onclick="logout()">Logout <i class="fa-solid fa-power-off"></i></button>
            </div>
        </nav>
    </header>
    <main>
        <?php $categs = json_decode($categs, true); ?>

    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Nivel</th>
                <th>Fecha de Vencimiento</th>
                <th>Categoría

                <select id="filtroCategoria" onchange="filtrarPorCategoria()">
                            <option value="">Todas</option>
                            <?php foreach ($categs as $categoria) { ?>
                                <option value="<?php echo htmlspecialchars($categoria['nombre']); ?>">
                                    <?php echo htmlspecialchars($categoria['nombre']); ?>
                                </option>
                            <?php } ?>
                        </select>
                </th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
                <?php 
                $tareas = json_decode($tareas, true);

                function vencida($dateStr){
                $date = new DateTime();
                $ndate = DateTime::createFromFormat('Y-m-d', $dateStr);
                return ($date > $ndate);
                }

                foreach ($tareas as $tarea){ 

                    foreach ($categs as $categoria) {
                        if ($categoria['id'] == $tarea['categoria_id']) {
                            $categoriaNombre = $categoria['nombre'];
                            break;
                        }
                    }
                    

                    echo '<tr data-categoria="' . htmlspecialchars($categoriaNombre) . '">';
                    echo '<td>' . htmlspecialchars($tarea['nombre']) . '</td>';
                    echo '<td>' . htmlspecialchars($tarea['descripcion']) . '</td>';
                    echo '<td>' . htmlspecialchars($tarea['estado'] == 0 ? 'Pendiente': 'Terminada') . '</td>';
                    echo '<td>' . htmlspecialchars($tarea['nivel'] == 1 ? 'Bajo': ($tarea['nivel'] == 2 ? 'Medio' : 'Alto')) . '</td>';
                    echo '<td>';
                    if (vencida($tarea['fecha_vencimiento']) == true) echo '<span style="color: red">'.htmlspecialchars($tarea['fecha_vencimiento']).'</span>'; 
                    else  echo htmlspecialchars($tarea['fecha_vencimiento']) ;
                    echo  '</td>';
                    echo '<td>' . htmlspecialchars($categoriaNombre) . '</td>';
                    echo '<td>';
                    echo '<a class="like" href="./editar?id='.$tarea['id'].'" title="Editar"><i class="fa fa-pen"></i></a>  ';
                    echo '<a href="javascript:eliminarTarea('.$tarea['id'].')" class="remove" title="Eliminar"><i class="fa fa-trash"></i></a>  ';
                    if ($tarea['estado'] == 0) {
                        echo '<a href="javascript:terminarTarea('.$tarea['id'].')" class="remove" title="Terminar"><i class="fa fa-check"></i></a>';
                    }
                    echo '</tr>';
                };
                ?>
        </tbody>
    </table>
    </main>
</body>
</html>

<script>
    function eliminarTarea(tareaId) {
        if (confirm('¿Estás seguro de que deseas eliminar esta tarea?')) {
            const data = {
            id: tareaId
            }
            fetch('/tst_smc/api/tareas', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => {
                if (response.ok) {
                    alert('Tarea eliminada correctamente');
                    location.reload(); 
                } else {
                    alert('Error al eliminar la tarea');
                }
            })
            .catch(error => {
                alert('Error al eliminar la tarea');
            });
        }
    }

    function terminarTarea(tareaId) {
        const data = {
            id: tareaId
        }
        fetch('/tst_smc/api/finalizar_tarea', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => {
            if (response.ok) {
                alert('Tarea terminada correctamente');
                location.reload(); 
            } else {
                alert('Error al terminar la tarea');
            }
        })
        .catch(error => {
            alert('Error al terminar la tarea');
        });
    }
        function filtrarPorCategoria() {
            const categoriaSeleccionada = document.getElementById('filtroCategoria').value;
            const filas = document.querySelectorAll('tbody tr');

            filas.forEach(fila => {
                const categoria = fila.getAttribute('data-categoria');
                
                if (categoriaSeleccionada === '' || categoria === categoriaSeleccionada) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        }
window.onload = function() {
    var userData = JSON.parse(localStorage.getItem('userData'));
    if (userData) {
        console.log("Usuario esta loguedo:", userData);
    } else {
        console.log("No se encontraron datos del usuario.");
        window.location.href = "./";


    }
};

function logout() {
        localStorage.removeItem('userData');
        location.reload();
        }
</script>