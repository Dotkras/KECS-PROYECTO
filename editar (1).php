<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: panel.php");
    exit();
}

include 'db.php';

// Validar y sanitizar ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: panel.php");
    exit();
}

$id = intval($_GET['id']);

// Obtener producto
$producto = $conn->query("SELECT * FROM productos WHERE id=$id")->fetch_assoc();

if (!$producto) {
    header("Location: panel.php");
    exit();
}

// Actualizar producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $talla = $conn->real_escape_string($_POST['talla']);
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);

    $conn->query("UPDATE productos 
                  SET nombre='$nombre', talla='$talla', precio=$precio, stock=$stock 
                  WHERE id=$id");

    header("Location: panel.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Producto</title>
  <style>
    /* Fondo degradado animado rojo y negro */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(-45deg, #ff0000, #000000, #ff0000, #000000);
      background-size: 400% 400%;
      animation: gradient 10s ease infinite;
    }
    @keyframes gradient {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    header {
      background-color: rgba(0,0,0,0.85);
      color: white;
      padding: 20px;
      text-align: center;
      text-shadow: 1px 1px 3px black;
    }

    .titulo-principal {
      text-align: center;
      font-size: 2.8em;
      font-weight: bold;
      color: white;
      margin: 20px 0 15px 0;
      text-shadow: 2px 2px 6px black;
    }

    main {
      max-width: 600px;
      margin: 0 auto 30px auto;
      padding: 20px;
      background-color: rgba(255,255,255,0.9);
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
      border-radius: 8px;
    }

    .subtitulo {
      font-size: 1.3em;
      color: #6c757d;
      text-align: center;
      margin-bottom: 25px;
      font-weight: bold;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-top: 10px;
      font-weight: bold;
      color: #555;
    }

    input {
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ced4da;
      border-radius: 4px;
      font-size: 1em;
    }

    button {
      margin-top: 20px;
      padding: 10px;
      background-color: #b30000;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s;
    }
    button:hover {
      background-color: #ff1a1a;
    }

    .volver {
      display: inline-block;
      margin-top: 20px;
      text-align: center;
      width: 100%;
    }

    .volver a {
      text-decoration: none;
      color: #007bff;
    }
    .volver a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <header>
    <h1>Gestión de Zapatería</h1>
  </header>

  <div class="titulo-principal">Zapatería Reynaldo</div>

  <main>
    <div class="subtitulo">Editar Producto</div>
    <form method="post">
      <label for="nombre">Nombre:</label>
      <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>

      <label for="talla">Talla:</label>
      <input type="text" name="talla" id="talla" value="<?= htmlspecialchars($producto['talla']) ?>" required>

      <label for="precio">Precio:</label>
      <input type="number" name="precio" step="0.01" id="precio" value="<?= $producto['precio'] ?>" required>

      <label for="stock">Stock:</label>
      <input type="number" name="stock" id="stock" value="<?= $producto['stock'] ?>" required>

      <button type="submit">Actualizar</button>
    </form>
    <div class="volver">
      <a href="panel.php">← Volver a la lista de productos</a>
    </div>
  </main>
</body>
</html>
