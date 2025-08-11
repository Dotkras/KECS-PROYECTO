<?php
session_start();
require_once 'db.php';

$mensajeLogin = "";
$mensajeRegistro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $usuario = trim($_POST['usuario']);
        $clave = md5($_POST['clave']);

        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave'";
        $resultado = $conn->query($sql);

        if ($resultado && $resultado->num_rows == 1) {
            $usuarioData = $resultado->fetch_assoc();

            $_SESSION['usuario'] = $usuarioData['usuario'];
            $_SESSION['rol'] = $usuarioData['rol'];

            session_write_close();
            header("Location: panel.php");
            exit();
        } else {
            $mensajeLogin = "Usuario o contraseña incorrectos";
        }
    } elseif (isset($_POST['registro'])) {
        $usuarioNuevo = trim($_POST['usuario_reg']);
        $claveNuevo = trim($_POST['clave_reg']);
        $claveHash = md5($claveNuevo);

        $checkUser = $conn->query("SELECT * FROM usuarios WHERE usuario = '$usuarioNuevo'");
        if ($checkUser && $checkUser->num_rows > 0) {
            $mensajeRegistro = "El usuario ya existe, elige otro nombre.";
        } else {
            $conn->query("INSERT INTO usuarios (usuario, clave, rol) VALUES ('$usuarioNuevo', '$claveHash', 'user')");
            $mensajeRegistro = "Usuario registrado correctamente. Ahora puedes iniciar sesión.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión / Registro</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      height: 100vh;
      padding-top: 40px;
      gap: 40px;

      background: linear-gradient(135deg, #1a1a1a, #b30000, #1a1a1a, #ff1a1a);
      background-size: 400% 400%;
      animation: moverFondo 8s ease infinite;
    }

    @keyframes moverFondo {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .titulo {
      font-size: 2.5em;
      font-weight: bold;
      color: white;
      text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
    }

    .contenedor-formularios {
      display: flex;
      gap: 40px;
    }

    .form-container {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 320px;
    }
    form {
      display: flex;
      flex-direction: column;
    }
    input, button {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      font-size: 1em;
    }
    button {
      cursor: pointer;
      background-color: #b30000;
      border: none;
      color: white;
      border-radius: 5px;
      transition: background-color 0.2s;
    }
    button:hover {
      background-color: #ff1a1a;
    }
    h2 {
      text-align: center;
      margin-bottom: 10px;
      color: #b30000;
    }
    .error {
      color: red;
      text-align: center;
      margin-top: 10px;
    }
    .success {
      color: green;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <div class="titulo">Zapatería Reynaldo</div>

  <div class="contenedor-formularios">
    <div class="form-container">
      <form method="POST">
        <h2>Iniciar Sesión</h2>
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="clave" placeholder="Contraseña" required>
        <button type="submit" name="login">Entrar</button>
        <?php if ($mensajeLogin): ?>
          <p class="error"><?= htmlspecialchars($mensajeLogin) ?></p>
        <?php endif; ?>
      </form>
    </div>

    <div class="form-container">
      <form method="POST">
        <h2>Registrar Usuario</h2>
        <input type="text" name="usuario_reg" placeholder="Nuevo usuario" required>
        <input type="password" name="clave_reg" placeholder="Nueva contraseña" required>
        <button type="submit" name="registro">Registrar</button>
        <?php if ($mensajeRegistro): ?>
          <p class="<?= strpos($mensajeRegistro, 'correctamente') !== false ? 'success' : 'error' ?>">
            <?= htmlspecialchars($mensajeRegistro) ?>
          </p>
        <?php endif; ?>
      </form>
    </div>
  </div>

</body>
</html>
