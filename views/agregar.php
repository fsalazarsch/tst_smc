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
                <a href="./logout">Logout <i class="fa-solid fa-power-off"></i></a>
            </div>
        </nav>
    </header>
    <main>

    <form id="taskForm">
        
        <div class="form-group">
            <label for="nombre">Nombre de la Tarea:</label>
            <input class="form-control" type="text" id="nombre" name="nombre" required><br>
        </div>
        
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea><br>
        </div>
        <div class="form-group">
        <label for="estado">Estado:</label>
        <select class="form-control" id="estado" name="estado" required>
            <option value="0">Pendiente</option>
            <option value="1">Terminada</option>
        </select><br>
        </div>

        <div class="form-group">
        <label for="nivel">Nivel de la Tarea:</label>
            <select class="form-control"  id="nivel" name="nivel" required>
                <option value="1">Bajo</option>
                <option value="2">Medio</option>
                <option value="3">Alto</option>
            </select><br>
        </div>
        
        <div class="form-group">
            <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
            <input class="form-control" type="date" id="fecha_vencimiento" name="fecha_vencimiento" required><br>
        </div>

        <div class="form-group">
        <label for="categoria_id">Categoría:</label>
        <select class="form-control" id="categoria_id" name="categoria_id" required>
            <?php
                $categs = json_decode($categs, true);
                foreach ($categs as $categoria) {
                    echo "<option value='" . htmlspecialchars($categoria['id']) . "'>" . htmlspecialchars($categoria['nombre']) . "</option>";
                }
            ?>
        </select><br><br>
            </div>

        <button type="submit" class="btn btn-primary">Agregar</button>
    </form>
    </main>
</body>
</html>

<script>
document.getElementById("taskForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const data = {
        nombre: formData.get('nombre'),
        descripcion: formData.get('descripcion'),
        estado: formData.get('estado'),
        nivel: formData.get('nivel'),
        fecha_vencimiento: formData.get('fecha_vencimiento'),
        categoria_id: formData.get('categoria_id')
    };

    fetch('/tst_smc/api/tareas', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        alert('Tarea agregada correctamente');
        window.location.href = "./dashboard";
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
</script>
<script>

window.onload = function() {
    //var userData = JSON.parse(localStorage.getItem('userData'));
    //if (userData) {
    //    console.log("Datos del usuario:", userData);
    //} else {
    //    console.log("No se encontraron datos del usuario.");
    //}
};
</script>
