<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css">

    <title>Login y Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            text-align: center;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .form-toggle {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 id="form-title">Iniciar sesión</h2>
        <div id="login-form">
        <form id="login" onsubmit="submitLogin(event)">
                <input type="text" id="login-name" placeholder="Nombre completo" required>
                <input type="password" id="login-password" placeholder="Contraseña" required>
                <button type="submit">Iniciar sesión</button>
            </form>
        </div>

        <div id="register-form" style="display: none;">
            <form id="register" onsubmit="submitRegister(event)">
                <input type="text" id="register-name" placeholder="Nombre completo" required>
                <input type="email" id="register-email" placeholder="Correo electrónico" required>
                <input type="password" id="register-password" placeholder="Contraseña" required>
                <button type="submit">Registrar</button>
            </form>
        </div>

        <div class="form-toggle">
            <span id="toggle-text">¿No tienes cuenta? <a href="javascript:void(0)" onclick="toggleForms()">Registrate</a></span>
        </div>
    </div>

    <script>
        function toggleForms() {
            var loginForm = document.getElementById("login-form");
            var registerForm = document.getElementById("register-form");
            var title = document.getElementById("form-title");
            var toggleText = document.getElementById("toggle-text");

            if (loginForm.style.display === "none") {
                loginForm.style.display = "block";
                registerForm.style.display = "none";
                title.textContent = "Iniciar sesión";
                toggleText.innerHTML = '¿No tienes cuenta? <a href="javascript:void(0)" onclick="toggleForms()">Registrate</a>';
            } else {
                loginForm.style.display = "none";
                registerForm.style.display = "block";
                title.textContent = "Registrarse";
                toggleText.innerHTML = '¿Ya tienes cuenta? <a href="javascript:void(0)" onclick="toggleForms()">Iniciar sesión</a>';
            }
        }

        function submitLogin(event) {
        event.preventDefault();
        var name = document.getElementById("login-name").value;
        var password = document.getElementById("login-password").value;
        console.log(password);
        fetch("./api/users/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                username: name, 
                password: password
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Credenciales inválidas");
            }
            return response.json();
        })
        .then(data => {
            if (data && data.user) {
                alert("Inicio de sesión exitoso");
                console.log("Usuario:", data.user); 
                //localStorage.setItem('userData', JSON.stringify(data.user));
                window.location.href = "./dashboard";
            }
        })
        .catch(error => {
            console.error("Error al iniciar sesión:", error);
            alert("Correo o contraseña incorrectos o hubo un error al iniciar sesión");
        });
    }

    function submitRegister(event) {
        event.preventDefault();
        var name = document.getElementById("register-name").value;
        var email = document.getElementById("register-email").value;
        var password = document.getElementById("register-password").value;

        var user = {
            name: name,
            email: email,
            password: password
        };

        fetch("./api/users", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(user)
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === "Usuario creado") {
                alert("Registro exitoso. Ahora puedes iniciar sesión.");
                toggleForms(); 
            } else {
                alert("Hubo un error al registrar el usuario");
            }
        })
        .catch(error => {
            console.log(user);
            console.error('Error al registrar el usuario:', error);
            alert("Hubo un error al intentar registrar el usuario");
        });
    }

        // Función para verificar la contraseña
        function verifyPassword(inputPassword, storedPassword) {
            return inputPassword === storedPassword; 
        }
    </script>

</body>
</html>
