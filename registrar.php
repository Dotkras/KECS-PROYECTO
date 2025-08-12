<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

include 'db.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $usuario = trim($_POST['usuario']);
      $rol = $_POST['rol'];
      $claveHash = password_hash($_POST['clave'], PASSWORD_DEFAULT);

    $check = $conn->query("SELECT * FROM usuarios WHERE usuario = '$usuario'");
    if ($check->num_rows > 0) {
        $mensaje = "Ese usuario ya existe.";
    } else {
        $sql = "INSERT INTO usuarios (usuario, clave, rol) VALUES ('$usuario', '$claveHash', '$rol')";
        if ($conn->query($sql)) {
            $mensaje = "Usuario creado correctamente.";
        } else {
            $mensaje = "Error al crear usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Usuario</title>
  <style>
    body { font-family: Arial; background-color: #f2f2f2; padding: 40px; }
    form {
      max-width: 400px; margin: auto; background: white;
      padding: 30px; border-radius: 10px; box-shadow: 0 0 10px #ccc;
    }
    input, select, button {
      width: 100%; padding: 10px; margin: 10px 0;
    }
    .mensaje {
      text-align: center; font-weight: bold; color: green;
    }
  </style>
</head>
<body>
  <form method="POST">
    <h2>Registrar Usuario</h2>
    <input type="text" name="usuario" placeholder="Usuario" required>
    <input type="password" name="clave" placeholder="Contraseña" required>
    <select name="rol" required>
      <option value="normal">Usuario normal</option>
      <option value="admin">Administrador</option>
    </select>
    <button type="submit">Crear usuario</button>
    <?php if ($mensaje): ?>
      <p class="mensaje"><?= $mensaje ?></p>
    <?php endif; ?>
  </form>
</body>
</html>

