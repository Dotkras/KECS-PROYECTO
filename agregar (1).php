<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: panel.php");
    exit();
}
include 'db.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Producto</title>
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
      padding: 15px 0;
      text-align: center;
      font-size: 1.5em;
      text-shadow: 1px 1px 3px black;
    }

    .titulo-principal {
      text-align: center;
      font-size: 2.8em;
      font-weight: bold;
      color: white;
      margin-top: 20px;
      margin-bottom: 15px;
      text-shadow: 2px 2px 6px black;
    }

    main {
      max-width: 500px;
      margin: 0 auto 40px auto;
      background: rgba(255, 255, 255, 0.9);
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .subtitulo {
      font-size: 1.2em;
      font-weight: bold;
      color: #333;
      margin-bottom: 20px;
      text-align: center;
    }

    label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
      color: #555;
    }

    input {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1em;
    }

    button {
      margin-top: 20px;
      width: 100%;
      background-color: #b30000;
      color: white;
      border: none;
      padding: 10px;
      font-size: 1em;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    button:hover {
      background-color: #ff1a1a;
    }

    .volver {
      margin-top: 15px;
      text-align: center;
    }

    .volver a {
      color: #007bff;
      text-decoration: none;
    }

    .volver a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <header>
    Gestión de Zapatería
  </header>

  <div class="titulo-principal">Zapatería Reynaldo</div>

  <main>
    <div class="subtitulo">Agregar Producto</div>
    <form method="post">
      <label for="nombre">Nombre:</label>
      <input type="text" name="nombre" id="nombre" required>

      <label for="talla">Talla:</label>
      <input type="text" name="talla" id="talla" required>

      <label for="precio">Precio:</label>
      <input type="number" name="precio" step="0.01" id="precio" required>

      <label for="stock">Stock:</label>
      <input type="number" name="stock" id="stock" required>

      <button type="submit">Guardar</button>
    </form>
    <div class="volver">
      <a href="panel.php">← Volver a la lista de productos</a>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $nombre = $_POST['nombre'];
      $talla = $_POST['talla'];
      $precio = $_POST['precio'];
      $stock = $_POST['stock'];

      $conn->query("INSERT INTO productos (nombre, talla, precio, stock)
                    VALUES ('$nombre', '$talla', $precio, $stock)");
      header("Location: panel.php");
      exit();
    }
    ?>
  </main>
</body>
</html>
